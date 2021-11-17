<?php

namespace App\Lib\Firestore;

use Closure;
use Exception;
use Google\Cloud\Firestore\CollectionReference;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Firestore\Query;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use InvalidArgumentException;

class Builder
{
    /**
     * Collection name.
     *
     * @var string
     */
    public string $collectionName;

    /**
     * The database connection instance.
     *
     * @var FirestoreClient
     */
    public FirestoreClient $connection;

    /**
     * The base query builder instance.
     * @var Query $query
     */
    public Query $query;

    /**
     * The current query value bindings.
     *
     * @var array
     */
    public array $bindings = [
        'select' => [],
        'from'   => [],
        'join'   => [],
        'where'  => [],
        'having' => [],
        'order'  => [],
        'union'  => [],
    ];

    /**
     * All of the available clause operators.
     *
     * @var array
     */
    public array $operators = [
        '<',
        '<=',
        '>',
        '>=',
        '=',
        '==',
        '===',
        'array-contains',
    ];

    /**
     * The model being queried.
     *
     * @var Model
     */
    protected Model $model;

    /**
     * Document name.
     *
     * @var string
     */
    protected string $document;

    /**
     * The where constraints for the query.
     *
     * @var array
     */
    protected array $wheres = [];

    /**
     * The orderings for the query.
     *
     * @var array
     */
    protected array $orders = [];

    /**
     * The maximum number of records to return.
     *
     * @var int
     */
    public int $limit;

    /**
     * Create a new query builder instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->connection = app('firebase.firestore')->database();
    }

    /**
     * @param Model $model
     * @return $this
     */
    public function setModel(Model $model)
    {
        $this->model = $model;
        $this->collection($model->getCollectionName());

        return $this;
    }

    public function document($document)
    {
        $this->document = $document;

        return $this;
    }

    /**
     * @param string $collection
     * @return $this
     */
    public function collection(string $collection)
    {
        $this->collectionName = $collection;

        return $this;
    }

    /**
     * Set the "limit" value of the query.
     *
     * @param int $value
     * @return $this
     */
    public function limit($value)
    {
        if ($value >= 0) {
            $this->limit = $value;
        }

        return $this;
    }

    /**
     * Execute the query as a "select" statement.
     *
     * @return Collection
     * @throws Exception
     */
    public function get()
    {
        $models = $this->getModels();

        return $this->getModel()->newCollection($models);
    }

    /**
     * Get the hydrated models without eager loading.
     *
     * @return \Illuminate\Database\Eloquent\Model[]|static[]
     * @throws Exception
     */
    public function getModels()
    {
        $items = $this->runQuery();

        return $this->model->hydrate(
            $items
        )->all();
    }

    /**
     * Get the model instance being queried.
     *
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Get the current query value bindings in a flattened array.
     *
     * @return array
     */
    public function getBindings()
    {
        return Arr::flatten($this->bindings);
    }

    /**
     * @return array|array[]|null[]
     * @throws Exception
     */
    protected function runQuery()
    {
        $this->buildCollectionQuery();

        $documents = $this->query->documents();

        if ($documents->isEmpty()) {
            return [];
        }

        return array_map(
            function ($snapshot) {
                return array_merge(
                    $snapshot->data(),
                    ['id' => $snapshot->id()],
                );
            },
            $documents->rows()
        );
    }

    /**
     * Build Query Collection
     *
     * @throws Exception
     */
    public function buildCollectionQuery(): CollectionReference|Query
    {
        $this->query = $this
            ->connection
            ->collection($this->collectionName);

        $this->buildOrderBy()
             ->buildLimit()
             ->buildWheres();

        return $this->query;
    }

    /**
     * Add an "order by" clause to the query.
     *
     * @return $this
     */
    public function buildOrderBy(): static
    {
        if (!empty($this->orders)) {
            foreach ($this->orders as $order) {
                $this->query = $this->query->orderBy($order['column'], strtoupper($order['direction']));
            }
        }

        return $this;
    }

    /**
     * Add an "limit" clause to the query.
     *
     * @return $this
     */
    public function buildLimit()
    {
        if (!empty($this->limit)) {
            $this->query = $this->query->limit($this->limit);
        }

        return $this;
    }

    /**
     * Add an "wbere" clause to the query.
     *
     * @return $this
     * @throws Exception
     */
    public function buildWheres()
    {
        if (!empty($this->wheres)) {
            foreach ($this->wheres as $where) {
                switch ($where['type']) {
                    case 'NotNull':
                        $this->query = $this->query->where($where['column'], '>', '');
                        break;
                    case 'Basic':
                        $this->query = $this->query->where($where['column'], $where['operator'], $where['value']);
                        break;
                    case 'InArray':
                        $this->query = $this->query->where($where['column'], 'array-contains', $where['value']);
                        break;
                    default:
                        throw new Exception('Unsupported query type ' . $where['type']);
                        break;
                }
            }
        }

        return $this;
    }

    /**
     * Get a new query
     */
    public function newQuery()
    {
        $this->connection = app('firebase.firestore')->database();

        return $this;
    }

    /**
     * Add a basic where clause to the query.
     *
     * @param array|Closure|string $column
     * @param mixed|null $operator
     * @param mixed|null $value
     * @param string $boolean
     * @return $this
     */
    public function where(array|Closure|string $column, mixed $operator = null, mixed $value = null, string $boolean = 'and')
    {
        // If the column is an array, we will assume it is an array of key-value pairs
        // and can add them each as a where clause. We will maintain the boolean we
        // received when the method was called and pass it into the nested where.
        if (is_array($column)) {
            return $this->addArrayOfWheres($column, $boolean);
        }

        // Here we will make some assumptions about the operator. If only 2 values are
        // passed to the method, we will assume that the operator is an equals sign
        // and keep going. Otherwise, we'll require the operator to be passed in.
        [$value, $operator] = $this->prepareValueAndOperator(
            $value,
            $operator,
            func_num_args() === 2
        );

        // If the columns is actually a Closure instance, we will assume the developer
        // wants to begin a nested where statement which is wrapped in parenthesis.
        // We'll add that Closure to the query then return back out immediately.
        if ($column instanceof Closure) {
            return $this->whereNested($column, $boolean);
        }

        // If the given operator is not found in the list of valid operators we will
        // assume that the developer is just short-cutting the '=' operators and
        // we will set the operators to '=' and set the values appropriately.
        if ($this->invalidOperator($operator)) {
            [$value, $operator] = [$operator, '='];
        }

        // If the value is a Closure, it means the developer is performing an entire
        // sub-select within the query and we will need to compile the sub-select
        // within the where clause to get the appropriate query record results.
        if ($value instanceof Closure) {
            return $this->whereSub($column, $operator, $value, $boolean);
        }

        // If the value is "null", we will just assume the developer wants to add a
        // where null clause to the query. So, we will allow a short-cut here to
        // that method for convenience so the developer doesn't have to check.
        if (is_null($value)) {
            return $this->whereNull($column, $boolean, $operator !== '=');
        }

        $type = 'Basic';

        // If the column is making a JSON reference we'll check to see if the value
        // is a boolean. If it is, we'll add the raw boolean string as an actual
        // value to the query to ensure this is properly handled by the query.
        if (Str::contains($column, '->') && is_bool($value)) {
            $value = new Expression($value ? 'true' : 'false');

            if (is_string($column)) {
                $type = 'JsonBoolean';
            }
        }

        // Now that we are working with just a simple query we can put the elements
        // in our array and add the query binding to our array of bindings that
        // will be bound to each SQL statements when it is finally executed.
        $this->wheres[] = compact(
            'type',
            'column',
            'operator',
            'value',
            'boolean'
        );

        if (!$value instanceof Expression) {
            $this->addBinding($value, 'where');
        }

        return $this;
    }

    /**
     * Add an array of where clauses to the query.
     *
     * @param array $column
     * @param string $boolean
     * @param string $method
     * @return $this
     */
    protected function addArrayOfWheres($column, $boolean, $method = 'where')
    {
        return $this->whereNested(function ($query) use ($column, $method, $boolean) {
            foreach ($column as $key => $value) {
                if (is_numeric($key) && is_array($value)) {
                    $query->{$method}(...array_values($value));
                } else {
                    $query->$method($key, '=', $value, $boolean);
                }
            }
        }, $boolean);
    }

    /**
     * Add a nested where statement to the query.
     *
     * @param Closure $callback
     * @param string $boolean
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function whereNested(Closure $callback, $boolean = 'and')
    {
        call_user_func($callback, $query = $this->forNestedWhere());

        return $this->addNestedWhereQuery($query, $boolean);
    }

    /**
     * Add a full sub-select to the query.
     *
     * @param string $column
     * @param string $operator
     * @param Closure $callback
     * @param string $boolean
     * @return $this
     */
    protected function whereSub($column, $operator, Closure $callback, $boolean)
    {
        $type = 'Sub';

        // Once we have the query instance we can simply execute it so it can add all
        // of the sub-select's conditions to itself, and then we can cache it off
        // in the array of where clauses for the "main" parent query instance.
        call_user_func($callback, $query = $this->forSubQuery());

        $this->wheres[] = compact(
            'type',
            'column',
            'operator',
            'query',
            'boolean'
        );

        $this->addBinding($query->getBindings(), 'where');

        return $this;
    }

    /**
     * Get the raw array of bindings.
     *
     * @return array
     */
    public function getRawBindings()
    {
        return $this->bindings;
    }

    /**
     * Create a new query instance for a sub-query.
     *
     * @return Builder
     */
    protected function forSubQuery()
    {
        return $this->newQuery();
    }

    /**
     * Create a new query instance for nested where condition.
     *
     * @return Builder
     */
    public function forNestedWhere()
    {
        return $this->newQuery()->collection($this->collectionName);
    }

    /**
     * Add another query builder as a nested where to the query builder.
     *
     * @param Builder|static $query
     * @param string $boolean
     * @return $this
     */
    public function addNestedWhereQuery($query, $boolean = 'and')
    {
        if (count($query->wheres)) {
            $type = 'Nested';

            $this->wheres[] = compact('type', 'query', 'boolean');

            $this->addBinding($query->getRawBindings()['where'], 'where');
        }

        return $this;
    }

    /**
     * Add a "where null" clause to the query.
     *
     * @param string $column
     * @param string $boolean
     * @param bool $not
     * @return $this
     */
    public function whereNull($column, $boolean = 'and', $not = false)
    {
        $type = $not ? 'NotNull' : 'Null';

        $this->wheres[] = compact('type', 'column', 'boolean');

        return $this;
    }

    /**
     * Add a "where not null" clause to the query.
     *
     * @param string $column
     * @param string $boolean
     * @return Builder
     */
    public function whereNotNull($column, $boolean = 'and')
    {
        return $this->whereNull($column, $boolean, true);
    }

    /**
     * Add a binding to the query.
     *
     * @param mixed $value
     * @param string $type
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function addBinding($value, $type = 'where')
    {
        if (!array_key_exists($type, $this->bindings)) {
            throw new InvalidArgumentException("Invalid binding type: {$type}.");
        }

        if (is_array($value)) {
            $this->bindings[$type] = array_values(array_merge($this->bindings[$type], $value));
        } else {
            $this->bindings[$type][] = $value;
        }

        return $this;
    }

    /**
     * Prepare the value and operator for a where clause.
     *
     * @param string|null $value
     * @param mixed $operator
     * @param bool $useDefault
     * @return array
     *
     */
    public function prepareValueAndOperator(string|null $value, mixed $operator, bool $useDefault = false): array
    {
        if ($useDefault) {
            return [$operator, '='];
        } elseif ($this->invalidOperatorAndValue($operator, $value)) {
            throw new InvalidArgumentException('Illegal operator and value combination.');
        }

        return [$value, $operator];
    }

    /**
     * Determine if the given operator and value combination is legal.
     *
     * Prevents using Null values with invalid operators.
     *
     * @param string $operator
     * @param mixed $value
     * @return bool
     */
    protected function invalidOperatorAndValue($operator, $value)
    {
        return is_null($value) && in_array($operator, $this->operators) &&
            !in_array($operator, ['=', '<>', '!=']);
    }

    /**
     * Determine if the given operator is supported.
     *
     * @param string $operator
     * @return bool
     */
    protected function invalidOperator($operator)
    {
        return !in_array(strtolower($operator), $this->operators, true);
    }

    /**
     * Execute a query for a single record by ID.
     *
     * @param string $id
     * @return Model|null
     */
    public function find(string $id): ?Model
    {
        $snapshot = $this
            ->connection
            ->collection($this->collectionName)
            ->document($id)
            ->snapshot();

        return $snapshot->exists() ?
            $this->newModelInstance(
                array_merge(
                    $snapshot->data(),
                    ['id' => $snapshot->id()],
                )
            )
            : null;
    }

    /**
     * Determine if any rows exist for the current query.
     *
     * @return bool
     * @throws Exception
     */
    public function exists(): bool
    {
        $this->limit(1);
        $documents = $this->buildCollectionQuery()->documents();

        if ($documents->isEmpty()) {
            return false;
        }

        return true;
    }

    /**
     * Update a record in the database.
     *
     * @param array $values
     * @param string $document
     * @return array
     */
    public function update(array $values, string $document): array
    {
        $formatter = function ($key, $value) {
            return ['path' => $key, 'value' => $value];
        };

        $data = $this->arrayMapAssoc($formatter, $values);

        return $this
            ->connection
            ->collection($this->collectionName)
            ->document($document)
            ->update($data);
    }

    public function arrayMapAssoc(callable $func, array $a): array
    {
        return array_map($func, array_keys($a), $a);
    }

    /**
     * Insert a new record and get the value of the primary key.
     *
     * @param array $values
     * @return string
     */
    public function insertGetId(array $values): string
    {
        $docRef = $this
            ->connection
            ->collection($this->collectionName)
            ->add($values);

        return $docRef->id();
    }

    /**
     * Insert a new record with specific ID.
     *
     * @param array $values
     * @param $id
     * @return string
     */
    public function insertWithId(array $values, $id): string
    {
        $this->connection
            ->collection($this->collectionName)
            ->document($id)
            ->set($values);

        return $id;
    }

    /**
     * Insert a new record into the database.
     *
     * @param array $values
     * @return bool
     */
    public function insert(array $values)
    {
        // Since every insert gets treated like a batch insert, we will make sure the
        // bindings are structured in a way that is convenient when building these
        // inserts statements by verifying these elements are actually an array.
        if (empty($values)) {
            return true;
        }

        if (!is_array(reset($values))) {
            $values = [$values];
        }
        // Here, we will sort the insert keys for every record so that each insert is
        // in the same order for the record. We need to make sure this is the case
        // so there are not any errors or problems when inserting these records.
        else {
            foreach ($values as $key => $value) {
                ksort($value);

                $values[$key] = $value;
            }
        }

        foreach ($values as $value) {
            $this
                ->connection
                ->collection($this->collectionName)
                ->add($value);
        }

        return true;
    }

    /**
     * Execute the query and get the first result.
     *
     * @return Model|object|static|null
     * @throws Exception
     */
    public function first()
    {
        return $this->limit(1)->get()->first();
    }

    /**
     * Create a collection of models from plain arrays.
     *
     * @param array $items
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function hydrate(array $items)
    {
        $instance = $this->newModelInstance();

        return $instance->newCollection(array_map(function ($item) use ($items, $instance) {
            return $instance->newFromBuilder($item);
        }, $items));
    }

    /**
     * Create a new instance of the model being queried.
     *
     * @param array $attributes
     * @return Model
     */
    public function newModelInstance(array $attributes = []): Model
    {
        return $this->model->newInstance($attributes);
    }

    /**
     * Get doc reference
     *
     * @param string $docId
     * @return DocumentReference
     */
    public function getDocumentReference(string $docId): DocumentReference
    {
        return $this
            ->connection
            ->collection($this->collectionName)
            ->document($docId);
    }

    public function delete(string $docId): array
    {
        return $this
            ->connection
            ->collection($this->collectionName)
            ->document($docId)
            ->delete();
    }
}

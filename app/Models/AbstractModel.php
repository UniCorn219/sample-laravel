<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbstractModel extends Model
{
    use HasFactory;

    const PAGINATE_LIMIT_DEFAULT = 10;

    /**
     * Is get original
     *
     * @var bool
     */
    protected $isGetOriginal = false;

    /**
     * @param bool $value
     * @return $this
     */
    public function setIsGetOriginal($value = false)
    {
        $this->isGetOriginal = $value;

        return $this;
    }

    /**
     * Return a timestamp as DateTime object.
     *
     * @param  mixed  $value
     * @return \Illuminate\Support\Carbon
     */
    protected function asDateTime($value)
    {
        // If this value is an integer, we will assume it is a UNIX timestamp's value
        // and delegate it immediately to the parent
        if (is_numeric($value)) {
            return parent::asDateTime($value);
        }

        // Flag to prevent creating a \DateTime from a string and then later
        // cloning it unnecessarily
        $justCreated = false;

        if (!($value instanceof \DateTime)) {
            $value = new \DateTime($value);
            $justCreated = true;
        }

        if ($value->getTimezone()->getName() !== config('app.timezone')) {
            if (!$justCreated) {
                $value = clone $value;
            }
            $value->setTimezone(new \DateTimeZone(config('app.timezone')));
        }

        return parent::asDateTime($value);
    }
}

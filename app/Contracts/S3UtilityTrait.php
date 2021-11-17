<?php

namespace App\Contracts;

/**
 * Trait S3UtilityTrait.
 *
 * @package App\Contracts
 */
trait S3UtilityTrait
{
    /**
     * Get S3 Key by type.
     *
     * @param $filename
     * @param $type
     * @param null $id
     * @return string
     */
    public function getKeyByType($filename, $type, $id = null)
    {
        return !empty($id)
            ? strtr(':type/:id/:filename', [
                ':id'       => $id,
                ':type'     => $type,
                ':filename' => $filename
            ])
            : strtr(':type/:filename', [
                ':type'     => $type,
                ':filename' => $filename
            ]);
    }
}

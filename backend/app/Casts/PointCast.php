<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class PointCast implements CastsAttributes
{
    /**
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return array{lat:float,lng:float}
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        $value = $model->getAttributeValue("{$key}_text");

        if (is_null($value)) {
            return [
                'lat' => null,
                'lng' => null,
            ];
        }

        if (is_string($value)) {
            $value = json_decode($value, true);
        }

        return [
            'lat' => $value['coordinates'][0],
            'lng' => $value['coordinates'][1],
        ];
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return $value;
    }
}

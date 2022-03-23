<?php

namespace app\includes;

abstract class Model
{
    /**
     * Take any input data and assign to property of the Child Model
     *
     */
    public function loadData($data): void
    {
        foreach ($data as $key => $value) {
            //  Check if each property exists, and assigns to properties of the Child Model
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
//                var_dump($this->{$key});
            }
        }
    }

    /**
     * Define labels corresponds to each attribute and display to the user
     *
     */
    public function labels(): array {
        return [];
    }

    /**
     * Get label for the given attribute
     *
     */
    public function getLabel($attribute)
    {
        return $this->labels()[$attribute] ?? $attribute;
    }
}
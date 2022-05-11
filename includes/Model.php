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
//                if ($this->$key instanceof DbModel) {
                if (is_object($this->$key)) {
                    $key_class = get_class($this->$key);
                    $this->{$key} = new $key_class();
                } else {
                    $this->{$key} = $value;
                }
            }
        }
    }

    /**
     * Define labels corresponds to each attribute which will be displayed to the user
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
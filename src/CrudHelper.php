<?php

namespace JustinMoh\BackpackHelper;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

/**
 * Class CrudConstructor
 * @package JustinMoh\BackpackHelper
 */
abstract class CrudHelper implements Arrayable
{
    const YES_NO_OPTIONS = [1 => 'Yes', 0 => 'No'];

    protected $type;
    protected $label;
    protected $name;

    protected $attributes = [];
    protected $wrapper = [];

    protected $crudConfigs = [];

    /** @var callable $filterOptions */
    protected $filterOptions = false;


    public function __construct($type = 'text')
    {
        $this->type = $type;
    }


    /**
     * @param  string  $prefix
     *
     * @return $this
     */
    public function prefix(string $prefix)
    {
        $this->mergeConfigs(['prefix' => $prefix]);

        return $this;
    }


    /**
     * @param  string  $modelClass
     *
     * @return $this
     */
    public function model(string $modelClass)
    {
        $this->mergeConfigs(['model' => $modelClass]);

        return $this;
    }


    /**
     * @param  string  $foreignKeyAttribute
     *
     * @return $this
     */
    public function attribute(string $foreignKeyAttribute)
    {
        $this->mergeConfigs(['attribute' => $foreignKeyAttribute]);

        return $this;
    }


    /**
     * @param  string  $relationMethod
     *
     * @return $this
     */
    public function entity(string $relationMethod)
    {
        $this->mergeConfigs(['entity' => $relationMethod]);

        return $this;
    }


    /**
     * @param  array|callable  $options
     *
     * @return $this
     */
    public function options($options)
    {
        if (is_array($options)) {
            $this->mergeConfigs(['options' => $options]);
        } elseif (is_callable($options)) {
            $this->filterOptions = $options;
        }

        return $this;
    }


    /**
     * Set the `Name` of component.
     *
     * @param  string  $name
     *
     * @return $this
     */
    public function name(string $name)
    {
        $this->name = $name;

        return $this;
    }


    /**
     * Upon setting the display `Label`, try to assign `Name` at once, when not
     * specified, use `snake_case` of `Label. If `Name` has already been set,
     * remains unchanged.
     *
     * @param  string  $label
     * @param  string|null  $name
     *
     * @return $this
     */
    public function label(string $label, ?string $name = null)
    {
        $this->label = $label;

        $name = $name ?? $this->name;

        $this->name($name ?? Str::slug($label, '_'));

        return $this;
    }


    /**
     * Upon setting the `Type` of component, also accept a parameter as its
     * display `Label`.
     *
     * @param  string  $type
     * @param  string|null  $label
     *
     * @return $this
     */
    public function type(string $type, ?string $label = null)
    {
        $this->type = $type;

        if (!is_null($label)) {
            $this->label($label);
        }

        return $this;
    }


    /**
     * @param  string  $label
     * @param  string|null  $name
     * @param  int  $widthOrPriority
     *
     * @return static|$this
     */
    abstract public function init(string $label, ?string $name = null, $widthOrPriority = null);


    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        $label = $this->label;
        $name = $this->name;
        $type = $this->type;

        $nestedConfigs = [];
        if (!empty($this->attributes)) {
            $nestedConfigs['attributes'] = $this->attributes;
        }
        if (!empty($this->wrapper)) {
            $nestedConfigs['wrapper'] = $this->wrapper;
        }

        return array_merge(compact('label', 'name', 'type'), $nestedConfigs, $this->crudConfigs);
    }


    /**
     * @param  array  $crudConfigs
     *
     * @return $this
     */
    public function mergeConfigs(array $crudConfigs)
    {
        $this->crudConfigs = array_merge($this->crudConfigs, $crudConfigs);

        return $this;
    }


    /**
     * @param  array  $attributes
     * @param  bool  $replace
     *
     * @return $this
     */
    public function mergeAttributes(array $attributes, $replace = false)
    {
        $this->attributes = $replace
            ? $attributes
            : array_merge($this->attributes, $attributes);

        return $this;
    }


    /**
     * @param  array  $wrapper
     * @param  bool  $replace
     *
     * @return $this
     */
    public function mergeWrapperAttributes(array $wrapper, $replace = false)
    {
        $this->wrapper = $replace
            ? $wrapper
            : array_merge($this->wrapper, $wrapper);

        return $this;
    }

}

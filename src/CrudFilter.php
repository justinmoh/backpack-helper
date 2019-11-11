<?php

namespace JustinMoh\BackpackHelper;

use CRUD;

class CrudFilter extends CrudHelper
{
    protected $type;
    protected $label;
    protected $name;

    protected $filterQuery = false;


    public function __construct($type = 'simple')
    {
        parent::__construct($type);
    }


    /**
     * This is intended to be used for named facade, which has the `Type`
     * already specified.
     *
     * @param string      $label
     * @param string|null $name
     * @param null        $na
     *
     * @return $this
     */
    public function init(string $label, ?string $name = null, $na = null)
    {
        $this->label($label, $name);

        return $this;
    }


    public function toFilter(): void
    {
        CRUD::addFilter($this->toArray(), $this->filterOptions, $this->filterQuery);
    }


    /**
     * @param callable|null $closure
     *
     * @return $this
     */
    public function query(?callable $closure = null)
    {
        $this->filterQuery = $closure ?: false;

        return $this;
    }


    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'label' => $this->label,
            'name' => $this->name,
            'type' => $this->type,
        ];
    }
}
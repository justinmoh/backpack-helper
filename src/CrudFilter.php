<?php

namespace JustinMoh\BackpackHelper;

use CRUD;
use Illuminate\Support\Str;
use JustinMoh\BackpackHelper\Facades\Filters\SimpleFilter;

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
     * @param  string  $label
     * @param  string  $scope
     */
    public static function onlyInactive($label = 'Only Inactive', $scope = 'ofInactive')
    {
        SimpleFilter::init($label, Str::slug($label, '_'))
            ->query(function () use ($scope) {
                CRUD::addClause($scope);
            })->toFilter();
    }


    /**
     * @param  string  $label
     * @param  string  $scope
     */
    public static function onlyActive($label = 'Only Active', $scope = 'ofActive')
    {
        SimpleFilter::init($label, Str::slug($label, '_'))
            ->query(function () use ($scope) {
                CRUD::addClause($scope);
            })->toFilter();
    }


    /**
     * @param  string  $label
     * @param  string  $scope
     */
    public static function onlyTrashed($label = 'Show Deleted', $scope = 'onlyTrashed')
    {
        SimpleFilter::init($label, Str::slug($label, '_'))
            ->query(function () use ($scope) {
                CRUD::addClause($scope);
            })->toFilter();
    }


    /**
     * @param  string  $label
     * @param  string  $scopeName
     */
    public static function simple($label, $scopeName)
    {
        SimpleFilter::init($label, Str::slug($label, '_'))
            ->query(function () use ($scopeName) {
                CRUD::addClause($scopeName);
            })->toFilter();
    }


    /**
     * This is intended to be used for named facade, which has the `Type`
     * already specified.
     *
     * @param  string  $label
     * @param  string|null  $name
     * @param  null  $na
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
     * @param  callable|null  $closure
     *
     * @return $this
     */
    public function query(?callable $closure = null)
    {
        $this->filterQuery = $closure ?: false;

        return $this;
    }


    protected function setDefaultConfigs(): void
    {
        // no defaults
    }
}

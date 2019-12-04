<?php

namespace JustinMoh\BackpackHelper\Traits;

use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;

/**
 * Trait CrudCreate
 * @package App\Http\Controllers\Traits
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
trait CrudCreate
{
    use CreateOperation;


    /**
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->crud->hasAccessOrFail('create');

        return $this->validateAndPersist();
    }

}

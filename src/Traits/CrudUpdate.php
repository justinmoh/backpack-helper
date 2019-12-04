<?php

namespace JustinMoh\BackpackHelper\Traits;

use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

/**
 * Trait CrudUpdate
 * @package App\Http\Controllers\Traits
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
trait CrudUpdate
{
    use UpdateOperation;


    /**
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $this->crud->hasAccessOrFail('update');

        return $this->validateAndPersist();
    }

}

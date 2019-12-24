<?php

namespace JustinMoh\BackpackHelper\Traits;

use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

/**
 * Trait CrudUpdate
 * @package App\Http\Controllers\Traits
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
trait CrudForceDelete
{
    use DeleteOperation;


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return string
     */
    public function destroy($id): string
    {
        $this->crud->hasAccessOrFail('delete');

        // get entry ID from Request (makes sure its the last ID for nested resources)
        $id = $this->crud->getCurrentEntryId() ?? $id;

        $deletedEntry = $this->crud->getModel()::withTrashed()
            ->where('id', $id)->first();

        if ($deletedEntry->deleted_at !== null) {
            return (string) $deletedEntry->forceDelete();
        }

        return (string) $this->crud->delete($id);
    }

}

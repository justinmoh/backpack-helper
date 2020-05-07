<?php

namespace JustinMoh\BackpackHelper\Traits;

use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

/**
 * Trait CrudDelete
 * @package JustinMoh\BackpackHelper\Traits
 * @property-read \JustinMoh\BackpackHelper\CrudPanel $crud
 */
trait CrudDelete
{
    use DeleteOperation;

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \array[][]|bool|string
     */
    public function destroy($id)
    {
        $this->crud->hasAccessOrFail('delete');

        try {
            \DB::beginTransaction();
            // get entry ID from Request (makes sure its the last ID for nested resources)
            $id = $this->crud->getCurrentEntryId() ?? $id;

            $result = $this->crud->delete($id);

            \DB::commit();
        } catch (\Throwable $throwable) {
            \DB::rollBack();

            // new adapt to new button behaviour
            $result = ['danger' => [[$throwable->getMessage()]]];
        }

        return $result;
    }
}

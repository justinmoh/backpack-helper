<?php

namespace JustinMoh\BackpackHelper\Traits;

use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;

/**
 * Trait CrudList
 * @package JustinMoh\BackpackHelper\Traits
 * @property-read \JustinMoh\BackpackHelper\CrudPanel $crud
 */
trait CrudList
{
    use ListOperation;


    /**
     * The search function that is called by the data table.
     *
     * @return array JSON Array of cells in HTML form.
     */
    public function search()
    {
        $this->crud->hasAccessOrFail('list');

        $this->crud->applyUnappliedFilters();

        $totalRows = $this->crud->baseQuery->count();
        $filteredRows = $this->crud->count();
        $startIndex = request()->input('start') ?: 0;
        // if a search term was present
        if (request()->input('search') && request()->input('search')['value']) {
            // filter the results accordingly
            $this->crud->applySearchTerm(request()->input('search')['value']);
            // recalculate the number of filtered rows
            $filteredRows = $this->crud->count();
        }
        // start the results according to the datatables pagination
        if (request()->input('start')) {
            $this->crud->skip((int) request()->input('start'));
        }
        // limit the number of results according to the datatables pagination
        if (request()->input('length')) {
            $this->crud->take((int) request()->input('length'));
        }
        // overwrite any order set in the setup() method with the datatables order
        if (request()->input('order')) {
            $column_number = request()->input('order')[0]['column'];
            $column_direction = request()->input('order')[0]['dir'];
            $column = $this->crud->findColumnById($column_number);
            if ($column['tableColumn']) {
                // clear any past orderBy rules
                $this->crud->query->getQuery()->orders = null;
                // apply the current orderBy rules
                $this->crud->query->orderBy($column['name'], $column_direction);
            }

            // check for custom order logic in the column definition
            if (isset($column['orderLogic'])) {
                $this->crud->customOrderBy($column, $column_direction);
            }
        }

        // show newest items first, by default (if no order has been set for the primary column)
        // if there was no order set, this will be the only one
        // if there was an order set, this will be the last one (after all others were applied)
        $orderBy = $this->crud->query->getQuery()->orders;
        $hasOrderByPrimaryKey = false;
        collect($orderBy)->each(function ($item, $key) use ($hasOrderByPrimaryKey) {
            if (!isset($item['column'])) {
                return false;
            }

            if ($item['column'] == $this->crud->model->getKeyName()) {
                $hasOrderByPrimaryKey = true;

                return false;
            }
        });
        if (!$hasOrderByPrimaryKey) {
            $this->crud->query->orderByDesc($this->crud->model->getKeyName());
        }

        $entries = $this->crud->getEntries();

        return $this->crud->getEntriesAsJsonForDatatables($entries, $totalRows, $filteredRows,
            $startIndex);
    }

}

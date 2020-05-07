<?php

namespace JustinMoh\BackpackHelper;

class CrudPanel extends \Backpack\CRUD\app\Library\CrudPanel\CrudPanel
{
    public $baseQuery;


    /**
     * This function binds the CRUD to its corresponding Model (which extends Eloquent).
     * All Create-Read-Update-Delete operations are done using that Eloquent Collection.
     *
     * @param  string  $model_namespace  Full model namespace. Ex: App\Models\Article
     * @param  \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     *
     * @throws \Exception in case the model does not exist
     */
    public function setModel($model_namespace, $defaultQueryBuilder = null)
    {
        if (!class_exists($model_namespace)) {
            throw new \Exception('The model does not exist.', 500);
        }

        if (!method_exists($model_namespace, 'hasCrudTrait')) {
            throw new \Exception('Please use CrudTrait on the model.', 500);
        }

        $this->model = new $model_namespace();
        $this->baseQuery = $defaultQueryBuilder ?: $this->model->select('*');
        $this->query = clone $this->baseQuery;
        $this->entry = null;
    }
}

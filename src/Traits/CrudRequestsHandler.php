<?php

namespace JustinMoh\BackpackHelper\Traits;

use Alert;
use DB;

/**
 * Trait CrudRequestsHandler
 * @package Justinmoh\BackpackHelper\Traits
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
trait CrudRequestsHandler
{

    /**
     * @param  bool  $defaultMessage
     * @param  string|null  $redirectUrl
     *
     * @return \Illuminate\Http\Response
     */
    protected function validateAndPersist($defaultMessage = true, $redirectUrl = null)
    {
        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

        try {
            DB::beginTransaction();

            $item = $request->persist();

            $this->data['entry'] = $this->crud->entry = $item;

            $this->flashMessageIntoBackpackAlert($defaultMessage);

            DB::commit();

            return $this->redirectResponse($item, $redirectUrl)
                ->with('alert_messages', Alert::messages());

        } catch (\Throwable $throwable) {

            DB::rollBack();

            \Log::error($throwable);
            \Alert::error("Error : {$throwable->getMessage()}")->flash();

            return redirect()->back()->withInput()
                ->with('alert_messages', Alert::messages());
        }
    }


    /**
     * @param  bool  $defaultMessage
     */
    protected function flashMessageIntoBackpackAlert(bool $defaultMessage): void
    {
        if ($defaultMessage) {
            switch ($this->crud->getActionMethod()) {
                case 'create':
                    $message = trans('backpack::crud.insert_success');
                    break;
                case 'update':
                    $message = trans('backpack::crud.update_success');
                    break;
                default:
                    $message = 'Action completed.';
            }
        } else {
            $details = [];
            foreach ($this->crud->getStrippedSaveRequest() as $field => $value) {
                $value = json_encode($value);
                $details[] = "$field => $value";
            }
            $message = "Processed : <br>".implode('<br>', $details);
        }

        \Alert::success($message)->flash();
    }


    /**
     * @param  \Illuminate\Database\Eloquent\Model  $item
     * @param  string|null  $redirectUrl
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    protected function redirectResponse($item, $redirectUrl = null)
    {
        if ($redirectUrl) {
            return redirect()->to($redirectUrl);
        }

        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }

}
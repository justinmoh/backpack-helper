<?php

namespace JustinMoh\BackpackHelper;

use CRUD;

class CrudColumn extends CrudHelper
{

    protected function setDefaultColumnConfigs(): void
    {
        if ($this->type === 'textarea') {
            $this->type = 'closure';
            $this->function(
                function ($entry) {
                    return nl2br($entry->{$this->name});
                }
            );
        }

        switch (strtolower($this->type)) {
            case 'upload_multiple':
                $this->mergeConfigs(['disk' => 'public']);
        }
    }


    /**
     * @param callable $function
     *
     * @return $this
     */
    public function function (callable $function)
    {
        $this->mergeConfigs(['function' => $function]);

        return $this;
    }


    /**
     * @param int $priority
     *
     * @return $this
     */
    public function priority(int $priority)
    {
        $this->mergeConfigs(['priority' => $priority]);

        return $this;
    }


    /**
     * @param string      $label
     * @param string|null $name
     * @param int|null    $priority
     *
     * @return static|$this
     */
    public function init(string $label, ?string $name = null, $priority = null)
    {
        $this->label($label, $name);

        if ($priority) {
            $this->priority($priority);
        }

        return $this;
    }


    /**
     * @param array $extraConfigs
     *
     * @return \Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade
     */
    public function toColumn($extraConfigs = [])
    {
        $this->setDefaultColumnConfigs();

        $configs = array_merge($this->toArray(), $extraConfigs);

        return CRUD::addColumn($configs);
    }


    /**
     * @param array $extraConfigs
     *
     * @return array
     */
    public function test($extraConfigs = [])
    {
        $this->setDefaultColumnConfigs();;

        return array_merge($this->toArray(), $extraConfigs);
    }

}
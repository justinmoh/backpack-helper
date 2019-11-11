<?php

namespace JustinMoh\BackpackHelper;

use CRUD;

class CrudField extends CrudHelper
{
    protected $width;


    protected function setDefaultFieldConfigs(): void
    {
        $defaultWrapperAttrs = $this->width
            ? ['class' => 'form-group col-md-'.$this->width]
            : [];

        if (in_array($this->type, ['upload_multiple'])) {
            $this->mergeConfigs(['upload' => true]);
            $defaultWrapperAttrs = array_merge(
                $defaultWrapperAttrs,
                [
                    'data-init-function' => 'bpFieldInitUploadMultipleElement',
                    'data-field-name' => $this->name,
                ]
            );
        }

        $this->mergeWrapperAttributes($defaultWrapperAttrs);

        if ($this->type === 'datetime_picker') {
            $this->datetimePickerOptions([]);
        }

        if ($this->type === 'textarea') {
            $this->rows(5);
        }
    }


    /**
     * @param $options
     *
     * @return $this
     */
    public function datePickerOptions($options)
    {
        $this->mergeConfigs(['date_picker_options' => $options]);

        return $this;
    }


    /**
     * @param int $rows
     *
     * @return $this
     */
    public function rows(int $rows)
    {
        $this->mergeAttributes(['rows' => $rows]);

        return $this;
    }


    /**
     * @param $options
     *
     * @return $this
     */
    public function datetimePickerOptions($options)
    {
        $datetimePickerOptions = ['format' => 'YYYY-MM-DD HH:mm'];

        $this->mergeConfigs(
            ['datetime_picker_options' => array_merge($datetimePickerOptions, $options)]
        );

        return $this;
    }


    /**
     * todo: handle readonly for select / multiselect etc
     *
     * @param bool $readonly
     *
     * @return $this
     */
    public function readonly(bool $readonly = true)
    {
        if ($readonly === true) {
            $this->mergeAttributes(['readonly' => $readonly]);
        }

        return $this;
    }


    /**
     * @param bool $disabled
     *
     * @return $this
     */
    public function disabled(?bool $disabled = true)
    {
        if ($disabled === true) {
            $this->mergeAttributes(['disabled' => $disabled]);
        }

        return $this;
    }


    /**
     * @param string $placeholderText
     *
     * @return $this
     */
    public function placeholder(string $placeholderText)
    {
        $this->mergeAttributes(['placeholder' => $placeholderText]);

        return $this;
    }


    /**
     * @param string      $hintText
     * @param string|null $type
     *
     * @return $this
     */
    public function hint(string $hintText, $type = 'small')
    {
        switch (strtolower($type)) {
            case 'small':
                $hintText = "<small>$hintText</small>";
                break;
            case 'strong':
                $hintText = "<strong>$hintText</strong>";
                break;
        }

        $hintText = "<span class='text-muted'>$hintText</span>";

        $this->mergeConfigs(['hint' => $hintText]);

        return $this;
    }


    /**
     * @param bool $inline
     *
     * @return $this
     */
    public function inline(bool $inline = true)
    {
        $this->mergeConfigs(['inline' => $inline]);

        return $this;
    }


    /**
     * @param $defaultValue
     *
     * @return $this
     */
    public function default($defaultValue)
    {
        $this->mergeConfigs(['default' => $defaultValue]);

        return $this;
    }


    /**
     * @param bool $required
     *
     * @return $this
     */
    public function required(bool $required = true)
    {
        $this->mergeAttributes(['required' => $required]);

        return $this;
    }


    /**
     * @param string $tab
     *
     * @return $this
     */
    public function tab(string $tab)
    {
        $this->mergeConfigs(['tab' => $tab]);

        return $this;
    }


    public function width($width)
    {
        $this->width = $width;

        return $this;
    }


    /**
     * @param string      $label
     * @param string|null $name
     * @param int|null    $width
     *
     * @return static|$this
     */
    public function init(string $label, ?string $name = null, $width = null)
    {
        $this->label($label, $name);

        if ($width) {
            $this->width($width);
        }

        return $this;
    }


    /**
     * @param array $extraConfigs
     *
     * @return \Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade
     */
    public function toField($extraConfigs = [])
    {
        $this->setDefaultFieldConfigs();

        $configs = array_merge($this->toArray(), $extraConfigs);

        return CRUD::addField($configs);
    }


    /**
     * @param array $extraConfigs
     *
     * @return array
     */
    public function test($extraConfigs = [])
    {
        $this->setDefaultFieldConfigs();

        return array_merge($this->toArray(), $extraConfigs);
    }


}
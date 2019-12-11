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

        $this->mergeWrapperAttributes($defaultWrapperAttrs);

        switch (strtolower($this->type)) {
            case 'datetime_picker':
                $this->datetimePickerOptions([]);
                break;
            case 'date_picker':
                $this->datePickerOptions();
                break;
            case 'textarea':
                if (!isset($this->crudConfigs['rows'])) {
                    $this->rows(5);
                }
                break;
            case 'upload_multiple':
                $this->mergeConfigs(['upload' => true, 'disk' => 'public']);
                $this->mergeWrapperAttributes([
                    'data-init-function' => 'bpFieldInitUploadMultipleElement',
                    'data-field-name' => $this->name,
                ]);
                break;
        }
    }


    /**
     * @param  int  $rows
     *
     * @return $this
     */
    public function rows(int $rows = 5)
    {
        $this->mergeAttributes(['rows' => $rows]);

        return $this;
    }


    /**
     * @param $options
     *
     * @return $this
     */
    public function datePickerOptions($options = [])
    {
        $defaultDatePickerOptions = array_merge(
            [
                'format' => 'yyyy-mm-dd',
                'todayBtn' => 'linked',
                'todayHighlight' => true,
                'autoclose' => true,
                'clearBtn' => true,
            ],
            $this->crudConfigs['date_picker_options'] ?? []
        );

        $this->mergeConfigs(
            ['date_picker_options' => array_merge($defaultDatePickerOptions, $options)]
        );

        return $this;
    }


    /**
     * @param $options
     *
     * @return $this
     */
    public function datetimePickerOptions($options)
    {
        $defaultDatetimePickerOptions = array_merge(
            ['format' => 'YYYY-MM-DD HH:mm'],
            $this->crudConfigs['datetime_picker_options'] ?? []
        );

        $this->mergeConfigs(
            ['datetime_picker_options' => array_merge($defaultDatetimePickerOptions, $options)]
        );

        return $this;
    }


    /**
     * todo: handle readonly for select / multiselect etc
     *
     * @param  bool  $readonly
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
     * @param  bool  $disabled
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
     * @param  string  $placeholderText
     *
     * @return $this
     */
    public function placeholder(string $placeholderText)
    {
        $this->mergeAttributes(['placeholder' => $placeholderText]);

        return $this;
    }


    /**
     * @param  string  $hintText
     * @param  string|null  $type
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
     * @param  bool  $inline
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
     * @param  bool  $required
     *
     * @return $this
     */
    public function required(bool $required = true)
    {
        $this->mergeAttributes(['required' => $required]);

        return $this;
    }


    /**
     * @param  string  $tab
     *
     * @return $this
     */
    public function tab(string $tab)
    {
        $this->mergeConfigs(['tab' => $tab]);

        return $this;
    }


    /**
     * @param $width
     *
     * @return $this
     */
    public function width($width)
    {
        $this->width = $width;

        return $this;
    }


    /**
     * @param  string  $label
     * @param  string|null  $name
     * @param  int|null  $width
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
     * @param  array  $extraConfigs
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
     * @param  array  $extraConfigs
     *
     * @return array
     */
    public function test($extraConfigs = [])
    {
        $this->setDefaultFieldConfigs();

        return array_merge($this->toArray(), $extraConfigs);
    }

}

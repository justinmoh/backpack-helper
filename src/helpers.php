<?php

use JustinMoh\BackpackHelper\Facades\Fields\HiddenField;

/**
 * Add a hidden field named `http_referrer` that used to redirect
 * after the form persisted.
 */
function add_back_url_hidden_field(): void
{
    HiddenField::name('http_referrer')->default(request('back_url', url()->previous()));
}
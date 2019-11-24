<?php

use JustinMoh\BackpackHelper\Facades\Fields\HiddenField;

/**
 * Add a hidden field named `http_referrer` that used to redirect
 * after the form persisted.
 *
 * @param  string|null  $url
 */
function add_back_url_hidden_field($url = null): void
{
    HiddenField::name('http_referrer')->default($url ?: request('back_url', url()->previous()));
}
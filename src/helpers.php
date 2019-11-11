<?php

use JustinMoh\BackpackHelper\Facades\Fields\HiddenField;

function add_back_url_hidden_field(): void
{
    HiddenField::name('http_referrer')->default(url()->previous(request('back_url')));
}

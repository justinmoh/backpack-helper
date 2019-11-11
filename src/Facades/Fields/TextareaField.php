<?php

namespace JustinMoh\BackpackHelper\Facades\Fields;

use Illuminate\Support\Facades\Facade;

/**
 * @package JustinMoh\BackpackHelper\Facades
 *
 * @mixin \JustinMoh\BackpackHelper\CrudField
 */
class TextareaField extends Facade
{

    protected static function getFacadeAccessor()
    {
        self::clearResolvedInstance(self::class);

        return self::class;
    }

}
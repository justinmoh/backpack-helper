<?php

namespace JustinMoh\BackpackHelper\Facades\Columns;

use Illuminate\Support\Facades\Facade;

/**
 * Class SelectMultipleColumn
 * @package JustinMoh\BackpackHelper\Facades\Columns
 *
 * @mixin \JustinMoh\BackpackHelper\CrudColumn
 */
class NumberColumn extends Facade
{

    protected static function getFacadeAccessor()
    {
        self::clearResolvedInstance(self::class);

        return self::class;
    }

}
<?php

namespace JustinMoh\BackpackHelper\Facades\Columns;

use Illuminate\Support\Facades\Facade;

/**
 * Class TableColumn
 * @package JustinMoh\BackpackHelper\Facades\Columns
 *
 * @mixin \JustinMoh\BackpackHelper\CrudColumn
 */
class TableColumn extends Facade
{

    protected static function getFacadeAccessor()
    {
        self::clearResolvedInstance(self::class);

        return self::class;
    }

}
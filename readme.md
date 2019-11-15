# backpack-helper

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]

This package intends to provide a friendlier interface while using `Backpack CRUD`, 
by makes use of `laravel's facade`.

According to the way `Backpack\Crud` works, this package rely the trailing 
method to perform the magic. Currently these compulsory trailing methods are:
- `public function toField($extraConfigToBeMerged = []): CrudPanel`
- `public function toColumn($extraConfigToBeMerged = []): CrudPanel`
- `public function toFilter($extraConfigToBeMerged = []): void`

All other methods return the current instance `$this`. In order to perform 
method chain, refer class source code for api, example:

```php
CrudColumn::init(string $label, ?string $name = null, $priority = null): self
CrudField::init(string $label, ?string $name = null, $width = null): self
```

There is a 2-steps plan:
- To include all `Backpack CRUD` columns, fields, and filters
- To merge the helper classes into one.

These is no test written, yet.


## Installation

Via Composer

``` bash
$ composer require justinmoh/backpack-helper:~0.2
```

## Usage

```php
use \JustinMoh\BackpackHelper\CrudHelper;
use \JustinMoh\BackpackHelper\Facades\Columns\DatetimeColumn;
use \JustinMoh\BackpackHelper\Facades\Columns\SelectColumn;
use \JustinMoh\BackpackHelper\Facades\Columns\TextColumn;
use \JustinMoh\BackpackHelper\Facades\Fields\RadioField;
use \JustinMoh\BackpackHelper\Facades\Fields\Select2FromArrayField;
use \JustinMoh\BackpackHelper\Facades\Fields\UploadMultipleField;
use \JustinMoh\BackpackHelper\Facades\Filters\Select2MultipleFilter;
use \JustinMoh\BackpackHelper\Facades\Filters\SimpleFilter;

// ...

protected function setupListOperation()
{
    // a datetime column with priority `1`
    DatetimeColumn::init('Date & Time Check In', 'datetime_check_in', 1)
        ->toColumn();

    // you can also separate the method chains.
    DatetimeColumn::label('Date & Time Check Out')->name('datetime_check_out')
        ->toColumn();

    // auto guessing `name` with `label`
    TextColumn::label('Name')->toColumn();

    // backpack's `select` column type
    SelectColumn::init('Category', 'category_id')
        ->entity('category')->attribute('display_name')->model(\App\Category::class)
        ->toColumn();
}

// ...

protected function setupCreateOperation()
{
    // a field with wrapperAttribute col-md-6 (or col-lg-6 ?)
    UploadMultipleField::init('Attach Documents', 'customer_documents', 6)
        ->toField();

    // an inline yes no radio button, disabled
    RadioField::init('Is Vip')->width(3)->inline()
        ->options(CrudHelper::YES_NO_OPTIONS)
        ->disabled()->toField();

    // select 2
    Select2FromArrayField::init('Room Type', 'room_type_id', 4)->required()
        ->options(\App\RoomType::all()->prepend('')->pluck('name','id')->toArray())
        ->toField();
}

// ...

protected function setupListOperation()
{
    SimpleFilter::init('Only New', 'status_new')
        ->query(function() {
            \CRUD::addClause('onlyNew');
        })->toFilter();

    Select2MultipleFilter::label('Select Room Type(s)')
        ->options(
            function () {
                return \App\RoomType::all()->pluck('name', 'id')->toArray();
            }
        )->query(
            function ($value) {
                \CRUD::addClause('whereInRoomTypes', json_decode($values));
            }
        )->toFilter();
}
```

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [Justin Moh][link-author]
- [All Contributors][link-contributors]

## License

license. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/justinmoh/backpack-helper.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/justinmoh/backpack-helper.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/justinmoh/backpack-helper
[link-downloads]: https://packagist.org/packages/justinmoh/backpack-helper
[link-author]: https://github.com/justinmoh
[link-contributors]: ../../contributors

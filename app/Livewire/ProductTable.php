<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class ProductTable extends PowerGridComponent
{
    use WithExport;

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Product::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('name')

            /** Example of custom column using a closure **/
            ->addColumn('name_lower', fn (Product $model) => strtolower(e($model->name)))

            ->addColumn('slug')
            ->addColumn('code')
            ->addColumn('unit')
            ->addColumn('tags')
            ->addColumn('video')
            ->addColumn('purchase_price')
            ->addColumn('selling_price')
            ->addColumn('discount_price')
            ->addColumn('stock_quantity')
            ->addColumn('description')
            ->addColumn('thumbnail')
            ->addColumn('images')
            ->addColumn('featured')
            ->addColumn('today_deal')
            ->addColumn('trendy')
            ->addColumn('product_slider')
            ->addColumn('status')
            ->addColumn('category_id')
            ->addColumn('brand_id')
            ->addColumn('warehouse_id')
            ->addColumn('pickup_point_id')
            ->addColumn('user_id')
            ->addColumn('created_at_formatted', fn (Product $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Slug', 'slug')
                ->sortable()
                ->searchable(),

            Column::make('Code', 'code')
                ->sortable()
                ->searchable(),

            Column::make('Unit', 'unit')
                ->sortable()
                ->searchable(),

            Column::make('Tags', 'tags')
                ->sortable()
                ->searchable(),

            Column::make('Video', 'video')
                ->sortable()
                ->searchable(),

            Column::make('Purchase price', 'purchase_price')
                ->sortable()
                ->searchable(),

            Column::make('Selling price', 'selling_price')
                ->sortable()
                ->searchable(),

            Column::make('Discount price', 'discount_price')
                ->sortable()
                ->searchable(),

            Column::make('Stock quantity', 'stock_quantity')
                ->sortable()
                ->searchable(),

            Column::make('Description', 'description')
                ->sortable()
                ->searchable(),

            Column::make('Thumbnail', 'thumbnail')
                ->sortable()
                ->searchable(),

            Column::make('Images', 'images')
                ->sortable()
                ->searchable(),

            Column::make('Featured', 'featured')
                ->toggleable(),

            Column::make('Today deal', 'today_deal')
                ->toggleable(),

            Column::make('Trendy', 'trendy'),
            Column::make('Product slider', 'product_slider')
                ->toggleable(),

            Column::make('Status', 'status'),
            Column::make('Category id', 'category_id'),
            Column::make('Brand id', 'brand_id'),
            Column::make('Warehouse id', 'warehouse_id'),
            Column::make('Pickup point id', 'pickup_point_id'),
            Column::make('User id', 'user_id'),
            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('name')->operators(['contains']),
            Filter::inputText('slug')->operators(['contains']),
            Filter::inputText('code')->operators(['contains']),
            Filter::inputText('unit')->operators(['contains']),
            Filter::inputText('tags')->operators(['contains']),
            Filter::inputText('video')->operators(['contains']),
            Filter::inputText('purchase_price')->operators(['contains']),
            Filter::inputText('selling_price')->operators(['contains']),
            Filter::inputText('discount_price')->operators(['contains']),
            Filter::inputText('stock_quantity')->operators(['contains']),
            Filter::inputText('thumbnail')->operators(['contains']),
            Filter::inputText('images')->operators(['contains']),
            Filter::boolean('featured'),
            Filter::boolean('today_deal'),
            Filter::boolean('product_slider'),
            Filter::datetimepicker('created_at'),
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert(' . $rowId . ')');
    }

    public function actions(\App\Models\Product $row): array
    {
        return [
            Button::add('edit')
                ->slot('Edit: ' . $row->id)
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('edit', ['rowId' => $row->id])
        ];
    }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}

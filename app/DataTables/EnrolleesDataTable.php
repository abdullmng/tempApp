<?php

namespace App\DataTables;

use App\Models\Enrollee;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class EnrolleesDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($data) {
                return view('enrollees.partials.action', ['data' => $data]);
            })
            ->addColumn('picture', function ($data) {
                return '<img src="'.$data->picture.'" class="img-fluid" style="width: 50px; height: 50px;" alt="image">';
            })
            ->addColumn('created_at', function ($data) {
                return $data->created_at->format('Y-m-d h:ia');
            })
            /*->addColumn('name', function ($data) {
                return $data->full_name;
            })*/
            ->rawColumns(['picture']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Enrollee $model): QueryBuilder
    {
        //return $model->where('enrolled_by', auth()->id());
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('enrollees-table')
                    ->addTableClass('responsive')
                    ->addTableClass('dataTable')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(2)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('picture'),
            Column::make('reference'),
            Column::make('first_name'),
            Column::make('middle_name'),
            Column::make('last_name'),
            Column::make('gender'),
            Column::make('phone_number'),
            Column::computed('created_at'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center')
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Enrollees_' . date('YmdHis');
    }
}

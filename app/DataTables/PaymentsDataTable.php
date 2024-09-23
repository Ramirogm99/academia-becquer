<?php

namespace App\DataTables;

use App\Models\ClientCourse;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PaymentsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     * @param mixed $query Results from query() method.
     */
    public function dataTable($query)
    {
        $datatables = datatables()->eloquent($query);
        // $action = '<div class="task_view">
        // <div class="dropdown">
        //     <a class="task_view_more d-flex align-items-center justify-content-center dropdown-toggle" type="link"
        //         id="dropdownMenuLink-' . $row->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        //         <i class="icon-options-vertical icons"></i>
        //     </a>
        //     <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-' . $row->id . '" tabindex="0">';

        // $action .= '<a href="' . route('estimates.show', [$row->id]) . '" class="dropdown-item"><i class="fa fa-eye mr-2"></i>' . __('app.view') . '</a>';
        $datatables->editColumn('action', function ($row) {
            $action = '<div class="task_view">
            <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Acciones
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-' . $row->id . '" tabindex="0">';
            if ($row->paid == 0) {
                $action .= '<a href="javascript:;" class="dropdown-item make-payment" data-row-id="' . $row->client_id . '"><i class="fa fa-pen mr-2"></i>' . 'Realizar pago' . '</a>';
            }
            $action .= '<a href="javascript:;" class="dropdown-item delete-row" data-row-id="' . $row->id . '"><i class="fa fa-trash mr-2"></i>' . 'Borrar entrada' . '</a>';
            $action .= '</div>
            </div>
            </div>';
            return $action;
        });
        $datatables->editColumn('client', function ($row) {
            return $row->client->name;
        });
        $datatables->rawColumns(['courses', 'action', 'client']);
        return $datatables;
        // return DataTables::eloquent($query);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query()
    {
        $request = $this->request();
        $model = ClientCourse::query()->with('client', 'course')->groupBy('client_id')->where('deleted_at', null);
        if ($request->search['value'] != null) {
            $model->whereHas('course', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search['value'] . '%');
            });
            $model->whereHas('client', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search['value'] . '%');
            });
        }
        // dd($model->get());
        return $model; // Devuelve el query del modelo Clients
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('payments-table')
            ->columns($this->getColumns())
            ->minifiedAjax(route('payments.index')) // Asegúrate de que el nombre de la ruta sea correcto
            ->orderBy(1)
            ->selectStyleSingle()
            ->parameters([
                'initComplete' => 'function () {
                    window.LaravelDataTables["payments-table"].buttons().container()
                    .appendTo( "#table-actions")
                }',
                'fnDrawCallback' => 'function( oSettings ) {
                    $("body").tooltip({
                        selector: \'[data-toggle="tooltip"]\'
                    })
                }',
            ])
            ->buttons([]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        $data = [
            'Cliente' => ['data' => 'client.name', 'name' => 'client', 'title' => 'Cliente'],
            'Total' => ['data' => 'total', 'name' => 'total', 'title' => 'Total' , 'searchable' => false],
            Column::computed('action', 'Acciones')
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->searchable(false)
                ->addClass('text-right pr-20')
        ];
        return $data;
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Clients_' . date('YmdHis');
    }
}

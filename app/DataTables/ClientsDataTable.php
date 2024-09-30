<?php

namespace App\DataTables;

use App\Models\Clients;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ClientsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     * @param mixed $query Results from query() method.
     */
    public function dataTable($query)
    {
        $datatables = datatables()->eloquent($query);
        $datatables->editColumn('action', function ($row) {
            $action = '<div class="task_view">
            <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Acciones
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-' . $row->id . '" tabindex="0">';
            $action .= '<a href="' . route('clients.show', [$row->id]) . '" class="dropdown-item"><i class="fa fa-eye mr-2"></i>' . 'Ver entrada' . '</a>';
            $action .= '<a href="' . route('clients.edit', [$row->id]) . '" class="dropdown-item"><i class="fa fa-pen mr-2"></i>' . 'Editar entrada' . '</a>';
            $action .= '<a href="javascript:;" class="dropdown-item delete-row" data-row-id="' . $row->id . '"><i class="fa fa-trash mr-2"></i>' . 'Borrar entrada' . '</a>';
            $action .= '</div>
            </div>
            </div>';
            return $action;
        });
        $datatables->rawColumns(['courses', 'action']);
        return $datatables;
        // return DataTables::eloquent($query);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query()
    {
        $request = $this->request();
        $model = Clients::query();
        $model = $model->where('deleted_at', null);
        if ($request->search['value'] != null) {
            $model->where('name', 'like', '%' . $request->search['value'] . '%');
            $model->orWhere('phone', 'like', '%' . $request->search['value'] . '%');
            $model->orWhere('surnames', 'like', '%' . $request->search['value'] . '%');
            $model->orWhere('school', 'like', '%' . $request->search['value'] . '%');
            $model->whereHas('courses', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search['value'] . '%');
            });
        }
        return $model; // Devuelve el query del modelo Clients
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('clients-table')
            ->columns($this->getColumns())
            ->minifiedAjax(route('clients.index')) // Asegúrate de que el nombre de la ruta sea correcto
            ->orderBy(1)
            ->selectStyleSingle()
            ->parameters([
                'initComplete' => 'function () {
                    window.LaravelDataTables["clients-table"].buttons().container()
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
            'Nombre' => ['data' => 'name', 'name' => 'name', 'title' => 'Nombre'],
            'Apellidos' => ['data' => 'surnames', 'name' => 'surnames', 'title' => 'Apellidos'],
            Column::computed('action', 'Acciones')
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->searchable(false)
                ->addClass('text-right')
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

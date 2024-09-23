<?php

namespace App\DataTables;

use App\Models\Courses;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CoursesDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
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
            $action .= '<a href="' . route('courses.show', [$row->id]) . '" class="dropdown-item"><i class="fa fa-eye mr-2"></i>' . 'Ver entrada' . '</a>';
            $action .= '<a href="' . route('courses.edit', [$row->id]) . '" class="dropdown-item"><i class="fa fa-pen mr-2"></i>' . 'Editar entrada' . '</a>';
            $action .= '<a href="javascript:;" class="dropdown-item delete-row" data-row-id="' . $row->id . '"><i class="fa fa-trash mr-2"></i>' . 'Borrar entrada' . '</a>';
            $action .= '</div>
            </div>
            </div>';
            return $action;
        });
        $datatables->editColumn('courses', function ($row) {
            switch ($row->course) {
                case 1:
                    $level = '1º Primaria';
                    break;
                case 2:
                    $level = '2º Primaria';
                    break;
                case 3:
                    $level = '3º Primaria';
                    break;
                case 4:
                    $level = '4º Primaria';
                    break;
                case 5:
                    $level = '5º Primaria';
                    break;
                case 6:
                    $level = '6º Primaria';
                    break;
                case 7:
                    $level = '1º ESO';
                    break;
                case 8:
                    $level = '2º ESO';
                    break;
                case 9:
                    $level = '3º ESO';
                    break;
                case 10:
                    $level = '4º ESO';
                    break;
                case 11:
                    $level = '1º Bachillerato';
                    break;
                case 12:
                    $level = '2º Bachillerato';
                    break;
                case 13:
                    $level = 'Universidad';
                    break;
                case 14:
                    $level = 'Acceso a grados';
                    break;
                case 15:
                    $level = 'Intensivo selectividad';
                    break;
                default:
                    $level = 'No especificado';
                    break;
            }
            return $level;
        });
        $datatables->editColumn('price', function ($row) {
            return $row->price . ' €';
        });
        $datatables->rawColumns(['courses', 'action', 'course']);
        return $datatables;
        // return DataTables::eloquent($query);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query()
    {
        $request = $this->request();
        $model = Courses::query();
        $model = $model->where('deleted_at', null);
        if ($request->search['value'] != null) {
            $model->where('name', 'like', '%' . $request->search['value'] . '%');
        }
        return $model; // Devuelve el query del modelo Clients
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('courses-table')
            ->columns($this->getColumns())
            ->minifiedAjax(route('courses.index')) // Asegúrate de que el nombre de la ruta sea correcto
            ->orderBy(1)
            ->selectStyleSingle()
            ->parameters([
                'initComplete' => 'function () {
                    window.LaravelDataTables["courses-table"].buttons().container()
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
            'Curso' => ['data' => 'course', 'name' => 'course', 'title' => 'Curso'],
            'Precio' => ['data' => 'price', 'name' => 'price', 'title' => 'Precio'],
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

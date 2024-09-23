<?php

namespace App\Http\Controllers;

use App\DataTables\ClientsDataTable;
use App\Models\ClientCourse;
use App\Models\Clients;
use App\Models\Courses;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    //
    public function index(ClientsDataTable $dataTable)
    {
        $clients = Clients::all();
        return $dataTable->render('clients.index', [$clients]);
    }
    public function create()
    {
        $courses = Courses::all();
        return view('clients.create', ["courses" => $courses]);
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $client = new Clients();
        $client->name = $request->name;
        $client->phone = $request->phone;
        $client->tutor = $request->tutor;
        $client->level = $request->level;
        $client->school = $request->school;
        $client->save();
        if ($request->courses) {
            foreach ($request->courses as $key => $course) {
                $courses_clients = new ClientCourse();
                $courses_clients->client_id = $client->id;
                $courses_clients->course_id = $course;
                $courses_clients->total = $request->price_total[$key];
                $courses_clients->hours = $request->hours[$key] ?? 0;
                $courses_clients->save();
            }
        }
        return redirect()->route('clients.index');
    }
    public function edit($id)
    {
        $courses = Courses::all();
        $client = Clients::find($id);
        $coursesClient = ClientCourse::where('client_id', $id)->with('course')->get();
        return view('clients.edit', ['client' => $client, 'courses' => $courses, "coursesClient" => $coursesClient]);
    }
    public function update(Request $request)
    {
        $client = Clients::find($request->client_id);
        $client->name = $request->name;
        $client->phone = $request->phone;
        $client->tutor = $request->tutor;
        $client->level = $request->level;
        $client->school = $request->school;
        $client->save();
        if ($request->courses) {
            foreach ($request->courses as $key => $course) {
                $courses_clients = ClientCourse::where('id', $course)->first();
                if ($courses_clients != null) {
                    $courses_clients->total = $request->price_total[$key];
                    $courses_clients->hours = $request->hours[$key] ?? 0;
                    $courses_clients->save();
                } else {
                    $courses_clients = new ClientCourse();
                    $courses_clients->client_id = $client->id;
                    $courses_clients->course_id = $course;
                    $courses_clients->total = $request->price_total[$key];
                    $courses_clients->hours = $request->hours[$key] ?? 0;
                    $courses_clients->save();
                }
            }
        }
        return redirect()->route('clients.index');
    }
    public function show($id)
    {
        $client = Clients::find($id);
        switch ($client->level) {
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
        // ! queda por añadir los cursos a los que esta apuntado el cliente
        $courses = ClientCourse::where('client_id', $id)->with('course')->get();
        // TODO: añadir cursos
        return view('clients.show', ['client' => $client, 'level' => $level, 'courses' => $courses]);
    }
    public function delete($id)
    {
        $client = Clients::find($id);
        $client->delete();
        return json_encode(['status' => 'ok']);
    }

}

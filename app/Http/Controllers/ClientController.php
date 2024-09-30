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
        $client->surnames = $request->surnames;
        $client->phone = $request->phone;
        $client->level = $request->level;
        $client->school = $request->school;
        $client->observations = $request->observations;

        $client->save();
        if ($request->courses) {
            foreach ($request->courses as $key => $course) {
                $coursePrice = Courses::find($course);
                switch ($coursePrice->course) {
                    case '1' || '2' || '3' || '4' || '5' || '6' || '7' || '8' || '9' || '10':
                        switch ($request->hours[$key]) {
                            case '2':
                                $price = 55;
                                break;
                            case '3':
                                $price = 70;
                                break;
                            case '4':
                                $price = 85;
                                break;
                            case '5':
                                $price = 100;
                                break;
                            case '6':
                                $price = 110;
                                break;
                            case '8':
                                $price = 135;
                                break;
                        }
                        break;
                    case '11' || '12':
                        switch ($request->hours[$key]) {
                            case '2':
                                $price = 60;
                                break;
                            case '3':
                                $price = 75;
                                break;
                            case '4':
                                $price = 90;
                                break;
                            case '5':
                                $price = 105;
                                break;
                            case '6':
                                $price = 115;
                                break;
                            case '8':
                                $price = 140;
                                break;
                        }
                        break;
                    case '13':
                        switch ($request->hours[$key]) {
                            case '1':
                                $price = 95;
                                break;
                            case '2':
                                $price = 150;
                                break;
                            case '3':
                                $price = 195;
                                break;
                            case '4':
                                $price = 215;
                                break;

                        }
                        break;
                }
                $courses_clients = new ClientCourse();
                $courses_clients->client_id = $client->id;
                $courses_clients->course_id = $course;
                $courses_clients->total = $price;
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
        $client->surnames = $request->surnames;
        $client->phone = $request->phone;
        $client->level = $request->level;
        $client->observations = $request->observations;
        $client->school = $request->school;
        $client->save();
        if ($request->courses) {
            ClientCourse::where('client_id', $client->id)->delete();
            foreach ($request->courses as $key => $course) {
                $coursePrice = Courses::find($request->courses[$key]);
                switch ($coursePrice->course) {
                    case '1' || '2' || '3' || '4' || '5' || '6' || '7' || '8' || '9' || '10':
                        switch ($request->hours[$key]) {
                            case '2':
                                $price = 55;
                                break;
                            case '3':
                                $price = 70;
                                break;
                            case '4':
                                $price = 85;
                                break;
                            case '5':
                                $price = 100;
                                break;
                            case '6':
                                $price = 110;
                                break;
                            case '8':
                                $price = 135;
                                break;
                        }
                        break;
                    case '11' || '12':
                        switch ($request->hours[$key]) {
                            case '2':
                                $price = 60;
                                break;
                            case '3':
                                $price = 75;
                                break;
                            case '4':
                                $price = 90;
                                break;
                            case '5':
                                $price = 105;
                                break;
                            case '6':
                                $price = 115;
                                break;
                            case '8':
                                $price = 140;
                                break;
                        }
                        break;
                    case '13':
                        switch ($request->hours[$key]) {
                            case '1':
                                $price = 95;
                                break;
                            case '2':
                                $price = 150;
                                break;
                            case '3':
                                $price = 195;
                                break;
                            case '4':
                                $price = 215;
                                break;

                        }
                        break;
                }
                $courses_clients = new ClientCourse();
                $courses_clients->client_id = $client->id;
                $courses_clients->course_id = $course;
                $courses_clients->total = $price;
                $courses_clients->hours = $request->hours[$key] ?? 0;
                $courses_clients->save();
            }
        }

        return redirect()->route('clients.index');
    }
    public function show($id)
    {
        $client = Clients::find($id);
        switch ($client->level) {
            case 1:
                $level = '1º ESO';
                break;
            case 2:
                $level = '2º ESO';
                break;
            case 3:
                $level = '3º ESO';
                break;
            case 4:
                $level = '4º ESO';
                break;
            case 5:
                $level = '1º Bachillerato';
                break;
            case 6:
                $level = '2º Bachillerato';
                break;
            case 7:
                $level = 'Universidad';
                break;
            case 8:
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

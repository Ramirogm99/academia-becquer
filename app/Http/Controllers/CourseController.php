<?php

namespace App\Http\Controllers;

use App\DataTables\CoursesDataTable;
use App\Models\Courses;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    //

    public function index(CoursesDataTable $dataTable)
    {
        $courses = Courses::all();
        return $dataTable->render('courses.index', ['courses' => $courses]);
    }
    public function create()
    {
        $courses = Courses::all();
        return view('courses.create', ["courses" => $courses]);
    }
    public function store(Request $request)
    {
        $course = new Courses();
        $course->name = $request->name;
        $course->price = $request->price;
        $course->course = $request->course;
        $course->save();
        return redirect()->route('courses.index');
    }
    public function edit($id)
    {
        $course = Courses::find($id);
        return view('courses.edit', ['course' => $course]);
    }
    public function update(Request $request)
    {
        $course = Courses::find($request->course_id);
        $course->name = $request->name;
        $course->price = $request->price;
        $course->course = $request->course;
        $course->save();
        return redirect()->route('courses.index');
    }
    public function show($id)
    {
        $course = Courses::find($id);
        switch ($course->course) {
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
        // TODO: añadir cursos
        return view('courses.show', ['course' => $course, 'level' => $level]);
    }
    public function delete($id)
    {
        $client = Courses::find($id);
        $client->delete();
        return redirect()->route('courses.index');
    }
    public function getCoursePrice($id)
    {
        $course = Courses::find($id);
        return json_encode($course->price);
    }
}

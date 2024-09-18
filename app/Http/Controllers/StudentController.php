<?php

namespace App\Http\Controllers;

use App\Models\User;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Exception;

class StudentController extends Controller
{
    public function getStudents()
    {
        try {
            $dataStudents = User::all();

            return view('', [
                'students' => $dataStudents,
            ]);
        } catch (Exception $error) {

        }
    }

    public function getStudentById($id)
    {
        try{
            $student = User::findOrFail($id);

        return view('', [
            'student' => $student
        ]);
        } catch(Exception $error){
            
        }
        
    }
}

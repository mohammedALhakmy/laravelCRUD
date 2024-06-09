<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{

    public function index()
    {
    $student = Student::latest()->orderBy('id','DESC')->get();
        if ($student->count() > 0){
            return response()->json([
                'status'=>200,
                'student' =>$student
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'student' =>"No Records Found"
            ]);
        }
    }

    public function store(Request $request)
    {
        $vid = Validator::make($request->all(),[
            'name' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'email' => 'required|max:191|email',
            'phone' => 'required|digits:10',
        ]);
        if ($vid->fails()){
            return response()->json([
               'status' => 422,
               'errors' => $vid->messages()
            ],422);
        }else{

            $student = Student::create([
               'name' => $request->name,
               'course' => $request->course,
               'email' => $request->email,
               'phone' => $request->phone,
            ]);
            if ($student){
                return response()->json([
                   'status' => 200,
                   'message' => "Student Created SuccessFully",
                ],200);
            }else{
                return response()->json([
                    'status' => 500,
                    'message' => "Something Went Wrong",
                ],200);
            }
        }
    }

    public function show($id){
        $student = Student::find($id);
        if ($student){
            return response()->json([
                'status' => 200,
                'student' => $student,
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => "No Such Student found",
            ],200);
        }
    }
    public function edit($id){
        $student = Student::find($id);
        if ($student){
            return response()->json([
                'status' => 200,
                'student' => $student,
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => "No Such Student found",
            ],200);
        }
    }
    public function update(Request $request,$id){
        $vid = Validator::make($request->all(),[
            'name' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'email' => 'required|max:191|email',
            'phone' => 'required|digits:10',
        ]);
        if ($vid->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $vid->messages()
            ],422);
        }else{
            $student = Student::where('id',$id)->update([
                'name' => $request->name,
                'course' => $request->course,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
            if ($student){
                return response()->json([
                    'status' => 200,
                    'message' => "Student Updated SuccessFully",
                ],200);
            }else{
                return response()->json([
                    'status' => 500,
                    'message' => "No Such Student Found",
                ],200);
            }
        }
    }

    public function delete($id){
        $student = Student::find($id);
        if ($student){
            $student->delete();
            return response()->json([
                'status' => 200,
                'message' => "Student Deleted SuccessFully",
            ],200);
        }else{
            return response()->json([
                'status' => 500,
                'message' => "No Such Student Found",
            ],200);
        }
    }
}

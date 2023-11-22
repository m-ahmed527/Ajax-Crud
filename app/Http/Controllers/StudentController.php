<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentsRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Models\Student;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Client\ResponseSequence;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function studentList(Request $request)
    {
        if ($request->search != '') {

            $data = Student::where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('email', 'LIKE', '%' . $request->search . '%')->get();
            if (count($data) > 0) {
                return response()->json([
                    'searched' => $data,
                ]);
            }
        } else {
            $students = Student::all();
            return response()->json([
                'student' => $students,
            ]);
        }
    }
    public function index()
    {

        return view('screens.student-form');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(StudentsRequest $request)
    {
        $imageName = null; // Initialize imageName variable

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName(); // Use the original filename
            $image->move(public_path('images'), $imageName);
        }

        $requestData = $request->sanitized();

        // If an image was uploaded, add the 'image' key to the sanitized data
        if ($imageName !== null) {
            $requestData['image'] = $imageName;
        }

        $student = Student::create($requestData);
        return response()->json([
            'success' => 'Reacord Has Been Created.'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        return view('screens.student-edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentUpdateRequest $request, Student $student)
    {
        $req = $request->sanitized();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName(); // Use the original filename
            $image->move(public_path('images'), $imageName);
            $req['image'] = $imageName;
        } else {

            $req['image'] = $student->image;
        }
        $student->update($req);
        return response()->json([
            "result" => "updated"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Student::where('id', $id)->delete();
        return response()->json([
            "result" => "deleted",
        ]);
    }

    // public function search(Request $request)
    // {
    //     if($request->search){

    //         $data = Student::where('name', 'LIKE', '%' . $request->search . '%')
    //             ->orWhere('email', 'LIKE', '%' . $request->search . '%')->get();
    //             // dd($data);
    //             if(count($data)>0){
    //                 return response()->json([
    //                     'searched'=>$data,
    //                 ]);
    //             }
    //     }else{
    //         $students=Student::all();
    //         return response()->json([
    //             'searched'=>$students,
    //         ]);
    //     }
    // }
}

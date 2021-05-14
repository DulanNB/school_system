<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\courses;
use App\Models\student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function course_index()
    {
        $courses=courses::getAllCourses();

        return view('backend.courses.index')->with('courses',$courses);
    }

    public function course_create()
    {
        return view('backend.courses.create');
    }
    public function course_store(Request  $request)
    {
        // return $request->all();
        $this->validate($request,[
            'course_name'=>'string|required',
            'value'=>'numeric|required',
            'credits'=>'required|numeric',
        ]);
        $data= $request->all();

        $status=courses::create($data);

        if($status){
            request()->session()->flash('success','Course successfully added');
        }

        else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }

        return redirect()->route('course.index');
    }
    public function course_destroy($id)
    {
        $courses=courses::findOrFail($id);
        $status=$courses->delete();
        if($status){
            request()->session()->flash('success','Course successfully deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting Course');
        }
        return redirect()->route('course.index');
    }
}

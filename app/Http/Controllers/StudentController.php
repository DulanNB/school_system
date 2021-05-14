<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\courses;
use App\Models\payments;
use App\Models\student;
use App\payment_methods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    public function index()
    {
        $students=student::getAllStudents();

        return view('backend.student.index')->with('students',$students);
    }

    public function create()
    {
       return view('backend.student.create');
    }

    public function store(Request  $request)
    {
        // return $request->all();
        $this->validate($request,[
            'name'=>'string|required',
            'email'=>'unique:students|required',
            'address'=>'string|required',
            'contact_no'=>'required|min:11|numeric',
        ]);
        $data= $request->all();
        $last_number = DB::table('students')->latest('admission_num')->first() ;
        if($last_number == null)
        {
            $data['admission_num'] =  'st-' . ((int)$last_number + 1);
        }
        else{
            $record = student::latest()->first();
            $expNum = explode('-', $record->admission_num);
            $data['admission_num']= 'st-' . ((int)$expNum[1]+1);
        }


        $status=student::create($data);

        if($status){
            request()->session()->flash('success','Student successfully added');
        }

        else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }

        return redirect()->route('student.index');

    }
    public function edit($id)
    {
        $student=student::findOrFail($id);
        return view('backend.student.edit')->with('student',$student);
    }

    public function update(Request $request, $id)
    {
        $student=student::findOrFail($id);

        $this->validate($request,[
            'name'=>'string|required',
            'email'=>'required',
            'address'=>'string|required',
            'contact_no'=>'required|min:11|numeric',
        ]);
        $data= $request->all();
        $status=$student->fill($data)->save();

        if($status){
            request()->session()->flash('success','Student Data successfully updated');
        }
        else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }
        return redirect()->route('student.index');
    }

    public function destroy($id)
    {
        $student=student::findOrFail($id);
        $status=$student->delete();
        if($status){
            request()->session()->flash('success','Student successfully deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting Student');
        }
        return redirect()->route('student.index');
    }
    public function enroll_view($id)
    {
        $student=student::findOrFail($id);
        $courses = courses::all();
        $payment_methods = payment_methods::all();

        return view('backend.student.course_enroll')->with('student',$student)->with('courses',$courses)->with('payment_methods',$payment_methods);
    }
    public function enroll(Request $request,$id)
    {
        $this->validate($request,[
            'course_select'=>'required',
            'payment'=>'required|not_in:0'
        ]);

        $count = count($request->course_select) ;

        if($count>0){
            foreach ($request->course_select as $C)
            {
                $status = payments::create([
                    'student_id' => $id,
                    'course_id' => $C,
                    'payment_method' => $request->payment,
                    'paid_status' => 1
                ]);
            }
            if($status){
                request()->session()->flash('success','Course Enrolment success');
            }
            else{
                request()->session()->flash('error','Error occurred, Please try again!');
            }
            return redirect()->route('student.index');
        }

    }
    public function course_view(Request $request, $id)
    {
        $students = DB::table('payments')
            ->select('payments.*','students.name','courses.course_name','courses.credits')
            ->leftJoin('students','students.id','=','payments.student_id')
            ->leftJoin('courses','courses.id','=','payments.course_id')
            ->where('payments.student_id','=',$id)
            ->paginate(10);

        $student_name=student::findOrFail($id);

        return view('backend.student.enrolled_course')->with('students',$students)->with('student_name',$student_name);
    }
}

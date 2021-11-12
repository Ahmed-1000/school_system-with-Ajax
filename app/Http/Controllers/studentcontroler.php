<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\student;
use App\Models\courseinfo;
use Illuminate\Support\Facades\Hash;
use  Illuminate\Support\Facades\Auth;
use DataTables;

class studentcontroler extends Controller
{
    public function register(){

          return view('dashboard.student.student-register');
    }
    public function Home(){

          return view('dashboard.student.Home');
    }
    public function create(Request $request){
        $validator = \Validator::make($request->all(),[
            'first'=>'required',
            'last'=>'required',
            'id'=>'required',
            'date'=>'required',

        ]);
        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
            $student = new student();
            $student->first_name = $request->first;
            $student->last_name = $request->last;
            $student->student_id = $request->id;
            $student->date = $request->date;
            $query = $student->save();
            if(!$query){
                  return response()->json(['code'=>0,'msg'=>'something is wrong try again']); 
            }else{
                  return response()->json(['code'=>1,'msg'=>'new student add']); 
            }
        }
    }
    public function getstudentlist(){
        $student =  student::all();
        return DataTables::of($student)
                           ->addIndexColumn()
                           ->addColumn('actions',function($row){
                             return '<div class="btn-group">
                                       <button class="btn btn-sm btn-primary" data-id="'.$row['id'].'" id="editstudent">Update</button>
                                       <button class="btn btn-sm btn-danger" data-id="'.$row['id'].'" id="deletestudent">Delete</button>
                                    </div>';
                           })
                           ->addColumn('checkbox',function($row){
                               return '<input type="checkbox" name="student_checkbox" data-id="'.$row['id'].'"><label></label>';
                           })
                           ->rawColumns(['actions','checkbox'])
                           ->make(true);
    }
    public function getstudentDetails(Request $request){
        $student_Id = $request->student_Id;
        $student = student::find($student_Id);
        return response()->json(['details'=> $student]);
    }
    public function updatestudent(Request $request){
          $student_Id = $request->cid;

          $validator = \Validator::make($request->all(),[
            'first'=>'required'.$student_Id,
            'last'=>'required',
            'id'=>'required',
            'date'=>'required'
          ]);
          if(!$validator->passes()){
                  return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
          }else{
                     $student = student::find($student_Id);
                     $student->first_name = $request->first;
                     $student->last_name = $request->last;
                     $student->student_id = $request->id;
                     $student->date = $request->date;
                       $query = $student->update();
                     if($query){
                           return response()->json(['code'=>1,'msg'=>'success update']);
                     }else{
                         
                          return response()->json(['code'=>0,'msg'=>'something is wrong try again']); 
                     }
          }
    }
    public function deletestudent(Request $request){
           $student_Id = $request->student_Id;
           $student = student::find($student_Id)->delete();

              if($student){
                 return response()->json(['code'=>1,'msg'=>'student has been delete from database']);
              }else{
                         
                return response()->json(['code'=>0,'msg'=>'something is wrong try again']); 
              }
    }
    public function deleteselectedstudent(Request $request){
            $student_Ids = $request->student_Ids;
            student::whereIn('id', $student_Ids)->delete();
             return response()->json(['code'=>1,'msg'=>'students has been delete from database']);
     }

     // Authentication with Ajax
     public function check(Request $request){
             $validator = \Validator::make($request->all(),[
               'full_first_name' =>  'required|min:6|max:35',
               'password' => 'required|min:5|max:30',
             ]);
             if($validator->fails()){
                  return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
             } else{
                $course = courseinfo::where('fullname', $request->full_first_name)->first();
                if($course){
                    if(Hash::check($request->password, $course->password)){
                        $request->session()->put('LoggInUser',$course->id);
                        return response()->json(['code'=>1,'msg'=>'success']);
                         
                    }else{
                         return response()->json(['code'=>0,'msg'=>'your name or password is wrong!']);
                    }
                } else{
                     return response()->json(['code'=>0,'msg'=>'you not exist in user table!']);
                }
             }
          
     }
     public function usersave(Request $request){
         $validator = \Validator::make($request->all(),[
           'full_first_name' => 'required|min:6|max:35',
           'password' => 'required|min:5|max:30',
           'cpassword' => 'required|min:5|same:password'
         ],[
           'cpassword.same' => 'password did not matched!',
           'cpassword.required' =>'confirm password is required!'
         ]);
         if($validator->fails()){
             return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
         } else{
              $course = new courseinfo();
              $course->fullname = $request->full_first_name;
              $course->password = Hash::make($request->password);
              $course->save();
              return response()->json(['code'=>1,'msg'=>'registertion success']);
         }
     }
 }

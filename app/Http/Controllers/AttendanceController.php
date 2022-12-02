<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\DateAttendance;
use App\Models\Group;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AttendanceController extends Controller
{
    public function index(Request $request){
        abort_if_forbidden('attendance.show');
        if(auth()->user()->hasRole("Super Admin")){
            $groups = Group::all();
        }
        elseif (auth()->user()->hasRole("Teacher")){
            $groups = Group::where('teacher_id',auth()->user()->id)->get();
        }
            $students = Student::all();
        return view('pages.attendances.index',compact('groups', 'students'));
    }
    public function create(Request $request){
        $attenddate = date('Y-m-d');
        $issetgroup = DateAttendance::where('group_id',$request->group_id)->where('date',$attenddate)->first();
        if ($request->attendances == '' || $request->attendances == null){
            message_set('Mumkin emas!', 'error', 2);
            return redirect()->back();
        }
       if(!$issetgroup == null){
           message_set('Bugun uchun Bor yo\'qlama qilingan!','error');
           return redirect()->route('attendanceIndex');
       }

            $date = new DateAttendance();
            $date->group_id = $request->group_id;
            $date->date = $attenddate;
            $date->status = true;
            $date->save();
            $teacher =User::find(auth()->user()->id);
            foreach($request->attendances as $studentid=>$attendance){
                    $attendance_status = $attendance == "on" ? true : false;
                    $attendancedate =  new Attendance();
                    $attendancedate->group_id = $request->group_id;
                    $attendancedate->user_id = $teacher->id;
                    $attendancedate->student_id = $studentid;
                    $attendancedate->create_at = $attenddate;
                    $attendancedate->status = $attendance_status;
                    $attendancedate->save();
            }
            message_set("Muvofaqiyatli Yakunlandi!",'success');
            return redirect()->route('attendanceIndex');
    }
    public function show(){
        if (auth()->user()->hasRole('Super Admin')){
            $groups = Group::all();
        }else{
            $groups = Group::where('teacher_id', auth()->user()->id)->get();
        }
        return view('pages.attendances.show',compact('groups'));
    }
    public function filter(Request $request){
        $group_id = $request->group_id;
        $date = $request->date;
     if(auth()->user()->hasRole('Super Admin'))
     {
         $groups = Group::all();
         if(!DateAttendance::where('group_id',$group_id)->where('date',$date)->exists()){
             message_set('Bu kuni bor yo\'qlama qilinmagan!','error');
             return view('pages.attendances.show',compact('groups'));
         }
         else{
             $attendances = Attendance::where('group_id', $group_id)->where('create_at',$date)->paginate(10);
             return view('pages.attendances.show',compact('groups','attendances'));
         }
     } elseif(auth()->user()->hasRole('Teacher'))
        {
         $groups = Group::where('teacher_id',auth()->user()->id)->get();
         if(!DateAttendance::where('group_id','=',$group_id)
             ->where('date','=',$date)->exists()){
             message_set('Bu kuni bor yo\'qlama qilinmagan!','error');
             return view('pages.attendances.show',compact('groups'));
         }
         else{
             $attendances = Attendance::where('group_id', $group_id)->where('create_at',$date)->paginate(5);
             return view('pages.attendances.show',compact('groups','attendances'));
         }

     }
    }
}

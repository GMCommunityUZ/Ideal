<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\DateAttendance;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AttendanceController extends Controller
{
    public function index(){
        abort_if_forbidden('attendance.show');
        if(auth()->user()->hasRole("Super Admin")){
            $groups = Group::all();
        }
        elseif (auth()->user()->hasRole("Teacher")){
            $groups = Group::where('teacher_id',"=",2)->get();
        }

        return view('pages.attendances.index',compact('groups'));
    }
    public function create(Request $request){
        //shart qolgan
        $attenddate = date('Y-m-d');
        $date = new DateAttendance();
        $date->group_id = $request->group_id;
        $date->date = $attenddate;
        $date->status = true;
        $date->save();
        $teacher =User::find(auth()->user()->id);
        foreach($request->attendances as $studentid=>$attendance){
               if($attendance == "on"){
                   $attendance_status = true;
                   $attendancedate =  new Attendance();
                   $attendancedate->group_id = $request->group_id;
                   $attendancedate->user_id = $teacher->id;
                   $attendancedate->student_id = $studentid;
                   $attendancedate->create_at = $attenddate;
                   $attendancedate->status = $attendance_status;
                   $attendancedate->save();

               }elseif($attendance == "off"){
                   $attendance_status = false;
                   $attendancedate =  new Attendance();
                   $attendancedate->group_id = $request->group_id;
                   $attendancedate->user_id = $teacher->id;
                   $attendancedate->student_id = $studentid;
                   $attendancedate->create_at = $attenddate;
                   $attendancedate->status = $attendance_status;
                   $attendancedate->save();

               }
        }
        return redirect()->route('attendanceIndex');
    }
}

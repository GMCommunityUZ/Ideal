<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TeacherController;
use App\Models\Amount;
use App\Models\Attendance;
use App\Models\DateAttendance;
use App\Models\Group;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    public function index(){
        $groups = Group::with('teacher')->paginate(7);
        return view('pages.group.index', compact('groups'));
    }
    public function add(){
        $teachers = User::all();
        $amounts = Amount::all();
        return view('pages.group.add', compact('teachers', 'amounts'));
    }
    public function create(Request $request){
        $this->validate($request, [
            'name'=>'required',
            'teacher_id'=>'required',
            'amount_id'=>'required',
        ]);
        $group = Group::create([
            'name'=>$request->input('name'),
            'teacher_id'=>$request->input('teacher_id'),
            'amount_id'=>$request->input('amount_id'),
            'monday'=>$request->input('monday'),
            'tuesday'=>$request->input('tuesday'),
            'wednesday'=>$request->input('wednesday'),
            'friday'=>$request->input('friday'),
            'thursday'=>$request->input('thursday'),
            'saturday'=>$request->input('saturday'),
            'sunday'=>$request->input('sunday'),
            'starts_at'=>$request->input('starts_at'),
            'ends_at'=>$request->input('ends_at'),
        ]);
        $group->save();
        return redirect()->route('groupIndex');
    }
    public function edit($id){
        $group = Group::find($id);
        $teachers = User::all();
        $amounts = Amount::all();
        return view('pages.group.edit', compact('group','teachers', 'amounts'));
    }
    public function update(Request $request, $id){
        $this->validate($request, [
            'name'=>'required',
            'teacher_id'=>'required',
            'amount_id'=>'required',
        ]);
        $group = Group::find($id);
        $group->name = $request->input('name');
        $group->teacher_id = $request->input('teacher_id');
        $group->amount_id = $request->input('amount_id');
        $group->monday = $request->input('monday');
        $group->tuesday = $request->input('tuesday');
        $group->wednesday = $request->input('wednesday');
        $group->friday = $request->input('friday');
        $group->thursday = $request->input('thursday');
        $group->saturday = $request->input('saturday');
        $group->sunday = $request->input('sunday');
        $group->starts_at = $request->input('starts_at');
        $group->ends_at = $request->input('ends_at');
        $group->save();
        return redirect()->route('groupIndex');
    }
    public function destroy($id){
        $attendences = Attendance::all();
        foreach($attendences as $attendence):
            $attendence->where('group_id', $id)->delete();
        endforeach;
        $data_attendences = DateAttendance::all();
        foreach($data_attendences as $date_attendence):
            $date_attendence->where('group_id', $id)->delete();
        endforeach;
        $students = Student::all();
        foreach($students as $student):
            $student->where('group_id', $id)->delete();
        endforeach;
        Group::where('id', $id)->delete();
        if(Student::where('group_id',$id)->exists()){
            Student::where('group_id',$id)->delete();
        }elseif(Attendance::where('group_id',$id)->exists()){
            Attendance::where('group_id',$id)->delete();
        }elseif(DateAttendance::where('group_id',$id)->exists()){
            DateAttendance::where('group_id',$id)->delete();
        }

        return redirect()->back();
    }
}

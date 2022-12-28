<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Models\Graphic;
use App\Models\Group;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index(){
        $students = Student::paginate(7);
        return view('pages.student.index', compact('students'));
    }
    public function add(){
        $groups = Group::all();
        return view('pages.student.add', compact('groups'));
    }
    public function create(Request $request){
        $this->validate($request, [
            'name'=>['required', 'min:4'],
            'phone_1'=>['required', 'min:9', 'max:9'],
            'group_id'=>['required'],
        ]);
        $phone_2 = $request->input('phone_2') == null ? 'Mavjud emas' : $request->input('phone_2');
        $student = Student::create([
            'name'=>$request->input('name'),
            'phone_1'=>$request->input('phone_1'),
            'phone_2'=>$phone_2,
            'group_id'=>$request->input('group_id'),
        ]);
        $student->save();
        return redirect()->route('studentIndex');
    }
    public function edit($id){
        $groups = Group::all();
        $student = Student::find($id);
        return view('pages.student.edit', compact('student', 'groups'));
    }
    public function update(Request $request, $id){
        $this->validate($request, [
            'name'=>['required', 'min:4'],
            'phone_1'=>['required', 'min:9', 'max:9'],
            'group_id'=>['required'],
        ]);
        $phone_2 = $request->input('phone_2') == null ? 'Mavjud emas' : $request->input('phone_2');
        $student = Student::find($id);
        $student->name = $request->input('name');
        $student->phone_1 = $request->input('phone_1');
        $student->phone_2 = $phone_2;
        $student->group_id = $request->input('group_id');
        $student->save();
        return redirect()->route('studentIndex');
    }
    public function destroy($id){
        Student::where('id', $id)->delete();
        return redirect()->back();
    }
    public function graphicAdd(){
        $newstudents = Student::whereNotExists(function($query)
        {
            $query->select(DB::raw(1))
                ->from('graphics')->whereMonth('month', now()->format('m'))
                ->whereRaw('students.id = graphics.student_id');
        })->get();

        if ($newstudents->count() == 0){
            message_set('Yangi o\'quvchi mavjud emas!', 'warning', 2);
            return  redirect()->back();
        }
        foreach($newstudents as $student):
            Graphic::create([
                'month' => now()->format('Y-m-d'),
                'student_id' => $student->id,
                'group_id' => $student->group->id,
                'paid_amount' => 0,
                'remaining_amount' => 0,
                'status' => 'To\'lanmagan',
                'discount_amount' => 0,
                'comment'=>'Mavjud emas',
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
            ]);
        endforeach;
        message_set('Qo\'shildi', 'success', 2);
        return redirect()->back();
    }
}

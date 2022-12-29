<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class TeacherController extends Controller
{
    public function index(){
        abort_if_forbidden('teacher.show');
        $teachers = User::where('id','!=','1')->get();
        return view('pages.teachers.index',compact('teachers'));
    }
    public function add(){
        abort_if_forbidden('teacher.add');
        return view('pages.teachers.add');
    }

    public function create(Request $request){

        abort_if_forbidden('teacher.add');
        $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone'=>['required']
        ]);

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'course'=>$request->course,
            'phone'=>$request->phone
        ]);
        $user->save();
        message_set("O'qtuvchi muvaffaqiyatli yaratildi!",'success');
        return redirect()->route('teacherIndex');

    }
    public function edit($id){
        abort_if_forbidden('teacher.edit');
        $teacher  = User::find($id);
        return view('pages.teachers.edit',compact('teacher'));
    }

    public function update(Request $request,$id){
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255',],
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->course = $request->course;
        if ($request->get('password') != null)
        {
            $user->password = Hash::make($request->get('password'));
        }
        $user->save();
        message_set("O'qtuvchi muvaffaqiyatli o'zgartirildi!",'success');
        return redirect()->route('teacherIndex');
    }
    public function destroy($id){
        abort_if_forbidden('teacher.delete');
        $teacher = User::find($id);
        $teacher->delete();
        message_set("O'qtuvchi muvaffaqiyatli o'chirildi!",'success');
        return redirect()->route('teacherIndex');
    }
}

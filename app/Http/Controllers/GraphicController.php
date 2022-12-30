<?php

namespace App\Http\Controllers;

use App\Exports\GraphicExport;
use App\Models\Graphic;
use App\Models\Group;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel;

class GraphicController extends Controller
{
    public function index(){
        $teachers = User::where('id', '!=', 1)->get();
        $groups = Group::all();
        return view('pages.graphic.index', compact('teachers', 'groups'));
    }
    public function graphicStudents($id){
        $graphics = Graphic::whereMonth('month', now()->format('m'))->where('group_id', $id)->get();
        $group = Group::where('id', $id)->first();
        return view('pages.graphic.students', compact('group', 'graphics'));
    }
    public function add($id){
        $students = Student::where('group_id', $id)->whereNotExists(function($query)
        {
            $query->select(DB::raw(1))
                ->from('graphics')->whereMonth('month', now()->format('m'))
                ->whereRaw('students.id = graphics.student_id');
        })->get();
        return view('pages.graphic.add', compact('students','id'));
    }
    public function create(Request $request){
        $this->validate($request, [
            'student_id'=>'required',
            'paid_amount'=>['required',  'min:5', 'max:6']
        ]);
        $st_id = Group::where('id', $request->group_id)->first();
        $discount_amount = $request->discount_amount != '' ? $request->discount_amount : 0;
        $amountAll = $request->paid_amount + $request->discount_amount;
        $remaining_amount = $request->paid_amount != 0 ? $st_id->amount->price - $amountAll : 0;
        $comment = $request->comment != null ? $request->comment : 'Mavjud emas';
        $month = $request->month != '' ? date('Y-m-d', strtotime($request->month)) : now()->format('Y-m-d');
        if ($remaining_amount != 0){
            $status = 'To\'liq emas';
        }elseif ($request->paid_amount == 0 && $remaining_amount == 0){
            $status = 'To\'lanmagan';
        }elseif($request->paid_amount != 0 && $remaining_amount ==0){
            $status = 'To\'langan';
        }
        $graphic = Graphic::create([
            'student_id'=>$request->input('student_id'),
            'paid_amount'=>$request->input('paid_amount'),
            'month'=>$month,
            'discount_amount'=>$discount_amount,
            'group_id'=>$request->input('group_id'),
            'remaining_amount'=>$remaining_amount,
            'comment'=>$comment,
            'status'=>$status,
        ]);
        $graphic->save();
        return redirect()->route('graphicStudents', $request->group_id);
    }
    public function edit($id){
        $graphic = Graphic::find($id);
        $students = Student::where('group_id', $graphic->group_id)->get();
        return view('pages.graphic.edit', compact('graphic', 'students','id'));
    }
    public function update(Request $request, $id){
        $this->validate($request, [
            'student_id'=>'required',
            'paid_amount'=>['required',  'min:5', 'max:6']
        ]);
        $st_id = Group::where('id', $request->group_id)->first();
        $discount_amount = $request->discount_amount != '' ? $request->discount_amount : 0;
        $amountAll = $request->paid_amount + $request->discount_amount;
        $remaining_amount = $request->paid_amount != 0 ? $st_id->amount->price - $amountAll : 0;
        $comment = $request->comment != null ? $request->comment : 'Mavjud emas';
        $month = $request->month != '' ? date('Y-m-d', strtotime($request->month)) : now()->format('Y-m-d');
        if ($remaining_amount != 0){
            $status = 'To\'liq emas';
        }elseif ($request->paid_amount == 0 && $remaining_amount == 0){
            $status = 'To\'lanmagan';
        }elseif($request->paid_amount != 0 && $remaining_amount ==0){
            $status = 'To\'langan';
        }
        $graphic = Graphic::find($id);
        $graphic->student_id = $request->input('student_id');
        $graphic->paid_amount = $request->input('paid_amount');
        $graphic->month = $month;
        $graphic->discount_amount = $discount_amount;
        $graphic->group_id = $request->input('group_id');
        $graphic->remaining_amount = $remaining_amount;
        $graphic->comment = $comment;
        $graphic->status = $status;
        $graphic->update();
        return redirect()->route('graphicStudents', $request->group_id);
    }
    public function destroy($id){
        $graphic = Graphic::find($id);
        $graphic->delete();
        return redirect()->back();
    }
    public function graphicPay($id){
        $group_id = Graphic::find($id);
        if ($group_id->status != 'To\'langan' && $group_id->status != 'To\'liq emas'){
            Graphic::find($id)->update([
                'student_id'=>$group_id->student_id,
                'paid_amount'=>$group_id->group->amount->price,
                'month'=>now()->format('Y-m-d'),
                'discount_amount'=>0,
                'group_id'=>$group_id->group_id,
                'remaining_amount'=>0,
                'comment'=>'Mavjud emas',
                'status'=>'To\'langan',
            ]);
            message_set('To\'landi', 'success', 2);
        }else{
            message_set('To\'lov allaqachon qilinan!', 'warning', 2);
        }
        return redirect()->back();
    }
    public function graphicAll(Request $request){
        $groups = Group::all();
        $searches = ['name', 'group_id', 'month', 'status'];
        $graphics = Graphic::whereMonth('month', now()->format('m'))->with('student');
        foreach ($searches as $search):
            if ($request->has($search) && strlen($request->$search)){
                $graphics = $graphics->whereHas('student', function ($query) use ($request, $search) {
                    $query->where($search, 'like', '%' . $request->$search . '%');
                });
            }
        endforeach;
            $graphics = $graphics->paginate('10');
        return view('pages.graphic.all', compact('graphics', 'groups'));
    }
    public function graphicHistory(Request $request){
        $groups = Group::all();
        $searches = ['name', 'group_id', 'month', 'status'];
        $graphics = Graphic::whereMonth('month', '!=',now()->format('m'))->with('student');
        foreach ($searches as $search):
            if ($request->has($search) && strlen($request->$search)){
                $graphics = $graphics->whereHas('student', function ($query) use ($request, $search) {
                    $query->where($search, 'like', '%' . $request->$search . '%');
                });
            }
        endforeach;
        $graphics = $graphics->paginate('10');
        return view('pages.graphic.history', compact('graphics', 'groups'));
    }
    public function export()
    {
        $excel = App::make('excel');

        return $excel->download(new GraphicExport, 'graphic.xlsx');
    }
}

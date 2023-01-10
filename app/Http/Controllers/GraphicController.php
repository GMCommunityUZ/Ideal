<?php

namespace App\Http\Controllers;

use App\Exports\GraphicExport;
use App\Models\Graphic;
use App\Models\Group;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel;

class GraphicController extends Controller
{
    public function index(){
        $teachers = User::where('id', '!=', 1)->get();
        $groups = Group::all();
        return view('pages.graphic.index', compact('teachers', 'groups'));
    }
    public function graphicStudents(Request $request, $id){
        $searches = ['name', 'status'];
        $graphics = Graphic::whereMonth('month', now()->format('m'))->with('student');
        foreach ($searches as $search):
            if ($request->has($search) && strlen($request->$search)){
                $graphics = $graphics->whereHas('student', function ($query) use ($request, $search) {
                    $query->where($search, 'like', '%' . $request->$search . '%');
                });
            }
        endforeach;
        $graphics = $graphics->where('group_id', $id)->paginate(7);
        $amount = $graphics->sum('paid_amount');
        $group = Group::where('id', $id)->first();
        return view('pages.graphic.students', compact('group', 'graphics', 'amount', 'id'));
    }
    public function add($id){
        $students = Student::where('group_id', $id)->get();
        return view('pages.graphic.add', compact('students','id'));
    }
    public function create(Request $request){
        $this->validate($request, [
            'student_id'=>'required',
            'paid_amount'=>['required']
        ]);
        $st_id = Group::where('id', $request->group_id)->first();
        $discount_amount = $request->discount_amount != '' ? $request->discount_amount : 0;
        $amountAll = $request->paid_amount + $request->discount_amount;
        $remaining_amount = $request->paid_amount != 0 ? $st_id->amount->price - $amountAll : 0;
        $comment = $request->comment != null ? $request->comment : 'Mavjud emas';
        if ($request->get('monthSelected') != null && $request->month == null){
            $month = date('Y-'.$request->monthSelected.'-d');
        }elseif ($request->month == null && $request->monthSelected == null){
            $month = now()->format('Y-m-d');
        }elseif ($request->month != null){
            $month = date('Y-m-d', strtotime($request->month));
        }
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
        if ($request->input('monthSelected') != null){
            $newMonth = '';
            if ($request->input('monthSelected') == '01'){
                $newMonth = 'January';
            }elseif ($request->input('monthSelected') == '02'){
                $newMonth = 'February';
            }elseif ($request->input('monthSelected') == '03'){
                $newMonth = 'March';
            }elseif ($request->input('monthSelected') == '04'){
                $newMonth = 'April';
            }elseif ($request->input('monthSelected') == '05'){
                $newMonth = 'May';
            }elseif ($request->input('monthSelected') == '06'){
                $newMonth = 'June';
            }elseif ($request->input('monthSelected') == '07'){
                $newMonth = 'July';
            }elseif ($request->input('monthSelected') == '08'){
                $newMonth = 'August';
            }elseif ($request->input('monthSelected') == '09'){
                $newMonth = 'September';
            }elseif ($request->input('monthSelected') == '10'){
                $newMonth = 'October';
            }elseif ($request->input('monthSelected') == '11'){
                $newMonth = 'November';
            }elseif ($request->input('monthSelected') == '12'){
                $newMonth = 'December';
            }
            return redirect()->back()->setTargetUrl('/graphics/'.$request->group_id.'/month/'.$newMonth);
        }
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
            'paid_amount'=>['required']
        ]);
        $st_id = Group::where('id', $request->group_id)->first();
        $discount_amount = $request->discount_amount != '' ? $request->discount_amount : 0;
        $amountAll = $request->paid_amount + $request->discount_amount;
        $remaining_amount = $request->paid_amount != 0 ? $st_id->amount->price - $amountAll : 0;
        $comment = $request->comment != null ? $request->comment : 'Mavjud emas';
        if ($request->get('monthSelected') != null && $request->month == null){
            $month = date('Y-'.$request->monthSelected.'-d');
        }elseif ($request->month == null && $request->monthSelected == null){
            $month = now()->format('Y-m-d');
        }elseif ($request->month != null){
            $month = date('Y-m-d', strtotime($request->month));
        }
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
        if ($request->input('monthSelected') != null){
            $newMonth = '';
            if ($request->input('monthSelected') == '01'){
                $newMonth = 'January';
            }elseif ($request->input('monthSelected') == '02'){
                $newMonth = 'February';
            }elseif ($request->input('monthSelected') == '03'){
                $newMonth = 'March';
            }elseif ($request->input('monthSelected') == '04'){
                $newMonth = 'April';
            }elseif ($request->input('monthSelected') == '05'){
                $newMonth = 'May';
            }elseif ($request->input('monthSelected') == '06'){
                $newMonth = 'June';
            }elseif ($request->input('monthSelected') == '07'){
                $newMonth = 'July';
            }elseif ($request->input('monthSelected') == '08'){
                $newMonth = 'August';
            }elseif ($request->input('monthSelected') == '09'){
                $newMonth = 'September';
            }elseif ($request->input('monthSelected') == '10'){
                $newMonth = 'October';
            }elseif ($request->input('monthSelected') == '11'){
                $newMonth = 'November';
            }elseif ($request->input('monthSelected') == '12'){
                $newMonth = 'December';
            }
            return redirect()->back()->setTargetUrl('/graphics/'.$request->group_id.'/month/'.$newMonth);
        }
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
            message_set('Amal bajarilmadi, mumkin emas!', 'warning', 2);
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
    public function export($id)
    {
        $graphics = Graphic::whereMonth('month', now()->format('m'))->where('group_id', $id)->get();
        if ($graphics->all() == null){
            message_set('Bo\'sh', 'warning', 2);
            return redirect()->back();
        }
        $excel = App::make('excel');
        $random = rand(1111,9999);
        return $excel->download(new GraphicExport($graphics), 'graphic'.$random.'.xlsx');
    }
    public function months(){
        $newDateTime = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        return view('pages.graphic.months', compact('newDateTime'));
    }
    public function groupGraphicTeacher($item){
        $teachers = User::where('id', '!=', 1)->get();
        $groups = Group::all();
        return view('pages.graphic.group-teacher', compact('teachers', 'groups', 'item'));
    }
    public function graphicStudentsMonth(Request $request, $id, $item){
        $month = '';
        if ($item == 'January'){
            $month = '01';
        }elseif ($item == 'February'){
            $month = '02';
        }elseif ($item == 'March'){
            $month = '03';
        }elseif ($item == 'April'){
            $month = '04';
        }elseif ($item == 'May'){
            $month = '05';
        }elseif ($item == 'June'){
            $month = '06';
        }elseif ($item == 'July'){
            $month = '07';
        }elseif ($item == 'August'){
            $month = '08';
        }elseif ($item == 'September'){
            $month = '09';
        }elseif ($item == 'October'){
            $month = '10';
        }elseif ($item == 'November'){
            $month = '11';
        }elseif ($item == 'December'){
            $month = '12';
        }
        $searches = ['name', 'status'];
        $graphics = Graphic::whereMonth('month', now()->format($month));
        foreach ($searches as $search):
            if ($request->has($search) && strlen($request->$search)){
                $graphics = $graphics->whereHas('student', function ($query) use ($request, $search) {
                    $query->where($search, 'like', '%' . $request->$search . '%');
                });
            }
        endforeach;
            $graphics = $graphics->where('group_id', $id)->paginate(7);
        $amount = $graphics->sum('paid_amount');
        $group = Group::where('id', $id)->first();
        return view('pages.graphic.month-students', compact('group', 'graphics', 'amount', 'id', 'item'));
    }
    public function exportMonth($id, $item)
    {
        $month = '';
        if ($item == 'January'){
            $month = '01';
        }elseif ($item == 'February'){
            $month = '02';
        }elseif ($item == 'March'){
            $month = '03';
        }elseif ($item == 'April'){
            $month = '04';
        }elseif ($item == 'May'){
            $month = '05';
        }elseif ($item == 'June'){
            $month = '06';
        }elseif ($item == 'July'){
            $month = '07';
        }elseif ($item == 'August'){
            $month = '08';
        }elseif ($item == 'September'){
            $month = '09';
        }elseif ($item == 'October'){
            $month = '10';
        }elseif ($item == 'November'){
            $month = '11';
        }elseif ($item == 'December'){
            $month = '12';
        }
        $graphics = Graphic::whereMonth('month', now()->format($month))->where('group_id', $id)->get();
        if ($graphics->all() == null){
            message_set('Bo\'sh', 'warning', 2);
            return redirect()->back();
        }
        $excel = App::make('excel');
        $random = rand(1111, 9999);
        return $excel->download(new GraphicExport($graphics), 'graphic'.$random.'.xlsx');
    }
    public function addWithMonth($id, $item){
        $month = '';
        if ($item == 'January'){
            $month = '01';
        }elseif ($item == 'February'){
            $month = '02';
        }elseif ($item == 'March'){
            $month = '03';
        }elseif ($item == 'April'){
            $month = '04';
        }elseif ($item == 'May'){
            $month = '05';
        }elseif ($item == 'June'){
            $month = '06';
        }elseif ($item == 'July'){
            $month = '07';
        }elseif ($item == 'August'){
            $month = '08';
        }elseif ($item == 'September'){
            $month = '09';
        }elseif ($item == 'October'){
            $month = '10';
        }elseif ($item == 'November'){
            $month = '11';
        }elseif ($item == 'December'){
            $month = '12';
        }
        $students = Student::where('group_id', $id)->get();
        return view('pages.graphic.add', compact('students','id', 'month', 'item'));
    }
    public function editMonth($id, $item){
        $month = '';
        if ($item == 'January'){
            $month = '01';
        }elseif ($item == 'February'){
            $month = '02';
        }elseif ($item == 'March'){
            $month = '03';
        }elseif ($item == 'April'){
            $month = '04';
        }elseif ($item == 'May'){
            $month = '05';
        }elseif ($item == 'June'){
            $month = '06';
        }elseif ($item == 'July'){
            $month = '07';
        }elseif ($item == 'August'){
            $month = '08';
        }elseif ($item == 'September'){
            $month = '09';
        }elseif ($item == 'October'){
            $month = '10';
        }elseif ($item == 'November'){
            $month = '11';
        }elseif ($item == 'December'){
            $month = '12';
        }
        $graphic = Graphic::find($id);
        $students = Student::where('group_id', $graphic->group_id)->get();
        return view('pages.graphic.edit', compact('graphic', 'students', 'id', 'month', 'item'));
    }

}

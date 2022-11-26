<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Models\Amount;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AmountController extends Controller
{
    public function index(){
        $amounts = Amount::paginate(7);
        return view('pages.amount.index', compact('amounts'));
    }
    public function add(){
        return view('pages.amount.add');
    }
    public function create(Request $request){
        $this->validate($request, [
            'date'=>'required',
            'price'=>'required|min:4,max:6'
        ]);
        $date = $request->date == null ? now()->format('Y-m-d') : Carbon::createFromFormat('Y-m-d', $request->input('date'));
        $amount = Amount::create([
            'date'=> $date,
            'price'=>$request->input('price'),
        ]);
        $amount->save();
        return redirect()->route('amountIndex');
    }
    public function edit($id){
        $amount = Amount::find($id);
        return view('pages.amount.edit', compact('amount'));
    }
    public function update(Request $request, $id){
        $this->validate($request, [
            'date'=>'required',
            'price'=>'required|min:4,max:6'
        ]);
        $amount = Amount::find($id);
        $amount->date = $request->input('date');
        $amount->price = $request->input('price');
        $amount->save();
        return redirect('amounts');
    }
    public function destroy($id){
        Amount::where('id', $id)->delete();
        return redirect()->back();
    }
}

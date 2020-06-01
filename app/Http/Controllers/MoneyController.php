<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Money;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;


class MoneyController extends BaseController
{
    public function list(){
        $list=Money::all();
        return $this->responseAPI(true,'list',$list,200);

    }
    public function store(Request $request){
        $who_id= Auth::user()->id;
        $time=$request->time;
        $total=$request->total;
        $sub_total=$request->subtotal;
        Money::create([
            'who_id' =>$who_id,
            'time' =>$time,
            'total'=>$total,
            'sub_total' =>$sub_total
            ]);
        return $this->responseAPI(true,'create success',null,200);
    }
    public function  destroy(Request $request){
       $ids=$request->all();
        Money::destroy($ids);
        return $this->responseAPI(true,'delete success',null,200);
    }
    public function  deleteOne($id){
        Money::destroy($id);
        return $this->responseAPI(true,'delete success',null,200);
    }
}

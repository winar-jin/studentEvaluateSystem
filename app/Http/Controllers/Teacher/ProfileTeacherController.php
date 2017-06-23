<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProfileTeacherController extends Controller
{
    public function updateProfile(Request $request){
        /*获取前台请求参数*/
        $id = (int)$request->input('id');
        $name = $request->input('name');
        $sex = $request->input('sex');
        $apartment = $request->input('apartment');
        $phone = $request->input('phone');
        /*更新数据库相应数据*/
        $result = DB::table('teachers')
            ->where('Tid', $id)
            ->update(['Tname' => $name,'Tsex'=>$sex,
                'Tapartment'=>$apartment,'Tphone'=>$phone]);
        if($result){
            return response()->json(['success'=>true]);
        }else{
            return response()->json(['success'=>false]);
        }
    
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProfileAdminController extends Controller
{
    public function updateProfile(Request $request){
        /*获取前台请求参数*/
        $id = (int)$request->input('id');
        $name = $request->input('name');
        $sex = $request->input('sex');
        $phone = $request->input('phone');
        /*更新数据库相应数据*/
        $result = DB::table('admin')
            ->where('Aid', $id)
            ->update(['Aname' => $name,'Asex'=>$sex,'Aphone'=>$phone]);
        if($result){
            return response()->json(['success'=>true]);
        }else{
            return response()->json(['success'=>false]);
        }
    }
}

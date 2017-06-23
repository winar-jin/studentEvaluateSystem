<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AddOneUserController extends Controller
{
    public function addOneUser(Request $request){
        /*获取前台请求数据*/
        $id = (int)$request->input('id');
        $target = $request->input('target');
        $name = $request->input('name');
        $sex = $request->input('sex');
        $apartment = $request->input('apartment');
        $grade = $request->input('grade');
        $class = $request->input('class');
        $phone = $request->input('phone');

        $pwd = md5(123456);
        /*分情况操作数据库*/
        if($target=='teacher'){
            $queryResult=DB::table('teachers')
                ->insert(['Tid'=>$id,'Tname'=>$name,'Tpassword'=>$pwd,'Tsex'=>$sex,
                'Tphone'=>$phone,'Tapartment'=>$apartment,'Tphoto'=>'imags/3.jpg']);

            if($queryResult){
                return response()->json(['success'=>true]);
            }else{
                return response()->json(['success'=>false]);
            }
        }

        elseif($target=='student'){
            $queryResult=DB::table('students')
                ->insert(['Sid'=>$id,'Sname'=>$name,'Spassword'=>$pwd,'Ssex'=>$sex,
                'Sapartment'=>$apartment,'Sclass'=>$class,'Sgrade'=>$grade,'Sphoto'=>'imags/3.jpg']);

            if($queryResult){
                return response()->json(['success'=>true]);
            }else{
                return response()->json(['success'=>false]);
            }
        }
    }
}

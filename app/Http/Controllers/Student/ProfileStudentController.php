<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProfileStudentController extends Controller
{
    public function updateProfile(Request $request){
        /*获取前台请求参数*/
        $id = (int)$request->input('id');
        $name = $request->input('name');
        $sex = $request->input('sex');
        $class = $request->input('class');
        $grade = $request->input('grade');
        $apartment = $request->input('apartment');
        /*更新数据库相应数据*/
        $result = DB::table('students')
            ->where('Sid', $id)
            ->update(['Sname' => $name,'Ssex'=>$sex,'Sapartment'=>$apartment,
                'Sclass'=>$class,'Sgrade'=>$grade]);
        if($result){
            return response()->json(['success'=>true]);
        }else{
            return response()->json(['success'=>false]);
        }
    }
}

<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GetGradeController extends Controller
{
    public function getGrade(Request $request){
        /*获取前台请求参数*/
        $id = (int)$request->input('id');

        /*查询数据库获取年级数据*/
        $result = DB::table('students')
            ->where('Sid',$id)
            ->select('Sgrade')
            ->first();

        if($result){
            return response()->json(['success'=>true,'grade'=>$result->Sgrade]);
        }else{
            return response()->json(['success'=>false,'grade'=>-1]);
        }
    }
}

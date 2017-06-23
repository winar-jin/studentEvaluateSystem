<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GetCourseListController extends Controller
{
    public function getCourseList(Request $request){
        /*获取前台请求数据*/
        $Sid = (int)$request->input('id');
        $term = (int)$request->input('term');

        /*数据库操作*/
        $result = DB::table('Scourses')
        ->where(['Sid'=>$Sid,'Scterm'=>$term])
        ->select('Cname','Scmark')
        ->get();

        if($result){
            return response()->json(['success'=>true,'courseList'=>$result]);
        }else{
            return response()->json(['success'=>false,'courseList'=>null]);
        }

    }
}

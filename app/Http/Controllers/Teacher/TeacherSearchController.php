<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TeacherSearchController extends Controller
{
    public function teacherSearch(Request $request){
        /*receive requested data from frontend*/
        $id = (int)$request->input('id');
        $Cname = $request->input('Cname');
        $Sctime = $request->input('Sctime');
        /*query data from DB*/
        //获取学生姓名(返回一个对象)
        $resultSname = DB::table('Students')
            ->where('Sid', $id)
            ->select('Sname')
            ->first();
        //获取该生指定课程的主客观评分
        $resultScore = DB::table('Scourses')
            ->where(['Sid'=> $id,'Cname'=>$Cname,'Sctime'=>$Sctime])
            ->select('ScmarkObjective','ScmarkSubjective')
            ->first();

        // return response()->json(['success'=>true,'test'=>$resultScore]);

        //若数据库查询没问题，返回数据到前台
        if($resultScore&&$resultSname){
            $data = array('Sid'=>$id,'Sname'=>$resultSname->Sname,'Cname'=>$Cname,
                'score_objective'=>$resultScore->ScmarkObjective,
                'score_subjective'=>$resultScore->ScmarkSubjective);
            return response()->json(['success'=>true,'profile'=>$data]);
        }else{
            return response()->json(['success'=>false,'profile'=>null]);
        }
    }
}

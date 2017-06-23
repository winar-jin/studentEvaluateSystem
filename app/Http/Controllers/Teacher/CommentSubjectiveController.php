<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CommentSubjectiveController extends Controller
{
    public function commentSubjective(Request $request){
        /*获取前台请求参数*/
        $Sid = (int)$request->input('sid');
        $Cid = $request->input('cid');
        $scoreSubjective = (int)$request->input('score_subjective');
        $scoreAvg = (float)$request->input('score_avg');

        /*数据库操作*/
        DB::transaction(function () use($Sid,$Cid,$scoreSubjective,$scoreAvg){
            DB::table('Scourses')//更新选课表
            ->where(['Sid'=>$Sid,'Cid'=>$Cid])
            ->update(['ScmarkSubjective'=>$scoreSubjective,'Scmark'=>$scoreAvg]);

            $sore = DB::table('Scourses')//得出更新后本学期所有成绩综合得分
            ->where(['Sid'=>$Sid,'Cid'=>$Cid])
            ->avg('Scmark');
            $term = DB::table('Scourses')
            ->where(['Sid'=>$Sid,'Cid'=>$Cid])
            ->select('Scterm')
            ->first();

            DB::table('Marks')//更新分数表课程得分
            ->where(['Sid'=>$Sid,'Mterm'=>$term->Scterm])
            ->update(['Mcourse'=>(float)$sore]);

            $result = DB::table('Marks')//从分数表取出所有五个项目得分
            ->where(['Sid'=>$Sid,'Mterm'=>$term->Scterm])
            ->select('Mcourse','Mactivity','Mclassmates','Mpe','MlawPolicy')
            ->first();

            DB::table('Marks')//更新分数表综合得分
            ->where(['Sid'=>$Sid,'Mterm'=>$term->Scterm])
            ->update(['Mscore'=>$result->Mcourse*0.5 + $result->Mactivity*0.2 + $result->Mclassmates*0.1 + $result->Mpe*0.1 + $result->MlawPolicy*0.1]);
        });
        return response()->json(['success'=>true]);

    }
}

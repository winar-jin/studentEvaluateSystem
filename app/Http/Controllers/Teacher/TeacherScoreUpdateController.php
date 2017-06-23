<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TeacherScoreUpdateController extends Controller
{
    public function updateScore(Request $request){
        /*获取前台请求参数*/
        $Sid = (int)$request->input('Sid');
        $Cname = $request->input('Cname');
        $Sctime = $request->input('Sctime');
        $score_subjective = (int)$request->input('score_subjective');
        $score_objective = (int)$request->input('score_objective');
        $score_avg =(float)$request->input('score_avg');

        /*数据库操作*/
        DB::transaction(function () use($Sid,$Cname,
            $Sctime,$score_subjective,$score_objective,$score_avg){//数据库事务更新选课表及分数表
            
            DB::table('Scourses')//更新选课表
            ->where(['Sid'=>$Sid,'Cname'=>$Cname])
            ->update(['ScmarkObjective'=>$score_objective,
            'ScmarkSubjective'=>$score_subjective,
            'Scmark'=>$score_avg]);

            $term = DB::table('Scourses')//取出选课表中term字段
            ->where(['Sid'=>$Sid,'Cname'=>$Cname])
            ->select('Scterm')
            ->first();

            $sore = DB::table('Scourses')//得出更新后本学期所有成绩综合得分
            ->where(['Sid'=>$Sid,'Scterm'=>$term->Scterm])
            ->avg('Scmark');

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

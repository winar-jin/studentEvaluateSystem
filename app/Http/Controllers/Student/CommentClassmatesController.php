<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CommentClassmatesController extends Controller
{
    public function commentClassmates(Request $request){
        /*获取前台请求参数*/
        $Sid = (int)$request->input('sid');
        $Mterm = (int)$request->input('term');
        $score = (int)$request->input('score');
        /*相应数据库操作（利用事务）*/

        DB::transaction(function () use($Sid,$Mterm,$score) {
            
            $result = DB::table('Marks')//取出现有的总分和总人数
            ->where(['Sid'=>$Sid,'Mterm'=>$Mterm])
            ->select('McmSumScore','McmSum')
            ->first();
            
            DB::table('Marks')//更新同学互评目前得分
            ->where(['Sid'=>$Sid,'Mterm'=>$Mterm])
            ->update(['McmSumScore'=>$result->McmSumScore+$score,
                'McmSum'=>$result->McmSum+1,
                'Mclassmates'=>($result->McmSumScore+$score)/($result->McmSum+1)]);

            $allScore = DB::table('Marks')//从分数表取出所有五个项目得分
            ->where(['Sid'=>$Sid,'Mterm'=>$Mterm])
            ->select('Mcourse','Mactivity','Mclassmates','Mpe','MlawPolicy')
            ->first();

            DB::table('Marks')//更新分数表综合得分
            ->where(['Sid'=>$Sid,'Mterm'=>$Mterm])
            ->update(['Mscore'=>$allScore->Mcourse*0.5 + $allScore->Mactivity*0.2 + 
                $allScore->Mclassmates*0.1 + $allScore->Mpe*0.1 + $allScore->MlawPolicy*0.1]);
            // DB::table('Marks')//先更新总分
            // ->where(['Sid'=>$Sid,'Mterm'=>$Mterm])
            // ->increment('McmSumScore',$score);
            // DB::table('Marks')//再更新总人数
            // ->where(['Sid'=>$Sid,'Mterm'=>$Mterm])
            // ->increment('McmSum',1);
            // $result = DB::table('Marks')//取出更新后的总分和总人数
            // ->where(['Sid'=>$Sid,'Mterm'=>$Mterm])
            // ->select('McmSumScore','McmSum')
            // ->first();
            // DB::table('Marks')//最后更新同学互评目前得分
            // ->where(['Sid'=>$Sid,'Mterm'=>$Mterm])
            // ->update(['Mclassmates'=>$result->McmSumScore/$result->McmSum]); 
        });
        return response()->json(['success'=>true]);
    }
}

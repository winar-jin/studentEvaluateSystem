<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GetScoreByIdController extends Controller
{
    public function getScoreById(Request $request){
        /*获取前台请求数据*/
        $Sid = (int)$request->input('Sid');
        $Sctime = $request->input('Sctime');

        /*数据库操作*/
        $result = DB::table('scourses')
        ->where(['Sid'=>$Sid,'Sctime'=>$Sctime])
        ->select('Sname','Cname','ScmarkObjective','ScmarkSubjective','Scmark')
        ->get();

        if($result){
            return response()->json(['success'=>true,'scorelist'=>$result]);
        }else{
            return response()->json(['success'=>false,'scorelist'=>null]);
        }

    }
}

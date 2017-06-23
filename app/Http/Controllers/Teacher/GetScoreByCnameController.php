<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GetScoreByCnameController extends Controller
{
    public function getScoreByCname(Request $request){
        /*获取前台请求数据*/
        $Cid = $request->input('Cid');
        $Sctime = $request->input('Sctime');

        /*数据库操作*/
        $result = DB::table('scourses')
        ->where(['Cid'=>$Cid,'Sctime'=>$Sctime])
        ->select('Sid','Sname','ScmarkObjective','ScmarkSubjective','Scmark')
        ->get();

        if($result){
            return response()->json(['success'=>true,'scorelist'=>$result]);
        }else{
            return response()->json(['success'=>false,'scorelist'=>null]);
        }


    }
}

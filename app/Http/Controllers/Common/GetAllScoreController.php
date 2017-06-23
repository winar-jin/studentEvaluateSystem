<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GetAllScoreController extends Controller
{
    //
    public function getAllScore(Request $request){
        /*receive data from frontend*/
        $id = (int)$request->input('Sid');
        $term = (int)$request->input('term');

        /*return requested data to frontend*/
        /*如果是请求全部学期*/
        if($term==0){
            $result = DB::table('marks')
                ->select('Sname','Mcourse','Mactivity','Mclassmates','Mpe','Mlawpolicy','Mscore')
                ->where('Sid',$id)->get();
            if($result){//查询成功,返回所有学期成绩（1-7待改善）的对象数组
                return response()->json(['success'=>true,'summary'=>$result]);
            }else{//查询失败
                return response()->json(['success'=>false,'summary'=>null]);
            }
        }
        /*如果是请求特定学期*/
        else{
            $result = DB::table('marks')
                ->select('Sname','Mcourse','Mactivity','Mclassmates','Mpe','Mlawpolicy','Mscore')
                ->where(['Sid'=>$id,'Mterm'=>$term])->first();
            if($result){//查询成功,返回该学期成绩的对象
                return response()->json(['success'=>true,'summary'=>$result]);
            }else{
                return response()->json(['success'=>false,'summary'=>null]);
            }
        }
         
    }
}

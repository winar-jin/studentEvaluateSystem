<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GetCourseListController extends Controller
{
    public function getCourseList(Request $request){
        /*获取前台请求参数*/
        $id = (int)$request->input('Tid');
        $term = (int)$request->input('term');

        /*数据库查询*/
        $result = DB::table('courses')
        ->where(['Tid'=>$id,'Cterm'=>$term])
        ->select('Cid','Cname')
        ->get();

        if($result){
            return response()->json(['success'=>true,'courselist'=>$result]);
        }else{
            return response()->json(['success'=>false,'courselist'=>null]);
        }
    }
}

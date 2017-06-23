<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GetSubjectiveListController extends Controller
{
    public function getSubjectiveList(Request $request){
        /*获取前台请求数据*/
        $Cname = $request->input('Cname');
        $Tid = (int)$request->input('Tid');
        $term = (int)$request->input('term');
        $Sctime = $request->input('Sctime');
        $course;
        $result;
        /*数据库操作*/
        DB::transaction(function () use($Cname,$Tid,$term,$Sctime,&$result,&$course){

            $course = DB::table('courses')//查出Cid
            ->where(['Tid'=>$Tid,'Cname'=>$Cname,'Cterm'=>$term])
            ->select('Cid')
            ->first();
            
            $result = DB::table('Scourses')//
            ->where(['Cid'=>$course->Cid,'Sctime'=>$Sctime])
            ->select('Sid','Sname','ScmarkObjective')
            ->get();
        });
        return response()->json(['success'=>true,'cid'=>$course->Cid,'studentlist'=>$result]);
    }
}

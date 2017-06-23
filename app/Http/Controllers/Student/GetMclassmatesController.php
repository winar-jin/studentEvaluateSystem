<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GetMclassmatesController extends Controller
{
    public function getClassmatesMarks(Request $request){
        /*获取前台请求参数*/
        $id = (int)$request->input('id');
        $term = (int)$request->input('term');
        /*查询数据库*/
        //先获取所在班级
        $class=DB::table('Students')
        ->where('Sid',$id)
        ->select('Sclass')
        ->first();

        if($class){
            //再通过班级获得该班所有学生综合得分
            $result = DB::table('marks')
                ->where(['Sclass'=>$class->Sclass,'Mterm'=>$term])
                ->select('Sid','Sname','Mscore')
                ->get();
            
            if($result){
                return response()->json(['success'=>true,'classmates'=>$result]);
            }else{
                return response()->json(['success'=>false,'classmates'=>null]);
            }
        }else{
            return response()->json(['success'=>false,'classmates'=>null]);
        }
        
    }
}

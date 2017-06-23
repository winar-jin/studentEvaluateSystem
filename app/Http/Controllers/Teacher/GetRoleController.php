<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GetRoleController extends Controller
{
    public function getRole(Request $request){
        /*获取前台请求参数*/
        $id = (int)$request->input('id');
        /*查询数据库并进行后续比较判断*/
        $result = DB::table('courses')
            ->where('Tid',$id)
            ->select('Cname')
            ->first();
        if($result){
            switch($result->Cname){
                case '体育':{
                    return response()->json(['success'=>true,'role'=>'pe']);
                }
                break;

                case '法律时政':{
                    return response()->json(['success'=>true,'role'=>'lawPolicy']);
                }
                break;

                case '课外活动':{
                    return response()->json(['success'=>true,'role'=>'activity']);
                }
                break;

                default:{
                    return response()->json(['success'=>true,'role'=>'teacher']);
                }
                break;
            }
        }else{
            return response()->json(['success'=>false,'role'=>'wrong']);
        }
    
    }
}

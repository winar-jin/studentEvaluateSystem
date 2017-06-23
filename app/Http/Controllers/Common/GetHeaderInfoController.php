<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GetHeaderInfoController extends Controller
{
    public function getHeaderInfo(Request $request){
        /*获取前台请求参数*/
        $id = (int)$request->input('id');
        $role = $request->input('role');

        /*数据库查询*/
        $result = null;//查询结果
        switch($role){
            case 'admin':{
                $result = DB::table('admin')
                ->where('Aid',$id)
                ->select('Aname as name','Aphoto as photoPath')
                ->first();
            }
            break;

            case 'teacher':{
                $result = DB::table('teachers')
                ->where('Tid',$id)
                ->select('Tname as name','Tphoto as photoPath')
                ->first();
            }
            break;

            case 'student':{
                $result = DB::table('students')
                ->where('Sid',$id)
                ->select('Sname as name','Sphoto as photoPath')
                ->first();
            }
            break;
        }
        if($result){
            return response()->json(['success'=>true,'headerinfo'=>$result]);
        }else{
            return response()->json(['success'=>false,'headerinfo'=>null]);
        }
    }
}

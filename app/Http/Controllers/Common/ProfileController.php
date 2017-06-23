<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function profile(Request $request){
        /*获取前台请求参数数据*/
        $role = $request->input('role');
        $id = (int)$request->input('id');

        /*根据角色进行相应的查询*/
        switch($role){
            //管理员
            case 'admin':{
                $result = DB::table('Admin')
                    ->where('Aid', $id)
                    ->select('Aid','Aname','Asex','Aphone')
                    ->first();
                if($result){//返回profile为对象
                    return response()->json(['success'=>true,'profile'=>$result]);
                }else{
                    return response()->json(['success'=>false,'profile'=>null]);
                }
            }
            break;

            //老师
            case 'teacher':{
                $result = DB::table('Teachers')
                    ->where('Tid', $id)
                    ->select('Tid','Tname','Tsex','Tapartment','Tphone')
                    ->first();
                if($result){//返回profile为对象
                    return response()->json(['success'=>true,'profile'=>$result]);
                }else{
                    return response()->json(['success'=>false,'profile'=>null]);
                }
            }
            break;
            //学生
            case 'student':{
                $result = DB::table('Students')
                    ->where('Sid', $id)
                    ->select('Sid','Sname','Ssex','Sapartment','Sclass','Sgrade')
                    ->first();
                if($result){//返回profile为对象
                    return response()->json(['success'=>true,'profile'=>$result]);
                }else{
                    return response()->json(['success'=>false,'profile'=>null]);
                }
            }
            break;
            //其他
            default:
                return response()->json(['success'=>false,'profile'=>null]);
            break;
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
//if excel facade needed,cancel the commentary below
// use Maatwebsite\Excel\Facades\Excel;

class SearchInfoController extends Controller
{
    //
    public function searchinfo(Request $request){
        //receive the data from frontend
        $target = $request->input('target');
        $id = (int)$request->input('id');

        /*判断要获取信息的角色*/
        /*1、如果是学生*/
        if($target=='student'){
            $result = DB::table('students')
            ->select('Sid', 'Sname','Ssex','Sclass','Sgrade','Sapartment')
            ->where('Sid',$id)
            ->first();
            if($result){//返回profile为对象
                return response()->json(['success'=>true,'profile'=>$result]);
            }else{
                return response()->json(['success'=>false,'iterm'=>0]);
            }
        }
        /*2、如果是老师*/
        elseif($target=='teacher'){
            $result = DB::table('teachers')
            ->select('Tid', 'Tname','Tsex','Tapartment','Tphone')
            ->where('Tid',$id)
            ->first();
            if($result){//返回profile为对象
                return response()->json(['success'=>true,'profile'=>$result]);
            }else{
                return response()->json(['success'=>false,'iterm'=>0]);
            }
        }

    }
}

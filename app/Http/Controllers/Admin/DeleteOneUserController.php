<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DeleteOneUserController extends Controller
{
    public function deleteOneUser(Request $request){
        /*接收前台请求数据*/
        $target = $request->input('target');
        $id = (int)$request->input('id');

        /*分情况操作数据库*/
        if($target=='teacher'){
            $queryResult = DB::table('teachers')
            ->where('Tid',$id)
            ->delete();

            if($queryResult){
                return response()->json(['success'=>true,'deleted'=>$queryResult]);
            }else{
                return response()->json(['success'=>false,'deleted'=>0]);
            }
        }

        elseif($target=='student'){
            DB::transaction(function () use ($id){
                DB::table('students')
                ->where('Sid',$id)
                ->delete();

                DB::table('Scourses')
                ->where('Sid',$id)
                ->delete();

                DB::table('Marks')
                ->where('Sid',$id)
                ->delete();
            });
            return response()->json(['success'=>true]);
        }
    }
}

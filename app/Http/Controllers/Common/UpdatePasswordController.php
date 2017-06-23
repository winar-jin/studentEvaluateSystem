<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UpdatePasswordController extends Controller
{
    public function updatePassword(Request $request){
        /*接收前台请求数据*/
        $oldPassword = $request->input('oldPassword');
        $newPassword = $request->input('newPassword');
        $role = $request->input('role');
        $id = (int)$request->input('id');

        /*数据库操作*/
        switch($role){
            case 'admin':
            {
                $isAllowed = DB::table('admin')
                ->where(['Aid'=>$id,'Apassword'=>$oldPassword])
                ->first();
                if($isAllowed){
                    if($oldPassword==$newPassword){
                        return response()->json(['success'=>true]);
                    }
                    $result = DB::table('admin')
                    ->where('Aid',$id)
                    ->update(['Apassword'=>$newPassword]);
                    if($result){
                        return response()->json(['success'=>true]);
                    }else{
                        return response()->json(['success'=>false]);
                    }
                }else{
                    return response()->json(['success'=>false,'msg'=>'password wrong']);
                }
            }
            break;
            case 'teacher':
            {
                $isAllowed = DB::table('teachers')
                ->where(['Tid'=>$id,'Tpassword'=>$oldPassword])
                ->first();
                if($isAllowed){
                    if($oldPassword==$newPassword){
                        return response()->json(['success'=>true]);
                    }
                    $result = DB::table('teachers')
                    ->where('Tid',$id)
                    ->update(['Tpassword'=>$newPassword]);
                    if($result){
                        return response()->json(['success'=>true]);
                    }else{
                        return response()->json(['success'=>false]);
                    }
                }else{
                    return response()->json(['success'=>false,'msg'=>'password wrong']);
                }
            }
            break;
            case 'student':
            {
                $isAllowed = DB::table('students')
                ->where(['Sid'=>$id,'Spassword'=>$oldPassword])
                ->first();
                if($isAllowed){
                    if($oldPassword==$newPassword){
                        return response()->json(['success'=>true]);
                    }
                    $result = DB::table('students')
                    ->where('Sid',$id)
                    ->update(['Spassword'=>$newPassword]);
                    if($result){
                        return response()->json(['success'=>true]);
                    }else{
                        return response()->json(['success'=>false]);
                    }
                }else{
                    return response()->json(['success'=>false,'msg'=>'password wrong']);
                }
            }
            break;
        }

    }
}

<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UpdateAvatarController extends Controller
{
    public function updateAvatar(Request $request){
        /*接收前台请求数据*/
        $filePath = $request->input('filePath');
        $role = $request->input('role');
        $id = (int)$request->input('id');

        /*相应数据库操作*/
        switch($role){
            case 'admin':
            {
                $result = DB::table('admin')
                ->where('Aid',$id)
                ->update(['Aphoto'=>$filePath]);
                if($result){
                    return response()->json(['success'=>true]);
                }else{
                    return response()->json(['success'=>false]);
                }
            }
            break;
            case 'teacher':
            {
                $result = DB::table('teachers')
                ->where('Tid',$id)
                ->update(['Tphoto'=>$filePath]);
                if($result){
                    return response()->json(['success'=>true]);
                }else{
                    return response()->json(['success'=>false]);
                }
            }
            break;
            case 'student':
            {
                $result = DB::table('students')
                ->where('Sid',$id)
                ->update(['Sphoto'=>$filePath]);
                if($result){
                    return response()->json(['success'=>true]);
                }else{
                    return response()->json(['success'=>false]);
                }
            }
            break;
        }
        
    }
}

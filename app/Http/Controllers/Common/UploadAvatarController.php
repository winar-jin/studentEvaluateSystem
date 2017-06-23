<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class UploadAvatarController extends Controller
{
    public function uploadAvatar(Request $request){
        /*获取前台请求数据*/
        $role = $request->input('role');
        $id = $request->input('id');

        /*上传文件相应操作*/
        //判断请求中是否包含name=file的上传文件
        if(!$request->hasFile('file')){
            return response()->json(['success'=>false,'msg'=>'nothing uploaded']);
            // exit('上传文件为空！');
        }
        $file = $request->file('file');
        //判断文件上传过程中是否出错
        if(!$file->isValid()){
            return response()->json(['success'=>false,'msg'=>'upload failed']);
            // exit('文件上传出错！');
        }
        $destPath = realpath(public_path('imags')).'\\'.$role;
        if(!file_exists($destPath))
            mkdir($destPath,0755,true);
        
        $extension = $file -> getClientOriginalExtension(); 
        $newName =$id.'.'.$extension;
        if(!$file->move($destPath,$newName)){
            return response()->json(['success'=>false,'msg'=>'file save failed']);
            // exit('保存文件失败！');
        }
        return response()->json(['success'=>true,'avatarPath'=>'imags/'.$role.'/'.$newName]);
    }
}

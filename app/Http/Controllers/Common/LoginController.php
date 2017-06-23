<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
//if excel facade needed,cancel the commentary below
// use Maatwebsite\Excel\Facades\Excel;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $id = (int)$request->input('id');
        $password = $request->input('password');
        $role = $request->input('role');

        switch($role){
            //如果是学生，则查学生表
            case 'student':
            {
                $result=DB::table('Students')->where('Sid',$id)->value('Spassword');
                if($result==null){
                    //something to return
                    $responseData=array(
                            'success'=>false,
                            'message'=>'user not found'
                        );
                    return response()->json($responseData);
                }else{
                    //something to return
                    if($result!=$password){
                        $responseData=array(
                            'success'=>false,
                            'message'=>'incorrect password'
                        );
                        return response()->json($responseData);
                    }else{
                        $responseData=array(
                            'success'=>true,
                            'message'=>'ok'
                        );
                        return response()->json($responseData);
                    }
                }
            }
            break;
            //如果是老师，则查老师表
            case 'teacher':
            {
                $result=DB::table('Teachers')->where('Tid',$id)->value('Tpassword');
                if($result==null){
                    //something to return
                     $responseData=array(
                            'success'=>false,
                            'message'=>'user not found'
                        );
                    return response()->json($responseData);
                }else{
                    //something to return
                    if($result!=$password){
                        $responseData=array(
                            'success'=>false,
                            'message'=>'incorrect password'
                        );
                        return response()->json($responseData);
                    }else{
                        $responseData=array(
                            'success'=>true,
                            'message'=>'ok'
                        );
                        return response()->json($responseData);
                    }
                }
            }
            break;
            //如果是管理员，则查管理员表
            case 'admin':
            {
                $result=DB::table('Admin')->where('Aid',$id)->value('Apassword');
                if($result==null){
                    //something to return
                    $responseData=array(
                            'success'=>false,
                            'message'=>'user not found'
                        );
                    return response()->json($responseData);
                }else{
                    //something to return
                    if($result!=$password){
                        $responseData=array(
                            'success'=>false,
                            'message'=>'incorrect password'
                        );
                        return response()->json($responseData);
                    }else{
                        $responseData=array(
                            'success'=>true,
                            'message'=>'ok'
                        );
                        return response()->json($responseData);
                    }
                }
            }
            break;
        }
        
    }
}

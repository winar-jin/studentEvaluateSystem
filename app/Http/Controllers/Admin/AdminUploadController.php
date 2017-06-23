<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
//if excel facade needed,cancel the commentary below
use Maatwebsite\Excel\Facades\Excel;

class AdminUploadController extends Controller
{
    //
    public function adminupload(Request $request){
        //receive data from frontend
        $target = $request->input('target');
        //判断请求中是否包含name=file的上传文件
        if(!$request->hasFile('file')){
            return response()->json(['success'=>false,'item'=>$target.'nothing uploaded']);
            // exit('上传文件为空！');
        }
        $file = $request->file('file');
        //判断文件上传过程中是否出错
        if(!$file->isValid()){
            return response()->json(['success'=>false,'item'=>'upload failed']);
            // exit('文件上传出错！');
        }

        /*分情况存储文件并访问数据库*/
        /*1、如果上传学生信息*/
        if($target=='student'){
            $destPath = realpath(public_path('uploads/admin'));
            if(!file_exists($destPath))
                mkdir($destPath,0755,true);
            
            $extension = $file -> getClientOriginalExtension(); 
            $newName ='studentInfo'.date('ymdhis').'.'.$extension;
            if(!$file->move($destPath,$newName)){
                return response()->json(['success'=>false,'item'=>0]);
                // exit('保存文件失败！');
            }

            // return response()->json(['item'=>5]);
            /*相应数据库操作*/
            $filePath = 'uploads/admin/'.$newName;
            $item = 0;
            $successInfo = true;
            Excel::load($filePath, function($reader) use(&$item,&$successInfo) {
                $item=0;//插入条目
                $data = $reader->all();
                // $data = $reader->getSheet(0);
                $data = $data->toArray();
                $pwd = md5(123456);
                foreach($data as $eachData){
                    if (is_array($eachData)){
                        //老师
                        // $queryResult=DB::insert("insert into teachers values ($eachData[教师号],
                        // '$eachData[姓名]','$pwd','$eachData[性别]','$eachData[电话]','$eachData[学院]','imags/3.jpg')");                  
                        // 学生
                        $queryResult=DB::insert("insert into students values ($eachData[学号],'$eachData[姓名]','$pwd',
                        '$eachData[性别]','$eachData[学院]','$eachData[班级]','$eachData[年级]','imags/3.jpg')");
                        for($i=1;$i<8;$i++){//新加学生同时建立1-7学期的分数表记录
                            DB::insert("insert into marks(Sid,Sname,Sclass,Mterm) 
                            values ($eachData[学号],'$eachData[姓名]','$eachData[班级]',$i)");
                        }
                        if($queryResult)
                            $item++;
                    }else{
                        $successInfo = false;
                    }
                }
            });
            if($successInfo){
                return response()->json(['success'=>true,'item'=>$item]);
            }else{
                return response()->json(['success'=>false,'item'=>0]);
            }
        }
        
        /*2、如果是上传老师信息*/
        elseif($target=='teacher'){
            $destPath = realpath(public_path('uploads/admin'));
            if(!file_exists($destPath))
                mkdir($destPath,0755,true);
            
            $extension = $file -> getClientOriginalExtension(); 
            $newName = 'teacherInfo'.date('ymdhis').'.'.$extension;
            if(!$file->move($destPath,$newName)){
                return response()->json(['success'=>false,'item'=>0]);
                // exit('保存文件失败！');
            }

            /*相应数据库操作*/
            $filePath = 'uploads/admin/'.$newName;
            $item=0;
            $successInfo=true;
            Excel::load($filePath, function($reader) use(&$item,&$successInfo){
                $item=0;//插入条目
                $data = $reader->all();
                // $data = $reader->getSheet(0);
                $data = $data->toArray();
                $pwd = md5(123456);
                foreach($data as $eachData){
                    if (is_array($eachData)){
                        //老师
                        if(!$eachData['教师号'])
                            break;
                        $queryResult=DB::table('teachers')
                        ->insert(['Tid'=>(int)$eachData['教师号'],'Tname'=>$eachData['姓名'],
                        'Tpassword'=>$pwd,'Tsex'=>$eachData['性别'],'Tphone'=>$eachData['电话'],
                        'Tapartment'=>$eachData['学院'],'Tphoto'=>'imags/3.jpg']);
                        // $queryResult=DB::insert("insert into teachers values ($eachData[教师号],
                        // '$eachData[姓名]','$pwd','$eachData[性别]','$eachData[电话]','$eachData[学院]','imags/3.jpg')");                  
                        if($queryResult)
                            $item++;
                    }else{
                        $successInfo = false;                    }
                }
            });
            if($successInfo){
                return response()->json(['success'=>true,'item'=>$item]);
            }else{
                return response()->json(['success'=>false,'item'=>0]);
            }
        }

        /*3、如果上传公告背景图*/
        elseif($target=='bgphoto'){
            $destPath = realpath(public_path('uploads/broadcast'));
            if(!file_exists($destPath))
                mkdir($destPath,0755,true);
            
            $extension = $file -> getClientOriginalExtension(); 
            $newName = 'bgimage'.date('ymdh').'.'.$extension;
            if(!$file->move($destPath,$newName)){
                return response()->json(['success'=>false,'bgImagePath'=>0]);
            }
            //upload success
            return response()->json(['success'=>true,'bgImagePath'=>'uploads/broadcast/'.$newName]);
            // return response()->json(['item'=>5]);    ,'item'=>'uploads/broadcast/'.$newName
            /*相应数据库操作*/
        }
        
    }
}
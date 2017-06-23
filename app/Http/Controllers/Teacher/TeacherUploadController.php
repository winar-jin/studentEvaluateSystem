<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
//if excel facade needed,cancel the commentary below
use Maatwebsite\Excel\Facades\Excel;

class TeacherUploadController extends Controller
{
    public function teacherUpload(Request $request){
        /*获取前台请求参数*/
        $role = $request->input('role');
        $term = (int)$request->input('term');
        //判断学期并设置后续数据库操作所需减的数
        if($term==1){
            $minus = 1;
        }elseif($term==2){
            $minus = 0;
        }
        //判断请求中是否包含name=file的上传文件
        if(!$request->hasFile('file')){
            return response()->json(['success'=>false,'item'=>"nothing uploaded"]);
        }
        $file = $request->file('file');
        //判断文件上传过程中是否出错
        if(!$file->isValid()){
            return response()->json(['success'=>false,'item'=>"upload error"]);
        }
        $destPath = realpath(public_path('uploads/teacher'));
        if(!file_exists($destPath))
            mkdir($destPath,0755,true);
        
        $extension = $file -> getClientOriginalExtension(); 
        $newName ='studentScore'.$role.date('ymdhis').'.'.$extension;
        if(!$file->move($destPath,$newName)){
            return response()->json(['success'=>false,'item'=>"file save failed"]);
        }
        /*相应数据库操作*/

        /*分情况进行数据库操作*/
        if($role=='teacher'){/*如果是授课老师*/

            $filePath = 'uploads/teacher/'.$newName;
            $item = 0;
            $successInfo = true;
            Excel::load($filePath, function($reader) use(&$item,&$successInfo) {
                $item=0;//更新条目计数
                $data = $reader->all();
                // $data = $reader->getSheet(0);
                $data = $data->toArray();
                foreach($data as $eachData){
                    if (is_array($eachData)){
                        //进行分数转换
                        $rawSore = (int)$eachData['得分'];
                        $soreObjective = 0;
                        switch($rawSore){
                            case $rawSore<40 :
                                $soreObjective = 1;
                                break;
                            case $rawSore>=40 && $rawSore<60 :
                                $soreObjective = 2;
                                break;
                            case $rawSore>=60 && $rawSore<75 :
                                $soreObjective = 3;
                                break;
                            case $rawSore>=75 && $rawSore<90 :
                                $soreObjective = 4;
                                break;
                            case $rawSore>=90 :
                                $soreObjective = 5;
                                break;
                        }
                        DB::transaction(function () use ($eachData,$soreObjective){//数据库事务更新选课表及分数表
                            $ScMarks = DB::table('Scourses')//取出选课表未更新前各分数
                            ->where(['Sid'=>(int)$eachData['学号'],'Cid'=>$eachData['课程代码']])
                            ->select('ScmarkSubjective','Scmark','Scterm')
                            ->first();

                            DB::table('Scourses')//更新选课表
                            ->where(['Sid'=>(int)$eachData['学号'],'Cid'=>$eachData['课程代码']])
                            ->update(['ScmarkObjective'=>$soreObjective,
                            'Scmark'=>($soreObjective + $ScMarks->ScmarkSubjective)/2]);

                            $sore = DB::table('Scourses')//得出更新后本学期所有成绩综合'得分'
                            ->where(['Sid'=>(int)$eachData['学号'],'Scterm'=>$ScMarks->Scterm])
                            ->avg('Scmark');

                            DB::table('Marks')//更新分数表课程'得分'
                            ->where(['Sid'=>(int)$eachData['学号'],'Mterm'=>$ScMarks->Scterm])
                            ->update(['Mcourse'=>(float)$sore]);

                            $result = DB::table('Marks')//从分数表取出所有五个项目'得分'
                            ->where(['Sid'=>(int)$eachData['学号'],'Mterm'=>$ScMarks->Scterm])
                            ->select('Mcourse','Mactivity','Mclassmates','Mpe','MlawPolicy')
                            ->first();

                            DB::table('Marks')//更新分数表综合'得分'
                            ->where(['Sid'=>(int)$eachData['学号'],'Mterm'=>$ScMarks->Scterm])
                            ->update(['Mscore'=>$result->Mcourse*0.5 + $result->Mactivity*0.2 + $result->Mclassmates*0.1 + $result->Mpe*0.1 + $result->MlawPolicy*0.1]);  
                        });
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

        }else{/*如果是其他职能老师*/
            $colUpdate = 'M'.$role;//存放要更新的分数字段名

            $filePath = 'uploads/teacher/'.$newName;
            $item = 0;
            $successInfo = true;
            Excel::load($filePath, function($reader) use(&$item,&$successInfo,$minus,$colUpdate) {
                $item=0;//更新条目计数
                $data = $reader->all();
                // $data = $reader->getSheet(0);
                $data = $data->toArray();
                foreach($data as $eachData){
                    if (is_array($eachData)){
                        //进行分数转换
                        $rawSore = (int)$eachData['得分'];
                        $sore = 0;
                        switch($rawSore){
                            case $rawSore<40 :
                                $sore = 1;
                                break;
                            case $rawSore>=40 && $rawSore<60 :
                                $sore = 2;
                                break;
                            case $rawSore>=60 && $rawSore<75 :
                                $sore = 3;
                                break;
                            case $rawSore>=75 && $rawSore<90 :
                                $sore = 4;
                                break;
                            case $rawSore>=90 :
                                $sore = 5;
                                break;
                        }
                        DB::transaction(function () use ($eachData,$sore,$minus,$colUpdate){//数据库事务更新分数表
                            DB::table('Marks')//更新单项'得分'
                            ->where(['Sid'=>(int)$eachData['学号'],'Mterm'=>(int)$eachData['年级']*2-$minus])
                            ->update([$colUpdate=>$sore]);

                            $result = DB::table('Marks')//取出所有五个项目'得分'
                            ->where(['Sid'=>(int)$eachData['学号'],'Mterm'=>(int)$eachData['年级']*2-$minus])
                            ->select('Mcourse','Mactivity','Mclassmates','Mpe','MlawPolicy')
                            ->first();

                            DB::table('Marks')//更新综合'得分'
                            ->where(['Sid'=>(int)$eachData['学号'],'Mterm'=>(int)$eachData['年级']*2-$minus])
                            ->update(['Mscore'=>$result->Mcourse*0.5 + $result->Mactivity*0.2 + $result->Mclassmates*0.1 + $result->Mpe*0.1 + $result->MlawPolicy*0.1]);  
                        });
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


    }
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class BroadcastController extends Controller
{
    public function broadcast(Request $request){
        /*receive requested data from frontend*/
        $title = $request->input('title');
        $link = $request->input('link');
        $type = (int)$request->input('type');
        $bgImagePath = $request->input('bgImagePath');

        /*insert into DB*/
        // if($bgImagePath=='no'){
        //     $result = DB::insert("insert into broadcasts(Btime,Btitle,Blink,Btype) 
        //         values (now(),'$title','$link',$type)");
        //     // $result = DB::table('broadcasts')
        //     // ->insert(['Btime'=>now(),'Btitle'=>$title,'Bphoto'=>$bgImagePath,
        //     //     'Blink'=>$link,'Btype'=>$type]);

        //     if($result){
        //         return response()->json(['success'=>true]);
        //     }else{
        //         return response()->json(['success'=>false]);
        //     }
        // }else{
            $result = DB::insert("insert into broadcasts(Btime,Btitle,Blink,Bphoto,Btype) 
                values (now(),'$title','$link','$bgImagePath',$type)");
            // $result = DB::table('broadcasts')
            // ->insert(['Btime'=>now(),'Btitle'=>$title,'Bphoto'=>$bgImagePath,
                // 'Blink'=>$link,'Btype'=>$type]);
            if($result){
                return response()->json(['success'=>true]);
            }else{
                return response()->json(['success'=>false]);
            }
        // }
        
    }
}

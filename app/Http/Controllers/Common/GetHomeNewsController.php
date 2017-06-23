<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GetHomeNewsController extends Controller
{
    public function getHomeNews(Request $request){
        $bulletin = DB::table('broadcasts')
            ->where('Btype',1)
            ->select('Btitle','Blink','Bphoto')
            ->orderBy('Btime', 'DESC')
            ->limit(10)
            ->get();

        $campusNews = DB::table('broadcasts')
            ->where('Btype',2)
            ->select('Btitle','Blink')
            ->orderBy('Btime', 'DESC')
            ->limit(10)
            ->get();

        $facultyNews = DB::table('broadcasts')
            ->where('Btype',3)
            ->select('Btitle','Blink')
            ->orderBy('Btime', 'DESC')
            ->limit(10)
            ->get();
        if($bulletin||$campusNews||$facultyNews){
            return response()->json(['success'=>true,'bulletin'=>$bulletin,
                'campusNews'=>$campusNews,'facultyNews'=>$facultyNews]);
        }else{
            return response()->json(['success'=>false,'msg'=>'DB error']);
        }
        
    }
}

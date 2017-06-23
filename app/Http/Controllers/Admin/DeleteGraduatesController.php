<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DeleteGraduatesController extends Controller
{
    public function deleteGraduates(Request $request){
        DB::transaction(function (){
            
            DB::delete('delete marks from students,marks 
                where students.Sid = marks.Sid and students.Sgrade = ?', [4]);
            
            DB::delete('delete scourses from students,scourses 
                where students.Sid = scourses.Sid and students.Sgrade = ?', [4]);

            DB::table('students')
            ->where('Sgrade',4)
            ->delete();
        });
         return response()->json(['success'=>true]);
    }
}

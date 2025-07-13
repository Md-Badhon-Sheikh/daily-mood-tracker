<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthenticationMiddleware;
use App\Http\Middleware\BackendAuthenticationMiddleware;
use App\Models\MoodType;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\DB;
use PDOException;

class MoodTypeController extends Controller implements HasMiddleware
{
      public static function middleware(): array
  {
    return [
      BackendAuthenticationMiddleware::class,
      AdminAuthenticationMiddleware::class
    ];
  }


    public function MoodType(Request $request){

        if($request->isMethod('post')){
            $id = 0;
            $id = $request->id;
            try{
                if($id < 1){
                    MoodType::create([
                        'mood_type' => $request->mood_type,
                        'priority' => $request->priority,
                    ]);
                    return back()->with('success','Added successfully');
                }elseif($id > 0){
                    $mood = MoodType::findOrFail($id);
                    $mood->update([
                        'mood_type' => $request->mood_type,
                        'priority' => $request->priority,
                    ]);
                    return back()->with('success','Updated successfully');
                }
            }catch(PDOException $e){
                return back()->with('error', "Failed Please Try Again");
            }
        }

        $data['mood_type_list'] = DB::table('mood_types')->get();
        $data['active_menu'] = 'mood_type';
        $data['page_title'] = 'Mood Type';
        return view('backend.admin.pages.mood_type', compact('data'));
    }

    public function mood_type_delete($id){
        $server_response = ['status' => 'FAILED', 'message' => 'Not Found'];
        $mood_type = MoodType::findOrFail($id);
        if($mood_type){
            $mood_type->delete();
            $server_response = ['status' => 'SUCCESS', 'message' => 'Deleted Successfully'];
        }
        echo json_encode($server_response);
    }
}

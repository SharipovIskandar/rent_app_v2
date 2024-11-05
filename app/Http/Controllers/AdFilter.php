<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;
class AdFilter extends Controller
{
    public function search(Request $request){
        $branch_id = $request->branch_id;
        $ads = Ad::where("branches_id", $branch_id)->get();
        return response()->json($ads);
    }
}

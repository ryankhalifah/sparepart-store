<?php

namespace App\Http\Controllers\Api;

use App\Models\Sparepart; 
use Illuminate\Routing\Controller;
use App\Http\Resources\SparepartResource; 
 
class SparepartApiController extends Controller 
{ 
    public function index() 
    { 
        $spareparts = Sparepart::where('stok', '>', 0)->get(); 
        // Menggunakan Resource untuk memformat output JSON 
        return SparepartResource::collection($spareparts);  
    } 
     
    // public function show(Sparepart $sparepart) ... 
} 
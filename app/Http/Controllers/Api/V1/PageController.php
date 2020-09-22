<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page = 'site.' . $id;
        $setting = setting($page);

        if($setting == null ){
            return response()->json(['status' => false, 'content' => 'Page not found' ], 404);

        }
        return response()->json(['status' => true, 'content' => $setting ], 200);

    }
}

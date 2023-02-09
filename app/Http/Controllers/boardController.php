<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class boardController extends Controller {

    public function getBoards(Request $request) : JsonResponse {
        $response = [];

        $data = \App\Helpers\Request::getData([
            'page'  => 'int',
            'limit' => 'int',
        ],$request);

        $page   = $data['page']     ?? 1;
        $limit  = $data['limit']    ?? 10;

        $response = \App\Helpers\Wrapper::wrap(\App\Models\board::class,[],$page,$limit);

        return response()->json($response);
    }

    public function postBoards(Request $request) : JsonResponse {
        $response = [];

        $data = \App\Helpers\Request::getData([
            'name'          => 'string',
            'details'       => 'string'
        ],$request);

        $response = \App\Helpers\Wrapper::modelCreate(\App\Models\board::class,$data,[
            'name'      => 'required|string',
            'details'   => 'string',
        ]);

        return response()->json($response);
    }

    public function getBoard($id) : JsonResponse {
        $response = [];

        $response = \App\Helpers\Wrapper::modelGet(\App\Models\board::class,$id);

        return response()->json($response);
    }

    public function putBoard(Request $request,$id) : JsonResponse {
        $response = [];

        $data = \App\Helpers\Request::getData([
            'name'          => 'string',
            'details'       => 'string'
        ],$request);

        $response = \App\Helpers\Wrapper::modelUpdate(\App\Models\board::class,$id,$data,[
            'name' => 'string',
            'details' => 'string',
        ]);

        return response()->json($response);
    }

    public function deleteBoard($id) : JsonResponse {
        $response = [];

        $response = \App\Helpers\Wrapper::modelDelete(\App\Models\board::class,$id);

        return response()->json($response);
    }


}

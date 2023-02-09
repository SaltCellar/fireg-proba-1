<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class extinguisherController extends Controller {

    public function getExtinguisherTypes(Request $request) : JsonResponse {
        $response = [];

        $data = \App\Helpers\Request::getData([
            'page'  => 'int',
            'limit' => 'int',
        ],$request);

        $page   = $data['page']     ?? 1;
        $limit  = $data['limit']    ?? 10;

        $response = \App\Helpers\Wrapper::wrap(\App\Models\extinguisher_type::class,[],$page,$limit);

        return response()->json($response);
    }

    public function postExtinguisherTypes(Request $request) : JsonResponse {
        $response = [];

        $data = \App\Helpers\Request::getData([
            'name'      => 'string',
            'details'   => 'string',
        ],$request);
        $response = \App\Helpers\Wrapper::modelCreate(\App\Models\extinguisher_type::class,$data,[
            'name'      => 'required|string',
            'details'   => 'string',
        ]);

        return response()->json($response);
    }

    public function putExtinguisherType(Request $request,$id) : JsonResponse {
        $response = [];

        $data = \App\Helpers\Request::getData([
            'name'      => 'string',
            'details'   => 'string',
        ],$request);
        $response = \App\Helpers\Wrapper::modelUpdate(\App\Models\extinguisher_type::class,$id,$data,[
            'name' => 'string',
            'details' => 'string',
        ]);

        return response()->json($response);
    }

    public function deleteExtinguisherType($id) : JsonResponse {
        $response = [];

        $response = \App\Helpers\Wrapper::modelUpdate(\App\Models\extinguisher_type::class,$id);

        return response()->json($response);
    }

}

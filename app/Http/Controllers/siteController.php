<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class siteController extends Controller {

    public function getSites(Request $request) : JsonResponse {
        $response = [];

        $data = \App\Helpers\Request::getData([
            'page'  => 'int',
            'limit' => 'int',
        ],$request);

        $page   = $data['page']     ?? 1;
        $limit  = $data['limit']    ?? 10;

        $response = \App\Helpers\Wrapper::wrap(\App\Models\site::class,[],$page,$limit);

        return response()->json($response);
    }

    public function postSites(Request $request) : JsonResponse {
        $response = [];

        $data = \App\Helpers\Request::getData([
            'name'      => 'string',
            'details'   => 'string',
        ],$request);
        $response = \App\Helpers\Wrapper::modelCreate(\App\Models\site::class,$data,[
            'name'      => 'required|string',
            'details'   => 'string',
        ]);

        return response()->json($response);
    }

    public function putSite(Request $request, $id) : JsonResponse {
        $response = [];

        $data = \App\Helpers\Request::getData([
            'name'      => 'string',
            'details'   => 'string',
        ],$request);
        $response = \App\Helpers\Wrapper::modelUpdate(\App\Models\site::class,$id,$data,[
            'name' => 'string',
            'details' => 'string',
        ]);

        return response()->json($response);
    }

    public function deleteSite($id) : JsonResponse {
        $response = [];

        $response = \App\Helpers\Wrapper::modelUpdate(\App\Models\site::class,$id);

        return response()->json($response);
    }

}

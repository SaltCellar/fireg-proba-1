<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class postController extends Controller {

    public function getPosts(Request $request) : JsonResponse {
        $response = [];

        $data = \App\Helpers\Request::getData([
            'page'  => 'int',
            'limit' => 'int',
            'board' => 'int',
        ],$request);

        $page   = $data['page']     ?? 1;
        $limit  = $data['limit']    ?? 10;
        $board  = $data['board']    ?? null;

        if ($board) {
            $constraintValidation = \App\Helpers\Wrapper::constraintValidation([
                'board' => [ 'class' => \App\Models\board::class, 'id' => $board ],
            ]);
            if ($constraintValidation) return response()->json($constraintValidation);
        }

        $filter = [];

        if (!is_null($board) && $board > 0) {
            $filter [] = [ 'eq', 'board', $board ];
        }

        $response = \App\Helpers\Wrapper::wrap(\App\Models\board_post::class,$filter,$page,$limit);

        return response()->json($response);
    }

    public function postPosts(Request $request) : JsonResponse {
        $response = [];

        $data = \App\Helpers\Request::getData([
            'board'             => 'int',
            'extinguisher_type' => 'int',
            'site'              => 'int',
            'name'              => 'string',
            'innerid'           => 'string',
            'fa_no'             => 'string',
            'fa_date'           => 'string', // Date
            'comment'           => 'string',

            'mult'              => 'int',
        ],$request);

        // Constrain Validation (REQUIRED CASE)
        $constraintValidation = \App\Helpers\Wrapper::constraintValidation([
            'board'                 => [ 'class' => \App\Models\board::class,               'id' => $data['board']              ?? 0, ],
            'extinguisher_type'     => [ 'class' => \App\Models\extinguisher_type::class,   'id' => $data['extinguisher_type']  ?? 0, ],
            'site'                  => [ 'class' => \App\Models\site::class,                'id' => $data['site']               ?? 0, ],
        ]);
        if ($constraintValidation) { response()->json($constraintValidation); }

        $mult = $data['mult'] ?? 0;

        $response = \App\Helpers\Wrapper::modelCreate(\App\Models\board_post::class,$data,[
            'board'             => 'required',
            'extinguisher_type' => 'required',
            'site'              => 'required',
            'name'              => 'required',
            'innerid'           => 'required',
            'fa_no'             => 'required',
            'fa_date'           => 'required|date_format:Y.m.d',
            'comment'           => '',
        ],$mult);

        return response()->json($response);
    }

    public function getPost(Request $request,$id) : JsonResponse {
        $response = [];

        $response = \App\Helpers\Wrapper::modelGet(\App\Models\board_post::class,$id);

        return response()->json($response);
    }

    public function putPost(Request $request,$id) : JsonResponse {
        $response = [];

        $data = \App\Helpers\Request::getData([
            'board'             => 'int',
            'extinguisher_type' => 'int',
            'site'              => 'int',
            'name'              => 'string',
            'innerid'           => 'string',
            'fa_no'             => 'string',
            'fa_date'           => 'string', // Date
            'comment'           => 'string',
        ],$request);

        // Constrain Validation (OPTIONAL CASE)
        $constraintValidationRequired = [
            'board'                     => \App\Models\board::class,
            'extinguisher_type'         => \App\Models\extinguisher_type::class,
            'site'                      => \App\Models\site::class,
        ];
        $constraintValidationList = [];
        foreach ($constraintValidationRequired as $param => $class) {
            if (isset($data[$param])) { $constraintValidationList [ $param ] = [ 'class' => $class, 'id' => $data[$param] ]; }
        }
        if ($constraintValidationList) {
            $constraintValidation = \App\Helpers\Wrapper::constraintValidation($constraintValidationList);
            if ($constraintValidation) { return response()->json($constraintValidation); }
        }

        $response = \App\Helpers\Wrapper::modelUpdate(\App\Models\board_post::class,$id,$data,[
            'board'             => '',
            'extinguisher_type' => '',
            'site'              => '',
            'name'              => '',
            'innerid'           => '',
            'fa_no'             => '',
            'fa_date'           => 'date_format:Y.m.d',
            'comment'           => '',
        ]);

        return response()->json($response);
    }

    public function deletePost(Request $request,$id) : JsonResponse {
        $response = [];

        $response = \App\Helpers\Wrapper::modelDelete(\App\Models\board_post::class,$id);

        return response()->json($response);
    }

}

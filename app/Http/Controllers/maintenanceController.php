<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class maintenanceController extends Controller {

    public function getMaintenances(Request $request) : JsonResponse {
        $response = [];

        $data = \App\Helpers\Request::getData([
            'page'  => 'int',
            'limit' => 'int',

            'post'  => 'int',
            'type'  => 'int',
        ],$request);

        $page   = $data['page']     ?? 1;
        $limit  = $data['limit']    ?? 10;

        $post   = $data['post']     ?? null;
        $type   = $data['type']     ?? null;

        $filter = [];

        if (!is_null($post) && $post > 0) {
            $filter [] = [ 'eq', 'parent', $post ];
        }
        if (!is_null($type) && $type > 0) {
            $filter [] = [ 'eq', 'type', $type ];
        }

        $response = \App\Helpers\Wrapper::wrap(\App\Models\maintenance::class,$filter,$page,$limit);

        return response()->json($response);
    }

    public function postMaintenances(Request $request) : JsonResponse {
        $response = [];

        $data = \App\Helpers\Request::getData([
            'parent'            => 'int',
            'type'              => 'int',
            'date'              => 'string', // date
            'comment'           => 'string',
        ],$request);

        // Constrain Validation (REQUIRED CASE)
        $constraintValidation = \App\Helpers\Wrapper::constraintValidation([
            'parent'        => [ 'class' => \App\Models\board_post::class,          'id' => $data['parent'] ?? 0, ],
            'type'          => [ 'class' => \App\Models\maintenance_type::class,    'id' => $data['type']   ?? 0, ],
        ]);
        if ($constraintValidation) { response()->json($constraintValidation); }


        $response = \App\Helpers\Wrapper::modelCreate(\App\Models\maintenance::class,$data,[
            'parent'            => 'required',
            'type'              => 'required',
            'date'              => 'required|date_format:Y.m.d', // date
            'comment'           => '',
        ]);

        return response()->json($response);
    }

    public function getMaintenance($id) : JsonResponse {
        $response = [];

        $response = \App\Helpers\Wrapper::modelGet(\App\Models\maintenance::class,$id);

        return response()->json($response);
    }

    public function putMaintenance(Request $request, $id) : JsonResponse {
        $response = [];

        $data = \App\Helpers\Request::getData([
            'type'              => 'int',
            'date'              => 'string', // date
            'comment'           => 'string',
        ],$request);

        // Constrain Validation (OPTIONAL CASE)
        $constraintValidationRequired = [
            'type'      => \App\Models\maintenance_type::class
        ];
        $constraintValidationList = [];
        foreach ($constraintValidationRequired as $param => $class) {
            if (isset($data[$param])) { $constraintValidationList [ $param ] = [ 'class' => $class, 'id' => $data[$param] ]; }
        }
        if ($constraintValidationList) {
            $constraintValidation = \App\Helpers\Wrapper::constraintValidation($constraintValidationList);
            if ($constraintValidation) { return response()->json($constraintValidation); }
        }

        $response = \App\Helpers\Wrapper::modelUpdate(\App\Models\maintenance::class,$id,$data,[
            'type'              => '',
            'date'              => 'date_format:Y.m.d',
            'comment'           => '',
        ]);

        return response()->json($response);
    }

    public function deleteMaintenance($id) : JsonResponse {
        $response = [];

        $response = \App\Helpers\Wrapper::modelUpdate(\App\Models\maintenance::class,$id);

        return response()->json($response);
    }

    /* -------------------------------------------------------------------------------------------------------------- */
    /* Type */
    /* -------------------------------------------------------------------------------------------------------------- */

    public function getMaintenanceTypes(Request $request) : JsonResponse {
        $response = [];

        $page = \App\Helpers\Request::getData(['page' => 'int'],$request)['page'] ?? 1;
        $response = \App\Helpers\Wrapper::wrap(\App\Models\maintenance_type::class,[],$page);

        return response()->json($response);
    }

    public function postMaintenanceTypes(Request $request) : JsonResponse {
        $response = [];

        $data = \App\Helpers\Request::getData([
            'name'      => 'string',
            'details'   => 'string',
        ],$request);
        $response = \App\Helpers\Wrapper::modelCreate(\App\Models\maintenance_type::class,$data,[
            'name'      => 'required|string',
            'details'   => 'string',
        ]);

        return response()->json($response);
    }

    public function putMaintenanceType(Request $request,$id) : JsonResponse {
        $response = [];

        $data = \App\Helpers\Request::getData([
            'name'      => 'string',
            'details'   => 'string',
        ],$request);
        $response = \App\Helpers\Wrapper::modelUpdate(\App\Models\maintenance_type::class,$id,$data,[
            'name' => 'string',
            'details' => 'string',
        ]);

        return response()->json($response);
    }

    public function deleteMaintenanceType($id) : JsonResponse {
        $response = [];

        $response = \App\Helpers\Wrapper::modelUpdate(\App\Models\maintenance_type::class,$id);

        return response()->json($response);
    }

}

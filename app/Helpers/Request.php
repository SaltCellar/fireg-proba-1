<?php
namespace App\Helpers;
class Request {

    public static function getData(string|array $data,\Illuminate\Http\Request $request) : array {

        $CONTENT    = json_decode($request->getContent(),true) ? : [];
        $QUERY      = [];

        $isGet      = $request->getMethod() === 'GET';
        if ($isGet) { $QUERY = $request->query(); }

        $result = [];
        foreach ($data as $param => $type) {
            if (isset($CONTENT[$param])) {
                $result [$param] = self::dataCast($type,$CONTENT[$param]);
            } else if ($isGet && isset($QUERY[$param])) {
                $result [$param] = self::dataCast($type,$QUERY[$param]);
            }
        }

        return $result;
    }

    public static function dataCast(string $type,mixed $data) : mixed {
        switch ($type) {
            case 'int'      : { return is_numeric($data) ? intval($data)    : null; }
            case 'float'    : { return is_numeric($data) ? floatval($data)  : null; }
            case 'double'   : { return is_numeric($data) ? doubleval($data) : null; }
            case 'string'   : { return strval($data); }
            case 'bool'     : { return boolval($data); }
        }
        return null;
    }

}

<?php
namespace App\Helpers;

class Wrapper {

    public static function wrap(string $modelClass,array $filter = [], int $page = 0, int $perPage = 10) : array {
        $query = $modelClass::query();
        $query = \App\Components\FilterManager::apply($query,$filter);

        $maxResultCount = $query->count();
        if ($maxResultCount === 0) {
            return [
                'error'     => false,
                'total'     => 0,
                'page'      => 1,
                // 'pag'       => [ 0 => 1, ],
                'next'      => false,
                'results'   => [],
            ];
        }

        $availablePages = floor($maxResultCount / $perPage);
        $page = ( $page < 1 ? 1 : $page ) - 1;

        $nextPageAllowed = $page < $availablePages;

        return [
            'error'     => false,
            'total'     => $maxResultCount,
            'page'      => $page+1,
            // 'pag'       => [],
            'next'      => $nextPageAllowed,
            'results'   => self::formatArray($query->skip($perPage*$page)->limit($perPage)->getModels() ? : []),
        ];
    }

    private static function formatArray(array $models) : array {
        $result = [];
        foreach ($models as $model) {
            $result [] = $model->toArray();
        }
        return $result;
    }

    private static function generatePaginator(int $current,int $max,int $range = 2) : array {
        // TODO: Paginator
        return [];
    }


    public static function modelCreate(string $modelClass,array $data = [],array $validator = [], int $multiplier = 1) : array {
        if ($multiplier < 1) $multiplier = 1;

        $validation = $validator ? \Illuminate\Support\Facades\Validator::make($data,$validator)->errors()->toArray() : [];

        if ($validation) {
            return [ 'error' => [ 'params' => $validation ] ];
        }

        $created = [];
        foreach (range(0,$multiplier-1) as $_) {
            $model = new $modelClass;
            $model->timestamps = false;
            foreach (array_keys($validator ? : $data) ? : [] as $key) {
                if (isset($data[$key])) {
                    if ($validator && str_contains($validator[$key],'date')) {
                        $model->$key = str_replace('.','-',$data[$key]) . " " . "00:00:00";
                    } else {
                        $model->$key = $data[$key];
                    }
                }
            }
            if ($model->save()) {
                $created [] = $model->toArray();
            }
        }
        if (!$created) {
            return [ 'error' => [ 'model' => 'Failed to save to the database!' ] ];
        } else {
            return [ 'error' => false, 'created' => $created ];
        }




    }

    public static function modelGet(string $modelClass,int $id) : array {

        $model = $modelClass::query()->find($id) ? : null;
        if (!$model) {
            return [
                'error' => [ 'model' => 'Model not found on id!', ]
            ];
        } else {
            return [
                'error' => false,
                'result' => $model->toArray(),
            ];
        }
    }

    public static function modelUpdate(string $modelClass,int $id,array $data = [],array $validator = []) : array {
        $model = $modelClass::query()->find($id) ? : null;

        if (!$model) {
            return [
                'error' => [ 'model' => 'Model not found on id!', ]
            ];
        } else {

            $validation = $validator ? \Illuminate\Support\Facades\Validator::make($data,$validator)->errors()->toArray() : [];

            if ($validation) {
                return [ 'error' => [ 'params' => $validation ] ];
            }

            $model->timestamps = false;

            foreach (array_keys($validator ? : $data) ? : [] as $key) {
                if (isset($data[$key])) {
                    if ($validator && str_contains($validator[$key],'date')) {
                        $model->$key = str_replace('.','-',$data[$key]) . " " . "00:00:00";
                    } else {
                        $model->$key = $data[$key];
                    }
                }
            }

            if (!$model->save()) {
                return [ 'error' => [ 'model' => 'Failed to save to the database!' ] ];
            } else {
                return [ 'error' => false, 'updated' => $model->toArray() ];
            }

        }
    }

    public static function modelDelete(string $modelClass,int $id) : array {
        $model = $modelClass::query()->find($id) ? : null;
        if (!$model) {
            return [
                'error' => [ 'model' => 'Model not found on id!', ]
            ];
        } else {
            $modelEcho = $model->toArray();
            $model->delete();
            return [
                'error'     => false,
                'deleted'   => true,
                'result'    => $modelEcho,
            ];
        }
    }


    public static function constraintValidation(array $validation) : ? array {
        foreach ($validation as $param => $data) {
            $class  = $data['class']    ?? null;
            $id     = $data['id']       ?? null;
            if (is_null($class) || is_null($id)) continue;
            if (!$class::query()->find($id)) {
                return [ 'error' => ['params' => [ $param => 'Model not found on ['.$id.'] id!' ] ] ];
            }
        }
        return null;
    }

    public static function modelArrayExtends(array $extendRule,array $modelArray) : array {
        foreach ($extendRule as $attrName => $data) {
            if (isset($modelArray[$attrName]) && is_int($modelArray[$attrName])) {
                $extendedModel = $data['class']::query()->find($modelArray[$attrName]);
                $extendedModel = $extendedModel->toArray();
                $extendedData = [];
                foreach ($data['extend'] as $extendedProperty) {
                    $extendedData [ $extendedProperty ] = $extendedModel[$extendedProperty] ?? null;
                }
                $modelArray[$attrName] = $extendedData;
            }
        }
        return $modelArray;
    }

}

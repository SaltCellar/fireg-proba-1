<?php
namespace App\Components;
use Illuminate\Database\Eloquent\Builder;
class FilterManager {

    /*

        [
            'eq' => [ '', '', ]
            'gt' => [ '', '', ]
            'or' => [ 'eq' => [ '', '', ] ],
            'or' => [ 'gt' => [ '', '', ] ],
            'or' => [
                    'eq' => [ '', '', ]
                    'eq' => [ '', '', ]
            ],
        ];

        [
            [ 'eq' => [ '', '', ] ]
            [ 'gt' => [ '', '', ] ]
            [ 'or' => [ 'eq' => [ '', '', ] ], ]
            [ 'or' => [ 'gt' => [ '', '', ] ], ]
            [ 'or' => [
                    'eq' => [ '', '', ]
                    'eq' => [ '', '', ]
            ], ],
        ];

        [
            [ 'eq', '', '' ],
            [ 'gt', '', '' ],
            [ 'or', [
                [ 'eq', '', '' ],
                [ 'gt', '', '' ],
            ] ],
        ]

    */

    private static ? self $instance = null;
    public static function apply(Builder $query, array $filter = []) : Builder {
        if (is_null(self::$instance)) self::$instance = new self();
        return self::$instance->applyOnInstance($query,$filter);
    }

    private function applyOnInstance(Builder $query, array $filter = []) : Builder {
        return $this->instructions($filter,$query);
    }

    private function instructions(array $filter,Builder $query) : Builder {
        foreach ($filter as $body) {
            $instruction = $body [0];
            array_shift($body);

            $instruction = $this->instructionFormatter($instruction);
            if ($instruction === null) continue;
            if ($instruction === 'OR') {
                $query = $query->orWhere( fn($_query) => $this->instructions($body[0],$_query) );
            } else {
                $query = $query->where($body[0],$instruction,$body[1]);
            }
        }
        return $query;
    }

    private function instructionFormatter(string $instruction) : ? string {
        $instruction = strtolower($instruction);
        return match ($instruction) {
            'or',   '||'            => 'OR',
            'eq',   '=',    '==',   => '=',
            'gt',   '>'             => '>',
            'lt',   '<'             => '<',
            'gte',  '<='            => '<=',
            'lte',  '>='            => '>=',
            'ne',   '!=',   '<>',   => '<>',
            default => null,
        };
    }

}

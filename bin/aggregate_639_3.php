<?php
declare(strict_types=1);

/**
 * @var Closure $getIso639_1
 * @var Closure $fileIso639_1_Old
 * @var Closure $getIso639_2_Group
 * @var Closure $getIso639_3
 * @var Closure $getIso639_3_2
 * @var Closure $getIso639_3_Macrolanguages
 * @var Closure $getIso639_3_Name
 * @var Closure $getIso639_3_Name_Index
 * @var Closure $getIso639_3_Retirements
 * @var Closure $fileIso639_5
 * @var Closure $fileIso639_6
 */
include __DIR__ . DIRECTORY_SEPARATOR . "_.php";

//

$iso639_3_Macrolanguages_Map = function () use (
    $getIso639_3,
    $getIso639_3_Macrolanguages,
    $getIso639_3_2,
): array {
    $data = [];

    foreach ($getIso639_3() as $v) {
        $data[$v['#639-3']]
                [$v['#639-3-macrolanguage']] = null;
    }

    foreach ($getIso639_3_Macrolanguages() as $v) {
        $data[$v['#639-3']]
            [$v['#639-3-macrolanguage']] = null;
    }

    //

    foreach ($data as &$v) {
        $v = array_keys($v);
    }

    return $data;
};

$iso639_3_Macrolanguages = function () use (
    $getIso639_3, $getIso639_3_Macrolanguages,
    $getIso639_3_Name_Index,
): array {
    $data = [];

    foreach ($getIso639_3_Macrolanguages() as $v) {
        $field = '#639-3-macrolanguage';

        $data[$v[$field]] = $v;
    }

    foreach ($getIso639_3() as $v) {
        $field = '#639-3-macrolanguage';

        $data[$v[$field]] =
            arr_merge(
                ($data[$v[$field]] ?? []),
                $v,
                [
                    '#639-3',
                ]
            );
    }

    $data = arrs_map_keys($data, [
        '#639-3' => 'iso_639_3_code',
        '#639-3-macrolanguage' => 'macrolanguage_code',
        '#Status' => 'macrolanguage_status',
        '#Name3-macrolanguage' => 'macrolanguage_name',
        '#639-3-alias' => 'macrolanguage_alias',
    ]);

    return $data;
};

$iso639_3_Default = function() use (
    $iso639_3_Macrolanguages,

    $getIso639_3_Name, $getIso639_3_2,
    $getIso639_3_Name_Index, $getIso639_3_Retirements,
) {
    $data = [];

    foreach ($iso639_3_Macrolanguages() as $v) {
        $field = 'iso_639_3_code';
        if (!$v[$field]) {
            continue;
        }

        $data[$v[$field]] = [
            '#639-3' => $v[$field],
        ];
    }

    foreach ($getIso639_3_Name() as $v) {
        $field = '#639-3';
        if (!isset($data[$v[$field]])) {
            continue;
        }

        $data[$v[$field]] = $v;
    }

    foreach ($getIso639_3_2() as $v) {
        $field = '#639-3';
        if (!isset($data[$v[$field]])) {
            continue;
        }

        $data[$v[$field]] = arr_merge(
            $data[$v[$field]],
            $v, [
                '#639-3',
                '#Name3',
            ]
        );
    }

    foreach ($getIso639_3_Name_Index() as $v) {
        $field = '#639-3';
        if (!isset($data[$v[$field]])) {
            continue;
        }

        $data[$v[$field]] = arr_merge(
            $data[$v[$field]],
            $v, [
                '#639-3',
                '#Name3',
            ]
        );
    }

    foreach ($getIso639_3_Retirements() as $v) {
        $field = '#639-3-old';
        if (!isset($data[$v[$field]])) {
            continue;
        }

        $data[$v[$field]] = arr_merge(
            $data[$v[$field]],
            [
                ...$v,
                ...[
                    '#639-3-merge' => $v['#639-3'],
                    '#639-3' => $v[$field],
                ]
            ], [
                '#639-3',
                '#Name3',
            ]
        );
    }

    $data = arrs_map_keys($data, [
        '#639-3' => 'iso_639_3_code',
        '#Name3' => 'iso_639_3_name',

        '#639-2-b'  => 'iso_639_2_b_code',
        '#639-2-t'  => 'iso_639_2_t_code',
        '#639-1'    => 'iso_639_1_code',

        '#Scope' => 'iso_639_3_scope',
        '#Language_Type' => 'iso_639_3_type',
        '#Notes' => 'iso_639_3_notes',
        '#Name3-inverted' => 'iso_639_3_name_inverted',

        '#639-3-merge'  => 'iso_639_3_merge',
        '#Ret_Reason'   => 'iso_639_3_merge_reason',
        '#Date'         => 'iso_639_3_merge_date',
    ]);

    return $data;
};

$iso639_3 = function() use (
    $getIso639_3_Name, $getIso639_3_2,
    $getIso639_3_Name_Index, $getIso639_3_Retirements,
) {
    $data = [];

    foreach ($getIso639_3_Name() as $v) {
        $field = '#639-3';
        $data[$v[$field]] = $v;
    }

    foreach ($getIso639_3_2() as $v) {
        $field = '#639-3';
        $data[$v[$field]] = arr_merge(
            $data[$v[$field]] ?? [],
            $v, [
                '#639-3',
                '#Name3',
            ]
        );
    }

    foreach ($getIso639_3_Name_Index() as $v) {
        $field = '#639-3';
        $data[$v[$field]] = arr_merge(
            $data[$v[$field]] ?? [],
            $v, [
                '#639-3',
                '#Name3',
            ]
        );
    }

    foreach ($getIso639_3_Retirements() as $v) {
        $field = '#639-3-old';
        $data[$v[$field]] = arr_merge(
            $data[$v[$field]] ?? [],
            [
                ...$v,
                ...[
                    '#639-3-merge' => $v['#639-3'],
                    '#639-3' => $v[$field],
                ]
            ], [
                '#639-3',
                '#Name3',
            ]
        );
    }

    $data = arrs_map_keys($data, [
        '#639-3' => 'iso_639_3_code',
        '#Name3' => 'iso_639_3_name',

        '#639-2-b'  => 'iso_639_2_b_code',
        '#639-2-t'  => 'iso_639_2_t_code',
        '#639-1'    => 'iso_639_1_code',

        '#Scope' => 'iso_639_3_scope',
        '#Language_Type' => 'iso_639_3_type',
        '#Notes' => 'iso_639_3_notes',
        '#Name3-inverted' => 'iso_639_3_name_inverted',

        '#639-3-merge'  => 'iso_639_3_merge',
        '#Ret_Reason'   => 'iso_639_3_merge_reason',
        '#Date'         => 'iso_639_3_merge_date',
    ]);

    return $data;
};

//

make_dump(
    "iso639_3_default",
    $iso639_3_Default()
);

make_dump(
    "iso639_3",
    $iso639_3()
);

make_dump(
    "iso639_3_macrolanguages",
    $iso639_3_Macrolanguages()
);

make_dump(
    "iso639_3_macrolanguages_map",
    $iso639_3_Macrolanguages_Map()
);

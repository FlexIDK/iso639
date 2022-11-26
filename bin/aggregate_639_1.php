<?php
declare(strict_types=1);

/**
 * @var Closure $getIso639_1
 * @var Closure $getIso639_1_Old
 * @var Closure $getIso639_2_Group
 * @var Closure $getIso639_3
 * @var Closure $getIso639_3_2
 * @var Closure $getIso639_3_Macrolanguages
 * @var Closure $getIso639_3_Name
 * @var Closure $getIso639_3_Name_Index
 * @var Closure $getIso639_3_Retirements
 * @var Closure $getIso639_5
 * @var Closure $getIso639_6
 */
include __DIR__ . DIRECTORY_SEPARATOR . "_.php";

//

$iso639_1 = function () use (
    $getIso639_1,
    $getIso639_1_Old,
): array {
    $data = [];

    foreach ($getIso639_1() as $v) {
        $field = '#639-1';

        $data[$v[$field]] = [
            ...[],
            ...arr_except($v, [
                '#macrolanguage',
                '#ancient',
            ]),
            ...[
                'macrolanguage' => !!$v['#macrolanguage'],
                'ancient'       => !!$v['#ancient'],
            ]
        ];
    }

    foreach ($getIso639_1_Old() as $v) {
        $field = '#639-1';

        $data[$v[$field]] = arr_merge(
            $data[$v[$field]] ?? [],
            $v,
            [
                '#Notes',

                '#639-1',
                '#Name1',
                '#Name1-native',

                '#639-2-t',
                '#639-2-b',

                '#639-3',

                '#639-5',
                '#Name5',

                '#639-6',
            ]
        );
    }

    $data = arrs_map_keys($data, [
        '#639-1' => 'iso_639_1_code',
        '#Name1' => 'iso_639_1_name',
        '#Name1-native' => 'iso_639_1_native',
        '#Notes' => 'iso_639_1_notes',

//        '#639-2' => 'iso_639_2_code',
        '#639-2-t' => 'iso_639_2_t_code',
        '#639-2-b' => 'iso_639_2_b_code',
        '#639-3' => 'iso_639_3_code',

        '#639-5' => 'iso_639_5_code',
        '#Name5' => 'iso_639_5_name',

        '#639-6' => 'iso_639_6_code',
    ]);

    return $data;
};

//

make_dump(
    "iso639_1",
    $iso639_1()
);


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

$iso639_5 = function () use (
    $getIso639_5,
): array {
    $data = [];

    foreach ($getIso639_5() as $v) {
        $field = '#639-5';

        $hierarchy = explode(":", (string)$v['#639-5-hierarchy']);
        array_pop($hierarchy);

        $row = [
            ...[],
            ...arr_except($v, [
                '#639-5-hierarchy',
            ]),
            ...[
                'hierarchy' => $hierarchy,
                'parent'    => end($hierarchy) ?: null,
            ]
        ];

        $data[$v[$field]] = arr_only_default(
            $row,
            [
                '#639-5', '#Name5', '#Notes',
                '#639-2-t', '#639-2-b',
                'hierarchy', 'parent',
            ]
        );
    }

    $data = arrs_map_keys($data, [
        '#639-5' => 'iso_639_5_code',
        '#Name5' => 'iso_639_5_name',
        '#Notes' => 'iso_639_5_notes',

        '#639-2-t' => 'iso_639_2_t_code',
        '#639-2-b' => 'iso_639_2_b_code',
    ]);

    return $data;
};

//

make_dump(
    "iso639_5",
    $iso639_5()
);


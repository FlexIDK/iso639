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

$iso639_6 = function () use (
    $getIso639_6,
): array {
    $data = [];

    foreach ($getIso639_6() as $v) {
        $field = '#639-6';

        $row = [
            ...[],
            ...$v,
        ];

        $data[$v[$field]] = arr_only_default(
            $row,
            [
                '#639-6', '#639-3', '#Name6',
            ]
        );
    }

    $data = arrs_map_keys($data, [
        '#639-6' => 'iso_639_6_code',
        '#Name6' => 'iso_639_6_name',

        '#639-3' => 'iso_639_3_code',
    ]);

    return $data;
};

//

make_dump(
    "iso639_6",
    $iso639_6()
);


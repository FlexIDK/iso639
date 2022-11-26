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

$getIso639_2_Group = function () use (
    $getIso639_2_Group,
): array {
    $data = [];

    foreach ($getIso639_2_Group() as $v) {
        $data[$v['#639-2']] = $v['#Name2'];
    }

    return $data;
};

//

make_dump(
    "iso639_2_group",
    $getIso639_2_Group()
);

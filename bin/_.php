<?php
declare(strict_types=1);

$fileIso639_1 = "iso-639-1.csv";
$fileIso639_2_Group = "iso-639-2-group.csv";
$fileIso639_3 = "iso-639-3.csv";
$fileIso639_3_Macrolanguages = "iso-639-3-macrolanguages_20220311.csv";
$fileIso639_3_Name = "iso-639-3-name.csv";
$fileIso639_3_2 = "iso-639-3_20220311.csv";
$fileIso639_3_Name_Index = "iso-639-3_name_index_20220311.csv";
$fileIso639_3_Retirements = "iso-639-3_retirements_20220311.csv";
$fileIso639_5 = "iso-639-5.csv";
$fileIso639_6 = "iso-639-6.csv";
$fileIso639_1_Old = "iso-639-old.csv";

function getCsv(
    string $file_name,
    string $separator = "\t",
    ?bool $listArray = false
) {
    $file_path = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . "resources/{$file_name}";

    if (!is_file($file_path)) {
        throw new \Exception("File '{$file_name}' not exit in resource");
    }

    $res = fopen($file_path, 'r');
    $i = 0;

    $data = [];
    $cols = null;
    $cntCols = 0;

    while ($line = fgetcsv($res, null, $separator, "\"", "\\")) {
        if (count($line) === 1 && $line[0] === null) {
            continue;
        }

        if ($i === 0 && str_starts_with($line[0], '#')) {
            $cols       = $line;
            $cntCols    = count($cols);
            continue;
        }

        if (is_null($cols) || $listArray === true) {
            $data[] = $line;
        }
        else {
            $cnt = count($line);

            $data[] = [
                ...(is_null($listArray) || $listArray === true
                    ? $line
                    : []
                ),
                ...array_combine(
                    $cols,
                    [
                        ...array_slice($line, 0, $cntCols),
                        ...($cnt < $cntCols
                            ? array_fill(
                                $cnt,
                                $cntCols - $cnt,
                                null
                            )
                            : []
                        )
                    ]
                ),
            ];
        }

        $i++;
    }

    return $data;
}

if (!function_exists('dd')) {
    function dd() {
        $args = func_get_args();

        foreach ($args as $k => $v) {
            $cnt = is_array($v) ? count($v) : null;

            echo "#{$k}" .
                ($cnt ? " [{$cnt}]" : "") .
                ": "
            ;

            $str = trim(json_encode($v, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            $cnt = \mb_strlen($str);

            var_dump(
                ($cnt > 4096
                    ? \mb_substr($str, 0, 4096) . "..."
                    : $str) .
                "\n"
            );
        }
        exit();
    }
}

function arr_merge(array $arr1, array $arr2, array $fields = null): array {
    if (is_null($fields) || !count($fields)) {
        return [
            ...$arr1,
            ...$arr2,
        ];
    }

    $arr = $arr1;
    foreach ($arr2 as $key => $value) {
        // is executed key
        $rule = in_array($key, $fields);

        // has value in $arr1
        $has = key_exists($key, $arr)
            ? !!$arr[$key]
            : false;

        // if not exist
        if ($rule === true && !$has) {
            $arr[$key] = $value;
        }
        // replace all time
        elseif (!$rule) {
            $arr[$key] = $value;
        }
    }

    return $arr;
}

function arr_only_default(array $arr, array $only_keys, $default = null) {
    $data = [];

    foreach ($only_keys as $key) {
        $data[$key] = $arr[$key] ?? $default;
    }

    return $data;
}

function arr_except(array $arr, array $except_keys): array {
    foreach ($except_keys as $key) {
        if (key_exists($key, $arr)) {
            unset($arr[$key]);
        }
    }

    return $arr;
}

function arr_map_keys(array $arr, array $keys, $default = null): array {
    $row = [];

    foreach ($keys as $k1 => $k2) {
        $row[$k2] = $arr[$k1] ?? $default;
    }

    $arr = arr_except($arr, array_keys($keys));

    $row = [
        ...$arr,
        ...$row,
    ];

    foreach ($row as &$v) {
        if (is_string($v)) {
            $v = trim($v) ?: $default;
        }
    }

    return $row;
}

function arrs_map_keys(array $arr, array $keys): array {
    $data = [];

    foreach ($arr as $k => $values) {
        $data[$k] = arr_map_keys($values, $keys);
    }

    return $data;
}

function make_dump(string $file_name, array $data) {
    $path = __DIR__ . DIRECTORY_SEPARATOR .
        ".." . DIRECTORY_SEPARATOR .
        "resources" . DIRECTORY_SEPARATOR .
        "{$file_name}.php";

    return file_put_contents($path, "<?php\n\nreturn " . var_export($data, true) . ";");
}

//

$getIso639_1 = function() use ($fileIso639_1) {
    return getCsv($fileIso639_1);
};

$getIso639_1_Old = function() use ($fileIso639_1_Old) {
    return getCsv($fileIso639_1_Old, ',');
};

$getIso639_2_Group = function() use ($fileIso639_2_Group) {
    return getCsv($fileIso639_2_Group);
};

$getIso639_3 = function() use ($fileIso639_3) {
    return getCsv($fileIso639_3);
};

$getIso639_3_2 = function() use ($fileIso639_3_2) {
    return getCsv($fileIso639_3_2);
};

$getIso639_3_Macrolanguages = function() use ($fileIso639_3_Macrolanguages) {
    return getCsv($fileIso639_3_Macrolanguages);
};

$getIso639_3_Name = function() use ($fileIso639_3_Name) {
    return getCsv($fileIso639_3_Name);
};

$getIso639_3_Name_Index = function() use ($fileIso639_3_Name_Index) {
    return getCsv($fileIso639_3_Name_Index);
};

$getIso639_3_Retirements = function() use ($fileIso639_3_Retirements) {
    return getCsv($fileIso639_3_Retirements);
};

$getIso639_5 = function() use ($fileIso639_5) {
    return getCsv($fileIso639_5);
};

$getIso639_6 = function() use ($fileIso639_6) {
    return getCsv($fileIso639_6);
};

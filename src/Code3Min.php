<?php
declare(strict_types=1);

namespace One23\Iso639;

class Code3Min extends Code3 {
    const DICT_FILE = 'iso639_1';

    public static function from(string $code): self {
        $class = get_called_class();
        $dict = self::getDict($class::DICT_FILE);

        foreach ($dict as $item) {
            if (!$item['iso_639_1_code']) {
                continue;
            }

            if ($item['iso_639_3_code'] === $code) {
                return new self([
                    'iso_639_3_code'    => $item['iso_639_3_code'],
                    'iso_639_3_name'    => $item['iso_639_1_name'],

                    'iso_639_2_b_code'  => $item['iso_639_2_b_code'],
                    'iso_639_2_t_code'  => $item['iso_639_2_t_code'],

                    'iso_639_1_code'    => $item['iso_639_1_code'],

                    'iso_639_3_scope'   => null,
                    'iso_639_3_type'    => null,
                    'iso_639_3_notes'   => null,
                    'iso_639_3_name_inverted' => null,
                    'iso_639_3_merge'   => null,
                    'iso_639_3_merge_reason'=> null,
                    'iso_639_3_merge_date'  => null,
                ]);
            }
        }

        throw new Exception("Code '{$code}' not found");
    }

    /**
     * @return string[]
     * @throws Exception
     */
    public static function all(): array
    {
        $class = get_called_class();
        $dict = self::getDict($class::DICT_FILE);

        return
            array_values(
                array_filter(
                    array_map(function($item) {
                        if (!$item['iso_639_1_code']) {
                            return null;
                        }

                        return (string)$item['iso_639_3_code'] ?: null;
                    }, $dict)
                )
            );
    }
}

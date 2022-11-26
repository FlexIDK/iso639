<?php
declare(strict_types=1);

namespace One23\Iso639;

class Code2t extends AbstractCode2 {

    public static function from(string $code): self {
        $dict = self::getDict('iso639_1');

        foreach ($dict as $item) {
            if ($item['iso_639_2_t_code'] === $code) {
                return new self($item);
            }
        }

        $dict = self::getDict('iso639_2_group');
        if (array_key_exists($code, $dict)) {
            return new self([
                'iso_639_2_t_code' => $code,
                'iso_639_2_b_code' => $code,

                'iso_639_2_t_name' => (string)$dict[$code] ?: null,
                'iso_639_2_b_name' => (string)$dict[$code] ?: null,
            ]);
        }

        throw new Exception("Code '{$code}' not found");
    }

    public static function all(): array {
        $dict = self::getDict('iso639_1');

        return
            array_values(
                array_filter(
                    array_map(function($item) {
                        return (string)$item['iso_639_2_t_code'] ?: null;
                    }, $dict)
                )
            );
    }

    //

    public function getCode(): string
    {
        return (string)$this->data['iso_639_2_t_code'];
    }

    public function getName(): ?string
    {
        return (string)$this->data['iso_639_2_t_name']
            ?: parent::getName();
    }

    //

    public function code2t(): Code2t
    {
        return $this;
    }

}

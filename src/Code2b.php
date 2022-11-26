<?php
declare(strict_types=1);

namespace One23\Iso639;

class Code2b extends AbstractCode2 {

    public static function from(string $code): self {
        $dict = self::getDict('iso639_1');

        foreach ($dict as $data) {
            if ($data['iso_639_2_b_code'] === $code) {
                return new self($data);
            }
        }

        throw new Exception("Code '{$code}' not found");
    }

    public static function all(): array {
        $dict = self::getDict('iso639_1');

        return
            array_values(
                array_filter(
                    array_map(function($item) {
                        return (string)$item['iso_639_2_b_code'] ?: null;
                    }, $dict)
                )
            );
    }

    //

    public function getCode(): string
    {
        return (string)$this->data['iso_639_2_b_code'];
    }

    public function getName(): ?string
    {
        return (string)$this->data['iso_639_2_b_name']
            ?: parent::getName();
    }

    //

    public function code2b(): Code2b
    {
        return $this;
    }

}

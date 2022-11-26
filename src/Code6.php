<?php
declare(strict_types=1);

namespace One23\Iso639;

class Code6 extends AbstractCode {
    const DICT_FILE = 'iso639_6';

    /**
     * @param array{
     *     iso_639_6_code: string,
     *     iso_639_6_name: string,
     *     iso_639_3_code: ?string,
     * } $data
     */
    protected function __construct(protected array $data)
    {
    }

    //

    public static function from(string $code): self {
        $dict = self::getDict(self::DICT_FILE);
        if (!key_exists($code, $dict)) {
            throw new Exception("Code '{$code}' not found");
        }

        return new self($dict[$code]);
    }

    /**
     * @return string[]
     */
    public static function all(): array {
        $dict = self::getDict(self::DICT_FILE);

        return
            array_values(
                array_filter(
                    array_keys($dict)
                )
            );
    }

    //

    public function getCode(): string {
        return (string)$this->data['iso_639_6_code'];
    }

    public function getName(): ?string {
        return (string)$this->data['iso_639_6_name'] ?: null;
    }

    //

    public function toString(): string
    {
        return $this->getCode();
    }

    public function toArray(): array {
        return [
            'iso_639_6_code' => $this->getCode(),
            'iso_639_6_name' => $this->getName(),
        ];
    }
}

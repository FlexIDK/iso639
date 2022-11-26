<?php
declare(strict_types=1);

namespace One23\Iso639;

class Code3Macro extends AbstractCode {
    const DICT_FILE = 'iso639_3_macrolanguages';

    /**
     * @param array{
     *     iso_639_3_code: string,
     *     macrolanguage_code: string,
     *     macrolanguage_status: string,
     *     macrolanguage_name: string,
     *     macrolanguage_alias: string,
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
     * @throws Exception
     */
    public static function all(): array
    {
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
        return (string)$this->data['macrolanguage_code'];
    }

    public function getName(): ?string {
        return (string)$this->data['macrolanguage_name'] ?: null;
    }

    public function getStatus(): string {
        return (string)$this->data['macrolanguage_status'] ?: "A";
    }

    //

    public function code1(): ?Code1 {
        return $this->code3()
            ?->code1();
    }

    public function code2t(): ?Code2t {
        return $this->code3()
            ?->code2t();
    }

    public function code2b(): ?Code2b {
        return $this->code3()
            ?->code2b();
    }

    public function code3(): ?Code3 {
        $code = (string)$this->data['iso_639_3_code'] ?: null;
        if (!$code) {
            return null;
        }

        return Code3::from($code);
    }

    public function alias(): ?Code3Macro {
        $code = (string)$this->data['macrolanguage_alias'] ?: null;
        if (!$code) {
            return null;
        }

        return Code3Macro::from($code);
    }

    //

    public function toString(): string
    {
        return $this->getCode();
    }

    public function toArray(): array {
        return [
            'macrolanguage_code' => $this->getCode(),
            'macrolanguage_name' => $this->getName(),
            'macrolanguage_status'=> $this->getStatus(),

            'macrolanguage_alias'=> (string)$this->alias() ?: null,
            'iso_639_3_code' => (string)$this->code3() ?: null,
        ];
    }
}

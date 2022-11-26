<?php
declare(strict_types=1);

namespace One23\Iso639;

class Code5 extends AbstractCode {
    const DICT_FILE = 'iso639_5';

    /**
     * @param array{
     *     hierarchy: array,
     *     parent: string,
     *     iso_639_5_code: string,
     *     iso_639_5_name: string,
     *     iso_639_5_notes: string,
     *     iso_639_2_t_code: string,
     *     iso_639_2_b_code: string,
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
        return (string)$this->data['iso_639_5_code'];
    }

    public function getName(): ?string {
        return (string)$this->data['iso_639_5_name'] ?: null;
    }

    public function getNotes(): ?string {
        return (string)$this->data['iso_639_5_notes'] ?: null;
    }

    //

    public function parent(): ?Code5 {
        $code = (string)$this->data['parent'] ?: null;
        if (!$code) {
            return null;
        }

        return Code5::from($code);
    }

    public function code1(): ?Code1 {
        return $this->code2t()
            ?->code1();
    }

    public function code2t(): ?Code2t {
        $code = (string)$this->data['iso_639_2_t_code'] ?: null;
        if (!$code) {
            return null;
        }

        try {
            return Code2t::from($code);
        }
        catch (Exception) {
            return null;
        }
    }

    public function code2b(): ?Code2b {
        $code = (string)$this->data['iso_639_2_b_code']
            ?: ((string)$this->data['iso_639_2_t_code'] ?: null);

        if (!$code) {
            return null;
        }

        try {
            return Code2b::from($code);
        }
        catch (Exception) {
            return null;
        }
    }

    public function code3(): ?Code3 {
        return $this->code2t()
            ?->code3();
    }

    //

    public function toString(): string
    {
        return $this->getCode();
    }

    public function toArray(): array {
        return [
            'iso_639_5_code' => $this->getCode(),
            'iso_639_5_name' => $this->getName(),
            'iso_639_5_notes'=> $this->getNotes(),

            'iso_639_5_parent'    => (string)$this->parent() ?: null,

            'iso_639_2_t_code'    => (string)$this->code2t() ?: null,
            'iso_639_2_b_code'    => (string)$this->code2b() ?: null,
        ];
    }
}

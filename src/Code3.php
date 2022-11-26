<?php
declare(strict_types=1);

namespace One23\Iso639;

class Code3 extends AbstractCode {
    const DICT_FILE = 'iso639_3_default';

    /**
     * @param array{
     *     iso_639_3_code: string,
     *     iso_639_3_name: string,
     *     iso_639_2_b_code: string,
     *     iso_639_2_t_code: string,
     *     iso_639_1_code: string,
     *     iso_639_3_scope: string,
     *     iso_639_3_type: string,
     *     iso_639_3_notes: string,
     *     iso_639_3_name_inverted: string,
     *     iso_639_3_merge: string,
     *     iso_639_3_merge_reason: string,
     *     iso_639_3_merge_date: string
     * } $data
     */
    protected function __construct(protected array $data)
    {
    }

    //

    public static function from(string $code): self {
        $class = get_called_class();
        $dict = self::getDict($class::DICT_FILE);

        if (!key_exists($code, $dict)) {
            throw new Exception("Code '{$code}' not found");
        }

        return new $class($dict[$code]);
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
                    array_keys($dict)
                )
            );
    }

    //

    public function getCode(): string {
        return (string)$this->data['iso_639_3_code'];
    }

    public function getName(): ?string {
        return (string)$this->data['iso_639_3_name'] ?: null;
    }

    public function getNameInverted(): ?string {
        return (string)$this->data['iso_639_3_name_inverted'] ?: null;
    }

    public function getScope(): ?string {
        return (string)$this->data['iso_639_3_scope'] ?: "I";
    }

    public function getType(): ?string {
        return (string)$this->data['iso_639_3_type'] ?: "L";
    }

    public function getNotes(): ?string {
        return (string)$this->data['iso_639_3_notes'] ?: null;
    }

    //

    public function code1(): ?Code1 {
        $code = (string)$this->data['iso_639_1_code'] ?: null;
        if (!$code) {
            return null;
        }

        return Code1::from($code);
    }

    public function code2t(): ?Code2t {
        $code = (string)$this->data['iso_639_2_t_code'] ?: null;
        if (!$code) {
            return null;
        }

        return Code2t::from($code);
    }

    public function code2b(): ?Code2b {
        $code = (string)$this->data['iso_639_2_b_code'] ?: null;
        if (!$code) {
            return null;
        }

        return Code2b::from($code);
    }

    public function code3(): ?Code3 {
        return $this;
    }

    public function merge(): ?Code3 {
        $code = (string)$this->data['iso_639_3_merge'] ?: null;
        if (!$code) {
            return null;
        }

        $class = get_called_class();
        try {
            return $class::from($code);
        }
        catch (Exception) {
            return null;
        }
    }

    //

    public function toString(): string
    {
        return $this->getCode();
    }

    public function toArray(): array {
        $merge = $this->merge();

        return [
            'iso_639_3_code' => $this->getCode(),
            'iso_639_3_name' => $this->getName(),
            'iso_639_3_name_inverted' => $this->getNameInverted(),

            'iso_639_3_scope' => $this->getScope(),
            'iso_639_3_type' => $this->getType(),
            'iso_639_3_notes' => $this->getNotes(),

            'iso_639_1_code'    => (string)$this->code1() ?: null,

            'iso_639_2_b_code'  => (string)$this->code2b() ?: null,
            'iso_639_2_t_code'  => (string)$this->code2t() ?: null,

            'iso_639_3_merge'   => (string)$merge ?: null,
            'iso_639_3_merge_reason' => ($merge
                ? ($this->data['iso_639_3_merge_reason'] ?: null)
                : null),

            'iso_639_3_merge_date' => ($merge
                ? ($this->data['iso_639_3_merge_date'] ?: null)
                : null),
        ];
    }
}

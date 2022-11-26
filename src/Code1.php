<?php
declare(strict_types=1);

namespace One23\Iso639;

class Code1 extends AbstractCode {

    /**
     * @param array{
     *     macrolanguage: bool,
     *     ancient: bool,
     *     iso_639_1_code: string,
     *     iso_639_1_name: string,
     *     iso_639_1_native: string,
     *     iso_639_1_notes: string,
     *     iso_639_2_t_code: string,
     *     iso_639_2_t_name: string,
     *     iso_639_2_b_code: string,
     *     iso_639_2_b_name: string,
     *     iso_639_3_code: string,
     *     iso_639_5_code: string,
     *     iso_639_5_name: string,
     *     iso_639_6_code: string
     * } $data
     */
    protected function __construct(protected array $data)
    {
    }

    public static function from(string $code): self {
        $dict = self::getDict('iso639_1');

        if (!key_exists($code, $dict)) {
            throw new Exception("Code '{$code}' not found");
        }

        return new self($dict[$code]);
    }

    /**
     * @return string[]
     */
    public static function all(): array {
        $dict = self::getDict('iso639_1');

        return
            array_values(
                array_filter(
                    array_keys($dict)
                )
            );
    }

    //

    public function getCode(): string {
        return $this->getCode1();
    }

    public function getName(): ?string
    {
        return $this->getName1();
    }

    public function isMacrolanguage(): bool {
        return !!$this->data['macrolanguage'];
    }

    public function isAncient(): bool {
        return !!$this->data['ancient'];
    }

    public function getNotes(): ?string {
        return (string)$this->data['iso_639_1_notes'] ?: null;
    }

    public function getNameNative(): ?string {
        return (string)$this->data['iso_639_1_native'] ?: null;
    }

    public function getFamily(): ?string {
        return (string)$this->data['iso_639_5_name'] ?: null;
    }

    protected function getCode6(): ?string {
        return (string)$this->data['iso_639_6_code'] ?: null;
    }

    /**
     * @return Code3Macro[]
     * @throws Exception
     */
    public function macrolanguages(): array {
        $code3 = (string)$this->code3();
        if (!$code3) {
            return [];
        }

        $dict = self::getDict('iso639_3_macrolanguages_map');

        $codes = $dict[$code3] ?? [];

        $result = [];
        foreach ($codes as $code) {
            $result[$code] = Code3Macro::from($code);
        }

        return $result;
    }

    //

    private function getCode1(): string {
        return (string)$this->data['iso_639_1_code'];
    }

    private function getName1(): ?string {
        return (string)$this->data['iso_639_1_name'] ?: null;
    }

    private function getName2t(): ?string {
        return (string)$this->data['iso_639_2_t_name']
            ?: $this->getName1();
    }

    private function getName2b(): ?string {
        return (string)$this->data['iso_639_2_b_name']
            ?: $this->getName1();
    }

    //

    public function code1(): ?Code1 {
        return $this;
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
        $code3 = (string)$this->data['iso_639_3_code'] ?: null;
        if (!$code3) {
            return null;
        }

        try {
            return Code3::from($code3);
        }
        catch (Exception) {}

        try {
            return Code3All::from($code3);
        }
        catch (Exception) {}

        return null;
    }

    //

    public function toString(): string
    {
        return $this->getCode();
    }

    public function toArray() {
        /**
         * Todo
         *
         * iso_639_5_code
         * iso_639_5_name
         * iso_639_6_code
         */

        $code2t = $this->code2t();
        $code2b = $this->code2t();

        return [
            'iso_639_1_code'    => $this->getCode1(),
            'iso_639_1_name'    => $this->getName1(),
            'iso_639_1_native'  => $this->getNameNative(),
            'iso_639_1_notes'   => $this->getNotes(),
            'iso_639_1_family'  => $this->getFamily(),
            'is_ancient'        => $this->isAncient(),
            'is_macrolanguage'  => !!($this->isMacrolanguage() || count($this->macrolanguages())),
            'macrolanguages'    => array_keys($this->macrolanguages()),

            'iso_639_2_t_code'  => (string)$code2t  ?: null,
            'iso_639_2_t_name'  => (string)$this?->getName2t()  ?: null,

            'iso_639_2_b_code'  => (string)$code2b  ?: null,
            'iso_639_2_b_name'  => (string)$this->getName2b() ?: null,

            'iso_639_3_code'    => (string)$this->code3()   ?: null,

            'iso_639_6_code'=> $this->getCode6(),
        ];
    }
}

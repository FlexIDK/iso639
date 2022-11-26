<?php
declare(strict_types=1);

namespace One23\Iso639;

abstract class AbstractCode2 extends Code1 {

    public function code1(): ?Code1 {
        $code = (string)$this->data['iso_639_1_code'] ?: null;
        if (!$code) {
            return null;
        }

        return Code1::from($code);
    }

}

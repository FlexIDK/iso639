<?php
declare(strict_types=1);

namespace One23\Iso639;

abstract class AbstractCode {

    protected static array $dict = [];

    protected static function getDict(string $name): array {
        if (isset(self::$dict[$name])) {
            return self::$dict[$name];
        }

        $path = null;
        switch ($name) {
            case 'iso639_1':
            case 'iso639_2_group':
            case 'iso639_3':
            case 'iso639_3_default':
            case 'iso639_3_macrolanguages':
            case 'iso639_3_macrolanguages_map':
            case 'iso639_5':
            case 'iso639_6':
                $path = __DIR__ . DIRECTORY_SEPARATOR .
                    ".." . DIRECTORY_SEPARATOR .
                    "resources" . DIRECTORY_SEPARATOR .
                    $name . ".php";
                break;
        }

        if (!$path || !is_file($path)) {
            throw new Exception("ISO Dictionary '{$name}' not exist");
        }

        self::$dict[$name] = include $path;

        return self::$dict[$name];
    }

    abstract public static function from(string $code): self;

    abstract public static function all(): array;

    abstract public function toString(): string;

    public function __toString(): string
    {
        return $this->toString();
    }

}

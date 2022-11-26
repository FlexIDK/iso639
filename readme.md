# PHP ISO-639

PHP library to convert ISO-639 code

---

## Installation

```bash
composer require one23/iso639
```

## Data source 

- en.wikipedia.org: [ISO 639-1](https://en.wikipedia.org/wiki/ISO_639-1) : iso-639-old.csv (deprecate)
- en.wikipedia.org: [List of ISO 639-1 codes](https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes) : iso-639-1.csv
- en.wikipedia.org: [ISO 639-2](https://en.wikipedia.org/wiki/ISO_639-2) : iso-639-2-group.csv
- en.wikipedia.org: [List of ISO 639-3 language codes](https://en.wikipedia.org/wiki/Wikipedia:WikiProject_Languages/List_of_ISO_639-3_language_codes_(2019)) : iso-639-3-name.csv
- en.wikipedia.org: [ISO 639 macrolanguage](https://en.wikipedia.org/wiki/ISO_639_macrolanguage) : iso-639-3.csv
- en.wikipedia.org: [List of ISO 639-5 codes](https://en.wikipedia.org/wiki/List_of_ISO_639-5_codes) : iso-639-5.csv
- en.wikipedia.org: [List of ISO 639-6 codes](https://en.wikipedia.org/wiki/List_of_ISO_639-6_codes) : iso-639-6.csv
- iso639-3.sil.org: [ISO 639-3 Downloads](https://iso639-3.sil.org/code_tables/download_tables) : iso-639-3-macrolanguages_20220311.csv, iso-639-3_20220311.csv, iso-639-3_name_index_20220311.csv, iso-639-3_retirements_20220311.csv

Update date: 2022-11-23

## How to

```php
use \One23\Iso639\Code1;
use \One23\Iso639\Code2b;
use \One23\Iso639\Code2t;
use \One23\Iso639\Code3;

(string)Code1::from('en')->code3(); // => 'eng'
(string)Code1::from('uk')->getNameNative(); // => 'українська мова'
(string)Code1::from('jv')->getName(); // => 'Javanese'


(string)Code2t::from('eng')->getName(); // => 'English'
(string)Code2t::from('ind')->getNameNative(); // => 'Bahasa Indonesia'
(string)Code2t::from('jav')->code1(); // => 'jv'
```

## Use

### Code1 && Code2b && Code2t

**Static methods**

- from(string $code): Code3
- all(): string[]

**Methods**

- getCode(): string
- getName(): ?string
- getNameNative(): ?string
- getNotes(): ?string
- getFamily(): ?string
- isMacrolanguage(): bool
- isAncient(): bool
- macrolanguages(): Code3Macro[]
- code1(): ?Code1
- code2t(): ?Code2t
- code2b(): ?Code2b
- code3(): ?Code3
- toString(): string - alias getCode()
- toArray(): array{iso_639_1_code: string, iso_639_1_name: ?string, iso_639_1_native: ?string, iso_639_1_notes: ?string, iso_639_2_t_code: ?string, iso_639_2_t_name: ?string, iso_639_2_b_code: ?string, iso_639_2_b_name: ?string, iso_639_3_code: ?string, iso_639_5_code: ?Code3, iso_639_5_name: ?string, iso_639_6_code: ?string}

```php
use \One23\Iso639\Code1 as Code;
// or
//use \One23\Iso639\Code2b as Code;
// or
//use \One23\Iso639\Code2t as Code;

$code = Code::from('en');

(string)$code; // => 'en'
// or
$code->getCode(); // => 'en'
// or
$code->toString(); // => 'en'

$code->getName(); // => 'English'

$code->toArray();
// => "{"iso_639_1_code":"en","iso_639_1_name":"English","iso_639_1_native":"English","iso_639_1_notes":null,"iso_639_1_family":"Indo-European","is_ancient":false,"is_macrolanguage":false,"macrolanguages":[],"iso_639_2_t_code":"eng","iso_639_2_t_name":"English","iso_639_2_b_code":"eng","iso_639_2_b_name":"English","iso_639_3_code":"eng","iso_639_6_code":"engs"}

$code1 = Code2b::from('ara')->code1();
$macrolanguages = $code1->macrolanguages();

array_keys($macrolanguages); // => ["aao","abh","abv","acm","acq",...]
reset($macrolanguages); // Code3Macro

Code1::all(); // => ["ab","aa","af","ak",...]
Code2b::all(); // => ["abk","aar","afr","aka","alb","amh",...]
Code2t::all(); // => ["abk","aar","afr","aka","sqi","amh","ara","arg",...]
```

### Code3 && Code3All

**Static methods**

- from(string $code): Code3
- all(): string[]

**Methods**

- getCode(): string
- getName(): ?string
- getNameInverted(): ?string
- getScope(): ?string
- getType(): ?string
- getNotes(): ?string
- code1(): ?Code1
- code2t(): ?Code2t
- code2b(): ?Code2b
- code3(): ?Code3
- merge(): ?Code3
- toString(): string - alias getCode()
- toArray(): array{iso_639_3_code: string, iso_639_3_name: ?string, iso_639_3_name_inverted: ?string, iso_639_3_scope: ?string, iso_639_3_type: ?string, iso_639_3_notes: ?string, iso_639_1_code: ?string, iso_639_2_b_code: ?string, iso_639_2_t_code: ?string, iso_639_3_merge: ?Code3, iso_639_3_merge_reason: ?string, iso_639_3_merge_date: ?string}

```php
use \One23\Iso639\Code3;
// or
//use \One23\Iso639\Code3All as Code3;

$code3 = Code3::from('ful');

(string)$code3; // => 'ful'
// or
$code3->getCode(); // => 'ful'
// or
$code3->toString(); // => 'ful'

$code3->getName(); // => 'Fulah'

$code3->toArray();
// => {"iso_639_3_code":"ful","iso_639_3_name":"Fulah","iso_639_3_name_inverted":"Fulah","iso_639_3_scope":"M","iso_639_3_type":"L","iso_639_3_notes":null,"iso_639_1_code":"ff","iso_639_2_b_code":"ful","iso_639_2_t_code":"ful","iso_639_3_merge":null,"iso_639_3_merge_reason":null,"iso_639_3_merge_date":null}

$code3 = Code3All::from('xrq');

/** @var Code3All|null $merge **/
$merge = $code3->merge()
if ($merge) {
    $merge->toArray();
    // => {"iso_639_3_code":"dmw","iso_639_3_name":"Mudburra","iso_639_3_name_inverted":"Mudburra","iso_639_3_scope":"I","iso_639_3_type":"L","iso_639_3_notes":null,"iso_639_1_code":null,"iso_639_2_b_code":null,"iso_639_2_t_code":null,"iso_639_3_merge":null,"iso_639_3_merge_reason":null,"iso_639_3_merge_date":null}
}

Code3::all(); // => ["aka","ara","aym","aze","bal",...]
```

### Code3Macro

**Static methods**

- from(string $code): Code3
- all(): string[]

**Methods**

- getCode(): string
- getName(): ?string
- getStatus(): ?string
- code1(): ?Code1
- code2t(): ?Code2t
- code2b(): ?Code2b
- code3(): ?Code3
- alias(): ?Code3Macro
- toString(): string - alias getCode()
- toArray(): array{macrolanguage_code: string, macrolanguage_name: ?string, macrolanguage_status: string, macrolanguage_alias: ?string, iso_639_3_code: ?string}

```php
use \One23\Iso639\Code3Macro;

$code3Macro = Code3Macro::from('pmu');

(string)$code3Macro; // => 'pmu'
// or
$code3Macro->getCode(); // => 'pmu'
// or
$code3Macro->toString(); // => 'pmu'

$code3Macro->getName(); // => 'Mirpur Panjabi'

$code3Macro->toArray();
// => {"macrolanguage_code":"pmu","macrolanguage_name":"Mirpur Panjabi","macrolanguage_status":"R","macrolanguage_alias":"phr","iso_639_3_code":"lah"}

/** @var Code3Macro|null $parent **/
$alias = $code3Macro->alias()
if ($alias) {
    $alias->toArray();
    // => {"macrolanguage_code":"phr","macrolanguage_name":"Pahari-Potwari","macrolanguage_status":"A","macrolanguage_alias":null,"iso_639_3_code":"lah"}
}

Code3Macro::all(); // => ["fat","twi","aao","abh","abv","acm",...]
```

### Code5

**Static methods**

- from(string $code): Code5
- all(): string[]

**Methods**

- getCode(): string
- getName(): ?string
- getNotes(): ?string
- parent(): ?Code5
- code1(): ?Code1
- code2t(): ?Code2t
- code3(): ?Code3
- toString(): string - alias getCode()
- toArray(): array{iso_639_5_code: string, iso_639_5_name: ?string, iso_639_5_notes: ?string, parent: ?string, iso_639_2_t_code: ?string, iso_639_2_b_code: ?string}

```php
use \One23\Iso639\Code5;

$code5 = Code5::from('alg');

(string)$code5; // => 'alg'
// or
$code5->getCode(); // => 'alg'
// or
$code5->toString(); // => 'alg'

$code5->getName(); // => 'Algonquian languages'

$code5->toArray();
// => {"iso_639_5_code":"alg","iso_639_5_name":"Algonquian languages","iso_639_5_notes":null,"iso_639_5_parent":"aql","iso_639_2_t_code":"alg","iso_639_2_b_code":null}

/** @var Code5|null $parent **/
$parent = $code5->parent()
if ($parent) {
    $parent->toArray();
    // => {"iso_639_5_code":"aql","iso_639_5_name":"Algic languages","iso_639_5_notes":null,"iso_639_5_parent":"nai","iso_639_2_t_code":null,"iso_639_2_b_code":null}
}

Code5::all(); // => ["aav","afa","alg","alv","apa",...]


$code5 = Code5::from('aav');
$code5->getNotes(); // => 'South-Asiatic languages, not related to Australian languages'
```

### Code6

**Static methods**

- from(string $code): Code5
- all(): string[]

**Methods**

- getCode(): string
- getName(): ?string
- toString(): string - alias getCode()
- toArray(): array{iso_639_6_code: string, iso_639_6_name: ?string}

```php
use \One23\Iso639\Code6;

$code6 = Code6::from('tjin');

(string)$code6; // => 'tjin'
// or
$code6->getCode(); // => 'tjin'
// or
$code6->toString(); // => 'tjin'

$code6->getName(); // => 'Tianjin'

$code6->toArray(); 
// => {"iso_639_6_code":"tjin","iso_639_6_name":"Tianjin"}

Code6::all(); // => ["ango","bicr","bjgh","bjjg",...]
```

## Security

If you discover any security related issues, please email eugene@krivoruchko.info instead of using the issue tracker.

## License

[MIT](https://github.com/FlexIDK/iso639/LICENSE)

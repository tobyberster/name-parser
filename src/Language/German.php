<?php

namespace TheIconic\NameParser\Language;

use TheIconic\NameParser\LanguageInterface;

class German implements LanguageInterface
{
    const SUFFIXES = [
        '1.' => '1.',
        '2.' => '2.',
        '3.' => '3.',
        '4.' => '4.',
        '5.' => '5.',
        'i' => 'I',
        'ii' => 'II',
        'iii' => 'III',
        'iv' => 'IV',
        'v' => 'V',
        'ek' => 'e.K.',
        'jun.' => 'jun.',
        'sen.' => 'sen.',
    ];

    const SALUTATIONS = [
        'inhdiplpharm' => 'Inh. Dipl.-Pharm.',
        'diplpharm' => 'Dipl.-Pharm.',
        'dipl-pharm' => 'Dipl.-Pharm.',
        'dipl-ing' => 'Dipl.-Ing.',
        'dipl-kfm' => 'Dipl.-Kfm.',
        'dipl-kffr' => 'Dipl.-Kffr.',
        'dipl-psych' => 'Dipl.-Psych.',
        'dr-ing' => 'Dr.-Ing.',
        'drmed' => 'Dr. med.',
        'dr med' => 'Dr. med.',
        'dr med dent' => 'Dr. med. dent.',
        'dr med vet' => 'Dr. med. vet.',
        'dr rer nat' => 'Dr. rer. nat.',
        'dr phil' => 'Dr. phil.',
        'dr jur' => 'Dr. jur.',
        'inh' => 'Inh.',
        'z hd' => 'z. Hd.',
        'zhd' => 'z. Hd.',
        'herr' => 'Herr',
        'hr' => 'Herr',
        'frau' => 'Frau',
        'fr' => 'Frau',
        'dr' => 'Dr',
    ];

    const LASTNAME_PREFIXES = [
        'den' => 'den',
        'der' => 'der',
        'van' => 'van',
        'vom' => 'vom',
        'von' => 'von',
        'zu' => 'zu',
        'zum' => 'zum',
        'zur' => 'zur',
    ];

    public function getSuffixes(): array
    {
        return self::SUFFIXES;
    }

    public function getSalutations(): array
    {
        return self::SALUTATIONS;
    }

    public function getLastnamePrefixes(): array
    {
        return self::LASTNAME_PREFIXES;
    }
}

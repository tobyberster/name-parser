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
    ];

    const SALUTATIONS = [
        'inhdiplpharm' => 'Inh. Dipl.-Pharm.',
        'diplpharm' => 'Dipl.-Pharm.',
        'drmed' => 'Dr. med.',
        'herr' => 'Herr',
        'hr' => 'Herr',
        'frau' => 'Frau',
        'fr' => 'Frau',
        'dr' => 'Dr',
    ];

    const LASTNAME_PREFIXES = [
        'der' => 'der',
        'von' => 'von',
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

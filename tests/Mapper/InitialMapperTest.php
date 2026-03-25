<?php

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Language\English;
use TheIconic\NameParser\Part\Initial;
use TheIconic\NameParser\Part\Salutation;
use TheIconic\NameParser\Part\Lastname;

class InitialMapperTest extends AbstractMapperTest
{
    /**
     * @return array
     */
    public static function provider()
    {
        return [
            [
                'input' => [
                    'A',
                    'B',
                ],
                'expectation' => [
                    new Initial('A'),
                    'B',
                ],
            ],
            [
                'input' => [
                    new Salutation('Mr'),
                    'P.',
                    'Pan',
                ],
                'expectation' => [
                    new Salutation('Mr'),
                    new Initial('P.'),
                    'Pan',
                ],
            ],
            [
                'input' => [
                    new Salutation('Mr'),
                    'Peter',
                    'D.',
                    new Lastname('Pan'),
                ],
                'expectation' => [
                    new Salutation('Mr'),
                    'Peter',
                    new Initial('D.'),
                    new Lastname('Pan'),
                ],
            ],
            [
                'input' => [
                    'James',
                    'B'
                ],
                'expectation' => [
                    'James',
                    'B'
                ],
            ],
            [
                'input' => [
                    'James',
                    'B'
                ],
                'expectation' => [
                    'James',
                    new Initial('B'),
                ],
                'arguments' => [
                    2,
                    true
                ],
            ],
            [
                'input' => [
                    'JM',
                    'Walker',
                ],
                'expectation' => [
                    new Initial('J'),
                    new Initial('M'),
                    'Walker'
                ]
            ],
            [
                'input' => [
                    'JM',
                    'Walker',
                ],
                'expectation' => [
                    'JM',
                    'Walker'
                ],
                'arguments' => [
                    1
                ]
            ],
            // combined initials at last position should not expand when matchLastPart is false
            [
                'input' => [
                    'Smith',
                    'MR',
                ],
                'expectation' => [
                    'Smith',
                    'MR',
                ],
            ],
            // combined initials at last position should expand when matchLastPart is true
            [
                'input' => [
                    'Smith',
                    'MR',
                ],
                'expectation' => [
                    'Smith',
                    new Initial('M'),
                    new Initial('R'),
                ],
                'arguments' => [
                    2,
                    true,
                ],
            ],
            // multiple combined initials in one name
            [
                'input' => [
                    'JM',
                    'Peter',
                    'Walker',
                ],
                'expectation' => [
                    new Initial('J'),
                    new Initial('M'),
                    'Peter',
                    'Walker',
                ],
            ],
            // already-mapped parts should be skipped during expansion
            [
                'input' => [
                    new Salutation('Mr'),
                    'JM',
                    'Walker',
                ],
                'expectation' => [
                    new Salutation('Mr'),
                    new Initial('J'),
                    new Initial('M'),
                    'Walker',
                ],
            ],
        ];
    }

    protected function getMapper($maxCombined = 2, $matchLastPart = false)
    {
        return new InitialMapper($maxCombined, $matchLastPart);
    }
}

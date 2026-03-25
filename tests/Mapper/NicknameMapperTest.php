<?php

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\Salutation;
use TheIconic\NameParser\Part\Nickname;

class NicknameMapperTest extends AbstractMapperTest
{
    /**
     * @return array
     */
    public static function provider()
    {
        return [
            [
                'input' => [
                    'James',
                    '(Jim)',
                    'T.',
                    'Kirk',
                ],
                'expectation' => [
                    'James',
                    new Nickname('Jim'),
                    'T.',
                    'Kirk',
                ],
            ],
            [
                'input' => [
                    'James',
                    '(\'Jim\')',
                    'T.',
                    'Kirk',
                ],
                'expectation' => [
                    'James',
                    new Nickname('Jim'),
                    'T.',
                    'Kirk',
                ],
            ],
            [
                'input' => [
                    'William',
                    '"Will"',
                    'Shatner',
                ],
                'expectation' => [
                    'William',
                    new Nickname('Will'),
                    'Shatner',
                ],
            ],            [
                'input' => [
                    new Salutation('Mr'),
                    'Andre',
                    '(The',
                    'Giant)',
                    'Rene',
                    'Roussimoff',
                ],
                'expectation' => [
                    new Salutation('Mr'),
                    'Andre',
                    new Nickname('The'),
                    new Nickname('Giant'),
                    'Rene',
                    'Roussimoff',
                ],
            ],
            [
                'input' => [
                    new Salutation('Mr'),
                    'Andre',
                    '["The',
                    'Giant"]',
                    'Rene',
                    'Roussimoff',
                ],
                'expectation' => [
                    new Salutation('Mr'),
                    'Andre',
                    new Nickname('The'),
                    new Nickname('Giant'),
                    'Rene',
                    'Roussimoff',
                ],
            ],
            [
                'input' => [
                    new Salutation('Mr'),
                    'Andre',
                    '"The',
                    'Giant"',
                    'Rene',
                    'Roussimoff',
                ],
                'expectation' => [
                    new Salutation('Mr'),
                    'Andre',
                    new Nickname('The'),
                    new Nickname('Giant'),
                    'Rene',
                    'Roussimoff',
                ],
            ],
            // unclosed delimiter should revert nickname mappings
            [
                'input' => [
                    'John',
                    '(Nick',
                    'Smith',
                ],
                'expectation' => [
                    'John',
                    '(Nick',
                    'Smith',
                ],
            ],
            // unclosed delimiter with already-mapped parts should revert
            [
                'input' => [
                    new Salutation('Mr'),
                    'John',
                    '(Nick',
                    'Middle',
                    'Smith',
                ],
                'expectation' => [
                    new Salutation('Mr'),
                    'John',
                    '(Nick',
                    'Middle',
                    'Smith',
                ],
            ],
            // closed nickname followed by unclosed should keep the closed one
            [
                'input' => [
                    'John',
                    '(Jim)',
                    '(Broken',
                    'Smith',
                ],
                'expectation' => [
                    'John',
                    new Nickname('Jim'),
                    '(Broken',
                    'Smith',
                ],
            ],
        ];
    }

    protected function getMapper()
    {
        return new NicknameMapper([
            '[' => ']',
            '{' => '}',
            '(' => ')',
            '<' => '>',
            '"' => '"',
            '\'' => '\''
        ]);
    }
}

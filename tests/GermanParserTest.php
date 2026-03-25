<?php

namespace TheIconic\NameParser;

use PHPUnit\Framework\TestCase;
use TheIconic\NameParser\Language\German;

class GermanParserTest extends TestCase
{
    /**
     * @return array
     */
    public static function provider()
    {
        return [
            [
                'Herr Schmidt',
                [
                    'salutation' => 'Herr',
                    'lastname' => 'Schmidt',
                ]
            ],
            [
                'Frau Maria Lange',
                [
                    'salutation' => 'Frau',
                    'firstname' => 'Maria',
                    'lastname' => 'Lange',
                ]
            ],
            [
                'Hr. Juergen von der Lippe',
                [
                    'salutation' => 'Herr',
                    'firstname' => 'Juergen',
                    'lastname' => 'von der Lippe',
                ]
            ],
            [
                'Fr. Charlotte von Stein',
                [
                    'salutation' => 'Frau',
                    'firstname' => 'Charlotte',
                    'lastname' => 'von Stein',
                ]
            ],
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('provider')]
    public function testParse($input, $expectation)
    {
        $parser = new Parser([
            new German()
        ]);
        $name = $parser->parse($input);

        $this->assertInstanceOf(Name::class, $name);
        $this->assertEquals($expectation, $name->getAll());
    }
}

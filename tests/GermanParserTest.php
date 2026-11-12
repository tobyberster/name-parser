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
            [
                'Dr. med. Anna Schmidt',
                [
                    'salutation' => 'Dr. med.',
                    'firstname' => 'Anna',
                    'lastname' => 'Schmidt',
                ]
            ],
            [
                'Herr Dr. med. Hans Müller',
                [
                    'salutation' => 'Herr Dr. med.',
                    'firstname' => 'Hans',
                    'lastname' => 'Müller',
                ]
            ],
            [
                'Dr. rer. nat. Anna Schmidt',
                [
                    'salutation' => 'Dr. rer. nat.',
                    'firstname' => 'Anna',
                    'lastname' => 'Schmidt',
                ]
            ],
            [
                'Dr. Med',
                [
                    'salutation' => 'Dr',
                    'lastname' => 'Med',
                ]
            ],
            [
                'Dipl.-Ing. Hans Müller',
                [
                    'salutation' => 'Dipl.-Ing.',
                    'firstname' => 'Hans',
                    'lastname' => 'Müller',
                ]
            ],
            [
                'Inh. Dipl.-Pharm. Anna Schmidt',
                [
                    'salutation' => 'Inh. Dipl.-Pharm.',
                    'firstname' => 'Anna',
                    'lastname' => 'Schmidt',
                ]
            ],
            [
                'z. Hd. Hans Müller',
                [
                    'salutation' => 'z. Hd.',
                    'firstname' => 'Hans',
                    'lastname' => 'Müller',
                ]
            ],
            [
                'Hans Müller jun.',
                [
                    'firstname' => 'Hans',
                    'lastname' => 'Müller',
                    'suffix' => 'jun.',
                ]
            ],
            [
                'Hans Müller sen.',
                [
                    'firstname' => 'Hans',
                    'lastname' => 'Müller',
                    'suffix' => 'sen.',
                ]
            ],
            [
                'Amartya Kumar Sen',
                [
                    'firstname' => 'Amartya',
                    'middlename' => 'Kumar',
                    'lastname' => 'Sen',
                ]
            ],
            [
                'von Müller',
                [
                    'lastname' => 'von Müller',
                ]
            ],
            [
                'Herr von Müller',
                [
                    'salutation' => 'Herr',
                    'lastname' => 'von Müller',
                ]
            ],
            [
                'Von Müller',
                [
                    'firstname' => 'Von',
                    'lastname' => 'Müller',
                ]
            ],
            [
                'Jan van den Berg',
                [
                    'firstname' => 'Jan',
                    'lastname' => 'van den Berg',
                ]
            ],
            [
                'Karl-Theodor zu Guttenberg',
                [
                    'firstname' => 'Karl-Theodor',
                    'lastname' => 'zu Guttenberg',
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

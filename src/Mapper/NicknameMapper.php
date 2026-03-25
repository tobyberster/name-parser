<?php

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Part\Nickname;

class NicknameMapper extends AbstractMapper
{
    /**
     * @var array
     */
    protected $delimiters = [
        '[' => ']',
        '{' => '}',
        '(' => ')',
        '<' => '>',
        '"' => '"',
        '\'' => '\''
    ];

    public function __construct(array $delimiters = [])
    {
        if (!empty($delimiters)) {
            $this->delimiters = $delimiters;
        }
    }

    /**
     * map nicknames in the parts array
     *
     * @param array $parts the name parts
     * @return array the mapped parts
     */
    public function map(array $parts): array
    {
        $isEncapsulated = false;

        $regexp = $this->buildRegexp();

        $closingDelimiter = '';

        /** @var array<int, string> indices mapped during current unclosed encapsulation, with original values */
        $pendingNicknames = [];

        foreach ($parts as $k => $part) {
            if ($part instanceof AbstractPart) {
                continue;
            }

            if (preg_match($regexp, $part, $matches)) {
                $isEncapsulated = true;
                $part = mb_substr($part, 1, null, 'UTF-8');
                $closingDelimiter = $this->delimiters[$matches[1]];
                $pendingNicknames = [];
            }

            if (!$isEncapsulated) {
                continue;
            }

            $pendingNicknames[$k] = $parts[$k];

            if ($closingDelimiter === mb_substr($part, -1, 1, 'UTF-8')) {
                $isEncapsulated = false;
                $part = mb_substr($part, 0, -1, 'UTF-8');
                $pendingNicknames = [];
            }

            $parts[$k] = new Nickname(str_replace(['"', '\''], '', $part));
        }

        // revert if closing delimiter was never found
        if ($isEncapsulated) {
            foreach ($pendingNicknames as $k => $original) {
                $parts[$k] = $original;
            }
        }

        return $parts;
    }

    /**
     * @return string
     */
    protected function buildRegexp()
    {
        $regexp = '/^([';

        foreach ($this->delimiters as $opening => $closing) {
            $regexp .= sprintf('\\%s', $opening);
        }

        $regexp .= '])/';

        return $regexp;
    }
}

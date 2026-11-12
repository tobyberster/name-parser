<?php

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Part\Suffix;

class SuffixMapper extends AbstractMapper
{
    protected $suffixes = [];

    protected $matchSinglePart = false;

    protected $reservedParts = 2;

    public function __construct(array $suffixes, bool $matchSinglePart = false, int $reservedParts = 2)
    {
        $this->suffixes = $suffixes;
        $this->matchSinglePart = $matchSinglePart;
        $this->reservedParts = $reservedParts;
    }

    /**
     * map suffixes in the parts array
     *
     * @param array $parts the name parts
     * @return array the mapped parts
     */
    public function map(array $parts): array
    {
        if ($this->isMatchingSinglePart($parts)) {
            $parts[0] = new Suffix($parts[0], $this->suffixes[$this->getSuffixKey($parts[0])]);
            return $parts;
        }

        $start = count($parts) - 1;

        for ($k = $start; $k > $this->reservedParts - 1; $k--) {
            $part = $parts[$k];

            if (!$this->isSuffix($part)) {
                break;
            }

            $parts[$k] = new Suffix($part, $this->suffixes[$this->getSuffixKey($part)]);
        }

        return $parts;
    }

    /**
     * @param $parts
     * @return bool
     */
    protected function isMatchingSinglePart($parts): bool
    {
        if (!$this->matchSinglePart) {
            return false;
        }

        if (1 !== count($parts)) {
            return false;
        }

        return $this->isSuffix($parts[0]);
    }

    /**
     * @param $part
     * @return bool
     */
    protected function isSuffix($part): bool
    {
        if ($part instanceof AbstractPart) {
            return false;
        }

        return null !== $this->getSuffixKey($part);
    }

    /**
     * find the key of the given word in the suffix list
     *
     * keys that end in a dot (e.g. "sen.") only match a word written
     * with that dot, so they do not swallow a lastname spelled the same
     *
     * @param string $part
     * @return string|null
     */
    protected function getSuffixKey(string $part): ?string
    {
        $key = $this->getKey($part);

        if (array_key_exists($key, $this->suffixes)) {
            return $key;
        }

        if ('.' === mb_substr($part, -1, null, 'UTF-8') && array_key_exists($key . '.', $this->suffixes)) {
            return $key . '.';
        }

        return null;
    }
}

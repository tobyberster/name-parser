<?php

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Part\Salutation;

class SalutationMapper extends AbstractMapper
{
    protected $salutations = [];

    protected $maxIndex = 0;

    /**
     * multi-word salutation keys split into words, longest first
     *
     * @var array
     */
    protected $multiWordKeys = [];

    public function __construct(array $salutations, $maxIndex = 0)
    {
        $this->salutations = $salutations;
        $this->maxIndex = $maxIndex;

        foreach (array_keys($salutations) as $key) {
            $words = explode(' ', (string) $key);

            if (count($words) > 1) {
                $this->multiWordKeys[$key] = $words;
            }
        }

        uasort($this->multiWordKeys, function (array $a, array $b) {
            return count($b) <=> count($a);
        });
    }

    /**
     * map salutations in the parts array
     *
     * @param array $parts the name parts
     * @return array the mapped parts
     */
    public function map(array $parts): array
    {
        $max = ($this->maxIndex > 0) ? $this->maxIndex : floor(count($parts) / 2);

        for ($k = 0; $k < $max; $k++) {
            if ($parts[$k] instanceof AbstractPart) {
                break;
            }

            $parts = $this->substituteWithSalutation($parts, $k);
        }

        return $parts;
    }

    /**
     * We pass the full parts array and the current position to allow
     * not only single-word matches but also combined matches with
     * subsequent words (parts).
     *
     * @param array $parts
     * @param int $start
     * @return array
     */
    protected function substituteWithSalutation(array $parts, int $start): array
    {
        // multi-word entries first, so "Dr. med." is not taken as "Dr." plus a first name "med."
        foreach ($this->multiWordKeys as $key => $keys) {
            $length = count($keys);

            $subset = array_slice($parts, $start, $length);

            // leave at least one part for the name itself
            if ($start + $length >= count($parts)) {
                continue;
            }

            if ($this->isMatchingSubset($keys, $subset)) {
                array_splice($parts, $start, $length, [new Salutation(implode(' ', $subset), $this->salutations[$key])]);
                return $parts;
            }
        }

        if ($this->isSalutation($parts[$start])) {
            $parts[$start] = new Salutation($parts[$start], $this->salutations[$this->getKey($parts[$start])]);
        }

        return $parts;
    }

    /**
     * check if the given subset matches the given keys entry by entry,
     * which means word by word, except that we first need to key-ify
     * the subset words
     *
     * @param array $keys
     * @param array $subset
     * @return bool
     */
    private function isMatchingSubset(array $keys, array $subset): bool
    {
        for ($i = 0; $i < count($subset); $i++) {
            if ($subset[$i] instanceof AbstractPart || $this->getKey($subset[$i]) !== $keys[$i]) {
                return false;
            }
        }

        return true;
    }

    /**
     * check if the given word is a viable salutation
     *
     * @param string $word the word to check
     * @return bool
     */
    protected function isSalutation($word): bool
    {
        return (array_key_exists($this->getKey($word), $this->salutations));
    }
}

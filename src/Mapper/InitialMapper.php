<?php

namespace TheIconic\NameParser\Mapper;

use TheIconic\NameParser\Part\AbstractPart;
use TheIconic\NameParser\Part\Initial;

/**
 * single letter, possibly followed by a period
 */
class InitialMapper extends AbstractMapper
{
    protected $matchLastPart = false;

    private $combinedMax = 2;

    public function __construct(int $combinedMax = 2, bool $matchLastPart = false)
    {
        $this->matchLastPart = $matchLastPart;
        $this->combinedMax = $combinedMax;
    }

    /**
     * map intials in parts array
     *
     * @param array $parts the name parts
     * @return array the mapped parts
     */
    public function map(array $parts): array
    {
        // first pass: collect combined initials that need expanding
        $expansions = [];
        $last = count($parts) - 1;

        foreach ($parts as $k => $part) {
            if ($part instanceof AbstractPart) {
                continue;
            }

            if (!$this->matchLastPart && $k === $last) {
                continue;
            }

            if (mb_strtoupper($part, 'UTF-8') === $part) {
                $stripped = str_replace('.', '', $part);
                $length = mb_strlen($stripped, 'UTF-8');

                if (1 < $length && $length <= $this->combinedMax) {
                    $expansions[$k] = preg_split('//u', $stripped, -1, PREG_SPLIT_NO_EMPTY);
                }
            }
        }

        // apply expansions in reverse order so indices stay valid
        foreach (array_reverse($expansions, true) as $k => $chars) {
            array_splice($parts, $k, 1, $chars);
        }

        // second pass: map individual initials
        $last = count($parts) - 1;

        foreach ($parts as $k => $part) {
            if ($part instanceof AbstractPart) {
                continue;
            }

            if (!$this->matchLastPart && $k === $last) {
                continue;
            }

            if ($this->isInitial($part)) {
                $parts[$k] = new Initial($part);
            }
        }

        return $parts;
    }

    /**
     * @param string $part
     * @return bool
     */
    protected function isInitial(string $part): bool
    {
        $length = mb_strlen($part, 'UTF-8');

        if (1 === $length) {
            return true;
        }

        return ($length === 2 && mb_substr($part, -1, 1, 'UTF-8') === '.');
    }
}

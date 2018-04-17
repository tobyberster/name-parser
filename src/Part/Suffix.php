<?php

namespace TheIconic\NameParser\Part;

class Suffix extends AbstractPart
{
    protected $normalized = '';

    public function __construct(string $value, string $normalized = null)
    {
        $this->normalized = $normalized ?? $value;

        return parent::__construct($value);
    }

    /**
     * if this is a lastname prefix, look up normalized version from registry
     * otherwise camelcase the lastname
     *
     * @return string
     */
    public function normalize(): string
    {
        return $this->normalized;
    }
}

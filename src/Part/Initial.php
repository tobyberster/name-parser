<?php

namespace TheIconic\NameParser\Part;
use function TheIconic\NameParser\strtoupper;

class Initial extends GivenNamePart
{
    /**
     * uppercase the initial
     *
     * @return string
     */
    public function normalize(): string
    {
        return strtoupper($this->getValue());
    }
}

<?php

namespace TheIconic\NameParser\Part;

class Initial extends GivenNamePart
{
    /**
     * uppercase the initial
     *
     * @return string
     */
    public function normalize(): string
    {
        return mb_strtoupper($this->getValue(), 'UTF-8');
    }
}

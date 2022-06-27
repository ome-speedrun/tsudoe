<?php

namespace App\Values;

use JsonSerializable;
use Stringable;

abstract class ValueObject implements JsonSerializable, Stringable
{
    public function jsonSerialize(): mixed
    {
        return $this->__toString();
    }
}

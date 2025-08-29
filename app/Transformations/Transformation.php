<?php

namespace App\Transformations;

abstract class Transformation
{
    abstract public function transform(string $text): string;
}

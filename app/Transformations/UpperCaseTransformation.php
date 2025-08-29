<?php

namespace App\Transformations;

class UpperCaseTransformation extends Transformation
{
    public function transform(string $text): string
    {
        return mb_strtoupper($text, 'UTF-8');
    }
}

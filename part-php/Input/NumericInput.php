<?php

namespace Input;

use Input\Input;
use Input\TextInput;

class NumericInput extends TextInput implements Input
{
    private string|int $value;

    public function __construct()
    {
        parent::__construct();
        $this->value = 0;
    }

    public function add(int|string $input)
    {
        if (is_numeric($input)) {
            $this->value = $this->value+=$input;
        }
    }

    public function getValue(): string|int
    {
        return $this->value;
    }
}







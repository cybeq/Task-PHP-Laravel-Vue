<?php

namespace Input;

use Input\Input;

class TextInput implements Input
{
    private string|int $value;

    public function __construct(){
        $this->value = '';
    }
    public function add(int|string $input){
     $this->value = $this->value.$input;
    }
    public function getValue(): string|int{
       return $this->value;
    }
}
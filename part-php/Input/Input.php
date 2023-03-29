<?php
namespace Input;


interface Input{
    public function add(int|string $input);
    public function getValue():string|int;
}
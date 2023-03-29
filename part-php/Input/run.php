<?php

require_once 'autoload.php';
use Input\TextInput;
Use Input\NumericInput;




$textInput = new TextInput();
$textInput->add('Hello');
$textInput->add('World');
echo $textInput->getValue();

$numericInput = new NumericInput();
$numericInput->add('2');
$numericInput->add('test');
echo "<br/>".$numericInput->getValue();




<?php
$multiplyBy3 = function($var) { return $var * 3; };
$plus1 = function($var) { return $var + 1; };
$divideBy2 = function($var) { return $var / 2; };

class Pipeline {
    public static function make(...$actions): Closure
    {
        return function ($arg) use ($actions) {
            $result = $arg;
            foreach ($actions as $action) {
                $result = $action($result);
            }
            return $result;
        };
    }
}
$pipeline = Pipeline::make(  $multiplyBy3, $plus1, $divideBy2 );
echo $pipeline(3);
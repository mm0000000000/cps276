<?php
class Calculator {
    public function calc($operator = null, $num1 = null, $num2 = null) {

        $err = "<p>Cannot perform operation. You must have three arguments. A string for the operator (+,-,*,/) and two integers or floats for the numbers.</p>";

        // exactly 3 arguments
        if (func_num_args() != 3) {
            return $err;
        }

        // valid operator
        if ($operator != "+" && $operator != "-" && $operator != "*" && $operator != "/") {
            return $err;
        }

        // both numbers
        if (!is_numeric($num1) || !is_numeric($num2)) {
            return $err;
        }

        // divide by zero
        if ($operator == "/" && $num2 == 0) {
            return "<p>The calculation is $num1 / $num2. The answer is cannot divide a number by zero.</p>";
        }

        // compute
        if ($operator == "+") {
            $answer = $num1 + $num2;
        } elseif ($operator == "-") {
            $answer = $num1 - $num2;
        } elseif ($operator == "*") {
            $answer = $num1 * $num2;
        } else { // "/"
            $answer = $num1 / $num2;
        }

        return "<p>The calculation is $num1 $operator $num2. The answer is $answer.</p>";
    }
}

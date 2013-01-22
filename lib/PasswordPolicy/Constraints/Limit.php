<?php

namespace PasswordPolicy\Constraints;

class Limit implements \PasswordPolicy\Constraint {

    protected $min = 0;
    protected $max = 0;

    public function __construct($min, $max) {
        $this->min = (int) $min;
        $this->max = (int) $max;
    }

    public function check($number) {
        if ($number < $this->min) {
            return false;
        }
        if ($number > $this->max) {
            return false;
        }
        return true;
    }

    public function getMessage() {
        if ($this->max == 0) {
            return "no";
        } elseif ($this->min == 0) {
            return "at most {$this->max}";
        } elseif ($this->max == PHP_INT_MAX) {
            return "at least {$this->min}";
        }
        return "at least {$this->min} and at most {$this->max}";
    }

    public function toJavaScript() {
        $msg = $this->getMessage();
        return "function(num) {
                if (num < {$this->min}) {
                    return false;
                } else if (num > {$this->max}) {
                    return false;
                }
                return true;
            }";
    }
}
<?php

namespace PasswordPolicy\Rules;

class Regex extends Base {

    protected $description = '';
    protected $regex = '';

    public function __construct($regex, $textDescription) {
        $this->description = $textDescription;
        $this->regex = $regex;
    }

    public function getMessage() {
        $constraint = parent::getMessage();
        return sprintf($this->description, $constraint);
    }

    public function test($password) {
        $matches = array();
        $num = preg_match_all($this->regex, $password, $matches);
        return $this->testConstraint($num, $password);
    }

    public function toJavaScript() {
        $ret = "{
            message: " . json_encode($this->getMessage()) . ",
            check: function(p) {
                var r = {$this->regex}g;";
        if ($this->constraint) {
            $ret .= "
                var c = " . $this->constraint->toJavaScript() . ";
                var l = p.match(r);
                l = l ? l.length : 0;
                return c(l);";
        } else {
            $ret .= "
                return r.test(p);";
        }
        $ret .= "
            }
        }";
        return $ret;
    }

    public static function toCharClass($desc) {
        switch ($desc) {
            case 'letter':
                return array('a-zA-Z', 'letter');
            case 'lowercase':
                return array('a-z', 'lowercase');
            case 'uppercase':
                return array('A-Z', 'uppercase');
            case 'alnum':
                return array('a-zA-Z0-9', 'alpha numeric');
            case 'digit':
                return array('0-9', 'digit');
            case 'symbol':
                return array('^a-zA-Z0-9', 'symbol');
            case 'null':
                return array('\0', 'null');
        }
        return array($desc, '');
    }

}
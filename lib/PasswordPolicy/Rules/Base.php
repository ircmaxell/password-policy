<?php

namespace PasswordPolicy\Rules;

abstract class Base implements \PasswordPolicy\Rule {

    protected $constraint = null;

    public function getMessage() {
        if ($this->constraint) {
            return $this->constraint->getMessage();
        }
        return '';
    }

    public function setConstraint(\PasswordPolicy\Constraint $constraint) {
        $this->constraint = $constraint;
    }

    public function toJavaScript() {
        return '{
            message: "Not Implemented",
            check: function(p) { return false; }
        }';
    }

    protected function testConstraint($num, $password) {
        if (empty($this->constraint)) {
            return (bool) $num;
        }
        return $this->constraint->check($num, $password);
    }

}
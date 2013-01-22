<?php

namespace PasswordPolicy;

interface Rule {

    public function getMessage();
    public function setConstraint(\PasswordPolicy\Constraint $constraint);
    public function test($password);
    public function toJavaScript();

}
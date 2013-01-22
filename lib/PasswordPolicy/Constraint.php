<?php

namespace PasswordPolicy;

interface Constraint {

    public function check($number);
    public function getMessage();
    public function toJavaScript();
}
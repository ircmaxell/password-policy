<?php

namespace PasswordPolicy\Rules;

class CharacterRange extends Regex {

    public function __construct($range, $textDescription) {
        $this->description = "Expecting %s $textDescription characters";
        $this->regex = '/[' . $range . ']/';
    }

}
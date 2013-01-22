<?php

namespace PasswordPolicy;

class Message {

    protected $result = true;
    protected $message = '';

    public function __construct($result, $text) {
        $this->result = (bool) $result;
        $this->message = $text;
    }

    public function getMessage() {
        return $this->message;
    }

    public function isFailed() {
        return !$this->result;
    }

    public function isSuccess() {
        return $this->result;
    }

}
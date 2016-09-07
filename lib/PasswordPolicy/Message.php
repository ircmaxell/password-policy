<?php

/*
 * The Password Policy for implementing Password Policies
 *
 * @author     Anthony Ferrara <ircmaxell@ircmaxell.com>
 * @copyright  2011 The Authors
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    Build @@version@@
 */
namespace PasswordPolicy;

class Message
{
    protected $result = true;
    protected $message = '';

    public function __construct($result, $text)
    {
        $this->result = (bool) $result;
        $this->message = $text;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function isFailed()
    {
        return !$this->result;
    }

    public function isSuccess()
    {
        return $this->result;
    }
}

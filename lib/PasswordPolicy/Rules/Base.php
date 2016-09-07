<?php

/*
 * The Password Policy for implementing Password Policies
 *
 * @author     Anthony Ferrara <ircmaxell@ircmaxell.com>
 * @copyright  2011 The Authors
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    Build @@version@@
 */
namespace PasswordPolicy\Rules;

abstract class Base implements \PasswordPolicy\Rule
{
    protected $constraint = null;

    public function getMessage()
    {
        if ($this->constraint) {
            return $this->constraint->getMessage();
        }

        return '';
    }

    public function setConstraint(\PasswordPolicy\Constraint $constraint)
    {
        $this->constraint = $constraint;
    }

    public function toJavaScript()
    {
        return '{
            message: "Not Implemented",
            check: function(p) { return false; }
        }';
    }

    protected function testConstraint($num, $password)
    {
        if (empty($this->constraint)) {
            return (bool) $num;
        }

        return $this->constraint->check($num, $password);
    }
}

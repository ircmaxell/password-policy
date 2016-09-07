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

use SecurityLib\Util;

class Size extends Base
{
    public function getMessage()
    {
        $constraint = parent::getMessage();

        return "Expecting a password length of $constraint characters";
    }

    public function test($password)
    {
        return $this->testConstraint(Util::safeStrlen($password), $password);
    }

    public function toJavaScript()
    {
        $ret = "{
            message: " . json_encode($this->getMessage()) . ",
            check: function(p) {
                return (" . $this->constraint->toJavaScript() . ")(p.length);
            }
        }";

        return $ret;
    }
}

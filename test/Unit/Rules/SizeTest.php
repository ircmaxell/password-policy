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

class SizeTest extends \PHPUnit_Framework_TestCase
{
    public function testNoConstraint()
    {
        $rule = new Size();
        $this->assertTrue($rule->test("abc"));
    }

    public function testNoConstraintFail()
    {
        $rule = new Size();
        $this->assertFalse($rule->test(""));
    }
}

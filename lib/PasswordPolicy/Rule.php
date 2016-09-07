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

interface Rule
{
    public function getMessage();
    public function setConstraint(\PasswordPolicy\Constraint $constraint);
    public function test($password);
    public function toJavaScript();
}

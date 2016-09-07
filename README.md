PasswordPolicy
==============

A tool for checking and creating password policies in PHP and JS.

## Installation

Use composer to setup an autoloader

    php composer.phar install

Require the composer autoload file:

    require_once 'vendor/autoload.php';

## Usage:

To use, first instantiate the core policy object:

    $policy = new \PasswordPolicy\Policy;

Then, add rules:

    $policy->contains('lowercase', $policy->atLeast(2));

### Supported rule helper methods are:

 * `contains($class, $constraint = null, $description = '')`: Checks to see if a password contains a class of chars
 
    Supported Short-Cut classes:

    * `letter` - `a-zA-Z`
    * `lowercase` - `a-z`
    * `uppercase` - `A-Z`
    * `digit` - `0-9`
    * `symbol` - `^a-zA-Z0-9` (in other words, non-alpha-numeric)
    * `null` - `\0`
    * `alnum` - `a-zA-Z0-9`

    The second param is a constraint (optional)

 * `length($constraint)`: Checks the length of the password matches a constraint

 * `endsWith($class, $description = '')`: Checks to see if the password ends with a character class.

 * `startsWith($class, $description = '')`: Checks to see if the password starts with a character class.

 * `notMatch($regex, $description)`: Checks if the password does not match a regex.

 * `match($regex, $description)`: Checks if the password matches the regex.

### Supported Constraints:

The policy also has short-cut helpers for creating constraints:

 * `atLeast($n)`: At least the param matches

    Equivalent to `between($n, PHP_INT_MAX)`

 * `atMost($n)`: At most the param matches

    Equivalent to `between(0, $n)`

 * `between($min, $max)`: Between $min and $max number of matches

 * `never()`: No matches
     
    Equivalent to `between(0, 0)`

## Testing the policy

Once you setup the policy, you can then test it in PHP using the `test($password)` method.

    $result = $policy->test($password);

The result return is a stdclass object with two members, result and messages.

 * `$result->result` - A boolean if the password is valid.

 * `$result->messages` - An array of messages

Each message is an object of two members:

 * `$message->result` - A boolean indicating if the rule passed

 * `$message->message` - A textual description of the rule

## Using JavaScript

Once you've built the policy, you can call `toJavaScript()` to generate a JS anonymous function for injecting into JS code.

    $js = $policy->toJavaScript();
    echo "var policy = $js;";

Then, the policy object in JS is basically a wrapper for `$policy->test($password)`, and behaves the same (same return values).

    var result = policy(password);
    if (!result.result) {
        /* Process Messages To Display Failure To User */
    }

One note for the JavaScript, any regular expressions that you write need to be deliminated by `/` and be valid JS regexes (no PREG specific functionality is allowed).


<?php

namespace PasswordPolicy;

class Policy {

    protected $rules = array();

    public function atLeast($n) {
        return new Constraints\Limit($n, PHP_INT_MAX);
    }

    public function atMost($n) {
        return new Constraints\Limit(0, $n);
    }

    public function between($min, $max) {
        return new Constraints\Limit($min, $max);
    }

    public function never() {
        return new Constraints\Limit(0, 0);
    }

    public function contains(
        $chars,
        Constraint $constraint = null,
        $description = ''
    ) {
        list($chars, $desc) = Rules\Regex::toCharClass($chars);
        if ($desc && !$description) {
            $description = $desc;
        }
        $rule = new Rules\CharacterRange($chars, $description);
        if ($constraint) {
            $rule->setConstraint($constraint);
        }
        $this->rules[] = $rule;
        return $this;
    }

    public function length(Constraint $constraint) {
        $rule = new Rules\Size;
        $rule->setConstraint($constraint);
        $this->rules[] = $rule;
        return $this;
    }

    public function endsWith($chars, $description = '') {
        list($chars, $desc) = Rules\Regex::toCharClass($chars);
        if ($desc && !$description) {
            $description = $desc;
        }
        $description = 'Ends with ' . $description;
        $rule = new Rules\Regex('/[' . $chars . ']$/', $description);
        $this->rules[] = $rule;
        return $this;
    }

    public function startsWith($chars, $description = '') {
        list($chars, $desc) = Rules\Regex::toCharClass($chars);
        if ($desc && !$description) {
            $description = $desc;
        }
        $description = 'Starts with ' . $description;
        $rule = new Rules\Regex('/^[' . $chars . ']/', $description);
        $this->rules[] = $rule;
        return $this;
    }

    public function notMatch($regex, $description) {
        $rule = new Rules\Regex($regex, $description);
        $rule->setConstraint($this->never());
        $this->rules[] = $rule;
        return $this;
    }

    public function match($regex, $description) {
        $rule = new Rules\Regex($regex, $description);
        $this->rules[] = $rule;
        return $this;
    }

    public function addRule(Rule $rule) {
        $this->rules[] = $rule;
    }

    public function toJavaScript() {
        $rules = array();
        foreach ($this->rules as $rule) {
            $rules[] = "\n" . $rule->toJavaScript();
        }
        $stub = "(function(p) {
            var rules = [" . implode(', ', $rules) . "
                ],
                ruleLen = rules.length,
                messages = [],
                result = true,
                tmp;
            for (var i = 0; i < ruleLen; i++) {
                tmp = rules[i].check(p);
                messages.push({success: tmp, message: rules[i].message});
                result = result && tmp;
            }
            return {
                result: result,
                messages: messages
            };
        })";
        return preg_replace('/\s\s+/', ' ', $stub);
    }

    public function test($password) {
        $messages = array();
        $result = true;
        foreach ($this->rules as $rule) {
            $tmp = $rule->test($password);
            $msg = new \StdClass;
            $msg->result = $tmp;
            $msg->message = $rule->getMessage();
            $messages[] = $msg;
            $result = $result && $tmp;
        }
        $return = new \StdClass;
        $return->result = $result;
        $return->messages = $messages;
        return $return;
    }

    public function getMessages($password) {
        $messages = array();
        foreach ($this->rules as $rule) {
            $message = $rule->getMessage($password);
            if (!$rule->test($password)) {
                $messages[] = array('failed', $message);
            } else {
                $messages[] = array('passed', $message);
            }
        }
        return $messages;
    }

}
<?php
class NumberValidator extends Validator {
    public function __construct(array $names) {
        $rules = [];
        $messages = [];
        foreach ($names as $name) {
            $rules[$name] = 'required|numeric|positive';
            $messages[$name] = [
                'required' => 'The '.$name.' is required.',
                'numeric' => 'The '.$name.' must be a number.',
                'positive' => 'The '.$name.' must be bigger than 0.'
            ];
        }
        $this->setRules($rules);
    }
}
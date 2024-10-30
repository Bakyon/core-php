<?php
class RoleValidator extends Validator {
    public function __construct() {
        $this->setRules([
            'role name' => 'required|text'
        ]);

        $this->setMessages([
            'role name' => [
                'required' => 'Role name is required',
                'text' => 'Role name can only contain alphabetic character and spaces and has at least 3 characters'
            ]
        ]);
    }

    protected function validateText($value, string $field) : bool
    {
        return (ctype_alpha(str_replace(' ', '', $value)) && strlen($value) >= 3 && strlen($value) <= 100);
    }
}
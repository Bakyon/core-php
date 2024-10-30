<?php
class LoginValidator extends Validator {
    public function __construct() {
        $this->setRules([
            'email' => 'required|email',
            'password' => 'required|password'
        ]);

        $this->setMessages([
            'email' => [
                'required' => 'Email is required',
                'email' => 'Please enter valid email'
            ],
            'password' => [
                'required' => 'Password is required',
                'password' => 'Please enter valid password'
            ]
        ]);
    }
}
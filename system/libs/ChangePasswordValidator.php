<?php
class ChangePasswordValidator extends Validator {
    public function __construct() {
        $this->setRules([
            'old_password' => 'required|password',
            'new_password' => 'required|password',
            'confirm_password' => 'required|samePassword'
        ]);

        $this->setMessages([
            'old_password' => [
                'required' => 'Old password is required',
                'password' => 'Please enter a valid password'
            ],
            'new_password' => [
                'required' => 'New password is required',
                'password' => 'Please enter a valid password'
            ],
            'confirm_password' => [
                'required' => 'Confirm password is required',
                'samePassword' => 'Passwords do not match'
            ]
        ]);
    }

    protected function validateSamePassword($value, $field)
    {
        return $value === $this->data['new_password'];
    }
}
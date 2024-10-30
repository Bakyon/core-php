<?php
class UserValidator extends Validator {
    private $dateFormat;
    public function __construct($dateFormat = 'Y-m-d') {
        $this->dateFormat = $dateFormat;

        $this->setRules([
            'email' => 'required|email',
            'password' => 'required|password',
            '2ndpassword' => 'required|samePassword',
            'gender' => 'required|gender',
            'birthdate' => 'required|date',
            'name' => 'name'
        ]);

        $this->setMessages([
            'email' => [
                'required' => 'Email is required',
                'email' => 'Please enter a valid email address',
            ],
            'password' => [
                'required' => 'Password is required',
                'password' => 'Please enter a valid password',
            ],
            '2ndpassword' => [
                'required' => 'Password is required',
                'samePassword' => 'Passwords do not match',
            ],
            'gender' => [
                'required' => 'Gender is required',
                'gender' => 'Please select a valid gender. 1 ~ Male, 2 ~ Female, 3 ~ Other',
            ],
            'birthdate' => [
                'required' => 'Birthdate is required',
                'date' => 'Please enter a valid birthdate',
            ],
            'name' => [
                'name' => 'Name is invalid',
            ]
        ]);
    }

    protected function validateDate($value, $field)
    {
        $dateTime = DateTime::createFromFormat($this->dateFormat, $value);

        // Check if the creation was successful and the formatted string matches the original
        return $dateTime && $dateTime->format($this->dateFormat) === $value;
    }
    protected function validateSamePassword($value, $field)
    {
        return $value === $this->data['password'];
    }
    protected function validateGender($value, $field)
    {
        return in_array($value, [1, 2, 3]);
    }
    protected function validateName($value, $field)
    {
        return ctype_alpha($value);
    }
}
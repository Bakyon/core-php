<?php
abstract class Validator
{
    protected array $rules = [];
    protected array $messages = [];
    protected array $errors = [];
    protected array $data = [];

    public function setRules(array $rules): void
    {
        $this->rules = $rules;
    }

    public function setMessages(array $messages): void
    {
        $this->messages = $messages;
    }

    public function validate(array $data): bool
    {
        $this->errors = [];
        $this->data = $data;

        foreach ($this->rules as $field => $rules) {
            $value = $data[$field] ?? null;
            $rulesArray = explode('|', $rules);

            foreach ($rulesArray as $rule) {
                $ruleMethod = "validate" . ucfirst($rule);

                if (method_exists($this, $ruleMethod)) {
                    if (!$this->$ruleMethod($value, $field)) {
                        $this->errors[$field][] = $this->messages[$field][$rule] ?? "$field is invalid.";
                    }
                }
            }
        }

        return empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    protected function validateRequired($value, string $field): bool
    {
        return !empty($value);
    }

    protected function validateEmail($value, string $field): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    protected function validateNumber($value, string $field): bool
    {
        return is_numeric($value);
    }

    protected function validatePositive($value, string $field): bool
    {
        return is_numeric($value) and $value > 0;
    }

    protected function validatePassword($value, string $field): bool
    {
        return (strlen($value) >= 3) && (strlen($value) <= 32) && ($this->allowedCharacters($value));
    }
    protected function allowedCharacters($value): bool
    {
        return ctype_alnum(str_replace(['#', '@', '-', '_', '$'], '0', $value));
    }
}

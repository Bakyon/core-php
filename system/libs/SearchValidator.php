<?php
class SearchValidator extends Validator {
    private $conditionList = [];
    public function __construct() {
        $this->setRules([
            'search' => 'text',
            'condition' => 'required|conditionList'
        ]);

        $this->setMessages([
            'search' => [],
            'condition' => [
                'required' => 'Search condition is required.',
                'conditionList' => 'Search condition must be chosen from the list.'
            ]
        ]);

        $this->conditionList = ['name', 'email', 'id'];
    }

    protected function validateConditionList($value, $field) {
        return in_array($value, $this->conditionList);
    }

    protected function validateText($value, $field) {
        return true;
    }
}
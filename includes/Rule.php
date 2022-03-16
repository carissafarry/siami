<?php

namespace app\includes;

//  Abstracted this class to avoid creating an instance of this model
abstract class Rule
{
    public Model $model;

    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    public array $errors = [];

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Define rule for validate request data
     *
     */
    abstract public function rules(): array;

    /**
     * Validate data based on the defined rule and return error message if it is invalid
     *
     */
    public function validate(): bool
    {
        foreach ($this->rules() as $attribute => $rules) {
            // Take the value from the Child Model properties that has been loaded in loadData()
            $value = $this->model->{$attribute};

            foreach ($rules as $rule) {
                $ruleName = $rule;

                //  Check if attribute is single data or an array
                if (!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }

                //  Check if loadData() called before the validate()
                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addError($attribute, self::RULE_REQUIRED);
                }

                //  Check if the email is valid
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($attribute, self::RULE_EMAIL);
                }

                //  Check if input data is less than rule of minimum
                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addError($attribute, self::RULE_MIN, $rule);
                }

                //  Check if input data is greater than rule of maximum
                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addError($attribute, self::RULE_MAX, $rule);
                }

                //  Check if "confirm password" data is match `with password
                if ($ruleName === self::RULE_MATCH && $value !== $this->model->{$rule['match']}) {
                    $this->addError($attribute, self::RULE_MATCH, $rule);
                }
            }
        }

        //  Return true if there is no error
        return empty($this->errors);
    }

    /**
     * Add list of errors if it finds input data not valid each request received
     *
     */
    public function addError(string $attribute, string $rule, $params = []): void
    {
        $message = $this->errorMessages()[$rule] ?? '';

        //  Replace error message with actual value of received request
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }

        $this->errors[$attribute][] = $message;
    }

    /**
     * Return error message of defined rules
     *
     */
    public function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This field must be valid email address',
            self::RULE_MIN => 'Min length of this field must be {min}',
            self::RULE_MAX => 'Max length of this field must be {max}',
            self::RULE_MATCH => 'This field must be the same as {match}',
        ];
    }

    /**
     * Check if attribute violates the rule
     *
     */
    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }

    /**
     * Return first error of certain attribute
     *
     */
    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }
}
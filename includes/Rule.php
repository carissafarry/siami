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
    public const RULE_UNIQUE = 'unique';
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
     * @return bool
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
                    $rule['match'] = $this->model->getLabel($rule['match']);
                    $this->addError($attribute, self::RULE_MATCH, $rule);
                }

                //  Check if data is unique in defined class, inside defined column
                if ($ruleName === self::RULE_UNIQUE) {
                    $className = $rule['class'];
                    $uniqueAttribute = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();

                    $query = App::$app->db->query(
                        "SELECT count(*) FROM $tableName WHERE $uniqueAttribute = :attr",
                        [':attr' => $value]
                    );
                    $row = oci_fetch_array($query, OCI_NUM);
                    if ((int)$row[0] > 0) {
//                        $this->addError($attribute, self::RULE_UNIQUE, ['field' => $attribute]);
                        $this->addError($attribute, self::RULE_UNIQUE, ['field' => $this->model->getLabel($attribute)] );
                    }
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
            self::RULE_UNIQUE => 'This {field} already used',
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
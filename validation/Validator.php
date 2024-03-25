<?php

namespace Validation;

class Validator implements BaseValidator

{

    public array $errors = [];
    public array $data = [];
    public array $fields = [];

    public function __construct()
    {
        $this->data = array_only($_REQUEST, $this->fields());
        $this->errors = array_fill_keys($this->fields(), []);
    }

    protected function clearErrors(): void
    {
        unset($_SESSION['errors']);
    }

    protected function checkErr($field): bool
    {

        return empty($this->errors[$field]);
    }


    protected function foundErrors(): bool
    {
        foreach ($this->errors as $field => $errors) {
            if (!empty($errors)) {
                addErrors($this->errors);
                return true;
            }
        }
        return false;
    }


    protected function newError(string $field, string $s): void
    {
        array_push($this->errors[$field], $s);
        addErrors($this->errors);
    }



    protected function exists(string $table, string $column, string $value, string $field, string $error = null)
    {
        if ($this->checkErr($field)) {
            if (!in_array($column, ["user_id", "username", "email", 'post_id'])) {
                array_push($this->errors[$field], "Invalid Column");
            } elseif ($table == "users") {
                if (!getUserByColumn($column, $value)) {
                    array_push($this->errors[$field], $error ??  "User does not exist");
                }
            } elseif ($table == "posts") {
                if (!getPostByColumn($column, $value)) {
                    array_push($this->errors[$field], $error ??  "Post does not exist");
                }
            }
        }
        return $this;
    }


    protected function required(string $field, string $error = null): static
    {
        if ($this->checkErr($field)) {
            if (strlen($this->data[$field]) == 0) {
                array_push($this->errors[$field], $error ?? ucwords(str_replace(["_", "-"], " ", $field)) . " is required");
            }
        }
        return $this;
    }

    protected function matches(string $field1, string $field2, string $error = null): static
    {
        if ($this->checkErr($field1) && $this->checkErr($field2)) {
            if ($this->checkErr($field1)) {
                if ($this->data[$field1] !== $this->data[$field2]) {
                    array_push($this->errors[$field1], $error);
                    array_push($this->errors[$field2], "");
                }
            }
        }
        return $this;
    }
    protected function different(string $field1, string $field2, string $error = null): static
    {
        if ($this->checkErr($field1) && $this->checkErr($field2)) {
            if ($this->data[$field1] === $this->data[$field2]) {
                if ($this->data[$field1] === $this->data[$field2]) {
                    array_push($this->errors[$field1], $error);
                    array_push($this->errors[$field2], "");
                }
            }
        }
        return $this;
    }
    protected function isEmail(string $field)
    {
        if ($this->checkErr($field)) {
            if (!filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
                array_push($this->errors[$field], "E-mail is not valid");
            }
        }
        return $this;
    }

    protected function checkPassword(string $field, string $saved_password = null, string $error = null): bool
    {
        if ($this->checkErr($field)) {
            if (!password_verify($this->data[$field], $saved_password)) {
                array_push($this->errors[$field], $error ?? "Incorrect Password.");
                return false;
            }
        }
        return true;
    }

    protected function minLength(string $field, int $l, string $error = null): static
    {
        if ($this->checkErr($field)) {
            if (strlen($this->data[$field]) < $l) {

                array_push($this->errors[$field], $error ?? ucwords(str_replace(["_", "-"], " ", $field)) . " must be at least $l characters");
            }
        }
        return $this;
    }


    protected function maxLength(string $field, int $l, string $error = null): static
    {
        if ($this->checkErr($field)) {
            if (strlen($this->data[$field] > $l)) {
                array_push($this->errors[$field], $error ?? ucwords(str_replace(["_", "-"], " ", $field)) . " must be less than $l characters");
            }
        }
        return $this;
    }

    protected function unique(string $column, string $field, array $ignore = [], string $error = null): static
    {
        if ($this->checkErr($field)) {
            if (verifyUnique($column, $this->data[$field], $ignore)) {
                return $this;
            } else {
                array_push($this->errors[$field], $error ?? ucwords(str_replace(["_", "-"], " ", $field)) . " is not unique");
            }
        }
        return $this;
    }

    // protected function belongs(string $user_id, string $table, string $column, string $value)
    // {
    //     if ($this->checkErr($table)) {
    //         if (!verifyRowBelongs($user_id, $table, $column, $value)) {
    //             array_push($this->errors[$table], $error ?? ucwords(str_replace(["_", "-"], " ", $table)) . " does not belogn to this User.");
    //         }
    //     }
    //     return $this;
    // }
    protected function imgType(string $field, string $ext, string $error = null): static
    {

        if ($this->checkErr($field)) {
            if (!(in_array($ext, ["jpeg", "jpg", "png"]))) {
                array_push($this->errors[$field], $error ?? "Extension not correct, please choose a JPEG or PNG file.");
            }
        }
        return $this;
    }
    protected function size(string $field, $size, string $error = null): void
    {
        if ($this->checkErr($field)) {
            if ($size > 10485760) {
                array_push($this->errors[$field], $error ?? "File size must be less than 10 MB");
            }
        }
    }

    public function validate(): array
    {
        return [];
    }
    protected function fields(): array
    {
        return [];
    }
    protected function toValidate(): array
    {
        return [];
    }
}

<?php

namespace Validation;

use Models\Post;
use Models\User;

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


    protected function foundErrors(): void
    {
        foreach ($this->errors as $field => $errors) {
            if (!empty($errors)) {
                self::addErrors($this->errors);
                redirectBack();
            }
        }
    }


    protected function exists(string $table, string $column, string $value, string $field, string $error = null): static
    {
        if ($this->checkErr($field)) {
            if (!in_array($column, ["user_id", "username", "email", 'post_id'])) {
                array_push($this->errors[$field], "Invalid Column");
            } elseif ($table == "users") {

                if (!User::select([$column => $value])) {
                    array_push($this->errors[$field], $error ??  "User does not exist");
                }
            } elseif ($table == "posts") {
                if (!Post::select([$column => $value])) {
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
    protected function isEmail(string $field): static
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
            if (strlen($this->data[$field]) > $l) {
                array_push($this->errors[$field], $error ?? ucwords(str_replace(["_", "-"], " ", $field)) . " must be less than $l characters");
            }
        }
        return $this;
    }

    protected function unique(string $column, string $field, array $ignore = [], string $error = null): static
    {
        if ($this->checkErr($field)) {
            if (self::verifyUnique($column, $this->data[$field], $ignore)) {
                return $this;
            } else {
                array_push($this->errors[$field], $error ?? ucwords(str_replace(["_", "-"], " ", $field)) . " is not unique");
            }
        }
        return $this;
    }

    protected function imgType(string $field, string $ext, string $error = null): static
    {

        if ($this->checkErr($field)) {
            if (!(in_array($ext, ["jpeg", "jpg", "png"]))) {
                array_push($this->errors[$field], $error ?? "Extension not correct, please choose a JPEG or PNG file.");
            }
        }
        return $this;
    }
    protected function size(string $field, $size, string $error = null): static
    {
        if ($this->checkErr($field)) {
            if ($size > 10485760) {
                array_push($this->errors[$field], $error ?? "File size must be less than 10 MB");
            }
        }
        return $this;
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
    public function saveInput(): void
    {
        foreach ($this->errors as $field => $value) {
            unset($_SESSION["input"][$field]);
            if ($this->checkErr($field)) {
                $_SESSION["input"][$field] = $_REQUEST[$field];
            }
        }
    }

    public function clearInput(): void
    {
        foreach ($this->errors as $field => $value) {
            unset($_SESSION["input"][$field]);
        }
    }

    public static function addErrors(array $errors): void
    {
        $_SESSION["errors"] = $errors;
    }

    public static function addMessages(array $messages): void
    {
        $_SESSION['messages'] = $messages;
    }

    private static function verifyUnique($column, string $value, array $ignore = []): bool
    {
        if (empty($ignore)) {
            return !User::select([$column => $value]);
        } else {
            $inQuery = implode(',', array_fill(0, count($ignore), '?'));
            return empty(User::query("SELECT * FROM users WHERE $column = ? AND  ID NOT IN ($inQuery)", array_merge([$value], $ignore)));
        }
    }
}

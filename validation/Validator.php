<?php

namespace Validation;

class Validator
{

    public $errors = [];
    public $data = [];

    public function clearErrors()
    {
        unset($_SESSION['errors']);
    }


    public function setFields(array $data)
    {
        foreach ($data as $field => $value) {
            $this->addField($field, $value);
        }
    }


    private function addField(string $field, $value)
    {

        $this->errors[$field] = [];
        $this->data[$field] = $value;
        return $this;
    }

    public function checkErr($field)
    {

        return empty($this->errors[$field]);
    }


    public function foundErrors()
    {
        foreach ($this->errors as $field => $errors) {
            if (!empty($errors)) {
                addErrors($this->errors);
                return true;
            }
        }
        return false;
    }


    public function newError(string $field, string $s)
    {
        array_push($this->errors[$field], $s);
        addErrors($this->errors);
    }



    public function exists(string $table, string $column, string $value, string $field, string $error = null)
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


    public function required(string $field, string $error = null)
    {
        if ($this->checkErr($field)) {
            if (strlen($this->data[$field]) == 0) {
                array_push($this->errors[$field], $error ?? ucwords(str_replace(["_", "-"], " ", $field)) . " is required");
            }
        }
        return $this;
    }

    public function matches(string $field1, string $field2, string $error = null)
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
    public function different(string $field1, string $field2, string $error = null)
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

    public function isFullname(string $field)
    {
        if ($this->checkErr($field)) {
            if (!preg_match('/^[a-zA-Z ]+$/', $this->data[$field])) {
                array_push($this->errors[$field], "Full Name is not valid");
            }
        }
        return $this;
    }

    public function isEmail(string $field)
    {
        if ($this->checkErr($field)) {
            if (!filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
                array_push($this->errors[$field], "E-mail is not valid");
            }
        }
        return $this;
    }

    public function checkPassword(string $field, string $saved_password = null, string $error = null)
    {
        if ($this->checkErr($field)) {
            if (!password_verify($this->data[$field], $saved_password)) {
                array_push($this->errors[$field], $error ?? "Incorrect Password.");
                return false;
            }
        }
        return true;
    }

    public function minLength(string $field, int $l, string $error = null)
    {
        if ($this->checkErr($field)) {
            if (strlen($this->data[$field]) < $l) {

                array_push($this->errors[$field], $error ?? ucwords(str_replace(["_", "-"], " ", $field)) . " must be at least $l characters");
            }
        }
        return $this;
    }


    public function maxLength(string $field, int $l, string $error = null)
    {
        if ($this->checkErr($field)) {
            if (strlen($this->data[$field] > $l)) {
                array_push($this->errors[$field], $error ?? ucwords(str_replace(["_", "-"], " ", $field)) . " must be less than $l characters");
            }
        }
        return $this;
    }

    public function unique(string $column, string $field, array $ignore = [], string $error = null,)
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

    // public function belongs(string $user_id, string $table, string $column, string $value)
    // {
    //     if ($this->checkErr($table)) {
    //         if (!verifyRowBelongs($user_id, $table, $column, $value)) {
    //             array_push($this->errors[$table], $error ?? ucwords(str_replace(["_", "-"], " ", $table)) . " does not belogn to this User.");
    //         }
    //     }
    //     return $this;
    // }
    public function imgType(string $field, string $ext, string $error = null)
    {

        if ($this->checkErr($field)) {
            if (!(in_array($ext, ["jpeg", "jpg", "png"]))) {
                array_push($this->errors[$field], $error ?? "Extension not correct, please choose a JPEG or PNG file.");
            }
        }
        return $this;
    }
    public function size(string $field, $size, string $error = null)
    {
        if ($this->checkErr($field)) {
            if ($size > 10485760) {
                array_push($this->errors[$field], $error ?? "File size must be less than 10 MB");
            }
        }
    }
}

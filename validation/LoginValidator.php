<?php

namespace Validation;

class LoginValidator extends Validator
{

    public function validate(): array
    {
        $this->clearErrors();


        array_func($this->toValidate(), $this->fields());

        if ($this->foundErrors()) {
            $this->saveField();
            redirectToAuth('login');
        }


        $user = getUserByUsername($this->data["username"]);

        $this->exists("users", "username", $this->data["username"], "username", "User does not exist")
            ->checkPassword("password", $user['password']);

        if ($this->foundErrors()) {
            $this->saveField();
            redirectToAuth('login');
        }
        return $this->data;
    }

    private function saveField()
    {
        foreach ($this->errors as $field => $value) {
            unset($_SESSION["input"][$field]);
            if ($this->checkErr($field)) {
                $_SESSION["input"][$field] = $this->data[$field];
            }
        }
    }

    public function toValidate(): array
    {
        return
            [
                "username" => $this->required("username"),
                "password" => $this->required("password")->minLength("password", 8),
            ];
    }


    public function fields(): array
    {
        return
            [
                'username',
                'password',
            ];
    }
}

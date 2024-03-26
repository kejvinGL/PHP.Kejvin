<?php

namespace Validation;

class LoginValidator extends Validator
{

    public function validate(): array
    {
        $this->clearErrors();


        array_func($this->toValidate(), $this->fields());

        $this->saveInput();
        $this->foundErrors();


        $user = getUserByUsername($this->data["username"]);
        $this->exists("users", "username", $this->data["username"], "username", "User does not exist")
            ->checkPassword("password", $user['password']);

        $this->saveInput();

        $this->foundErrors();

        return $this->data;
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

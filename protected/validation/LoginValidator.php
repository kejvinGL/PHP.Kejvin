<?php

namespace Validation;

use Models\User;

class LoginValidator extends Validator
{

    public function validate(): array
    {
        $this->clearErrors();


        array_func($this->toValidate(), $this->fields());

        $this->saveInput();
        $this->foundErrors();

        $user = User::select(['username' => $this->data['username']])[0];
        $this->exists("users", "username", $this->data["username"], "username", "User does not exist")
            ->checkPassword("password", $user['password']);

        $this->saveInput();

        $this->foundErrors();

        $this->clearInput();
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

<?php

namespace Validation;

use Models\User;

class DeleteUserValidator extends Validator
{

    public function validate(?array $user = []): array
    {
        $this->clearErrors();

        $this->data += [
            "user_id" => $user["ID"],
            "saved_password" => User::select(["ID"=> $_SESSION["user_id"]])[0]["password"]
        ];


        array_func($this->toValidate(), $this->fields());

        // IF ERRORS WHERE FOUND:
        $this->foundErrors();


        return $this->data;
    }


    protected function toValidate(): array
    {
        return
            [
                "password" => $this->exists("users", "user_id", $this->data["user_id"], "password", "delete")
                    ->required("password", "Your Password must be entered.")->checkPassword("password", $this->data['saved_password']),
            ];
    }


    protected function fields(): array
    {
        return [
            "password"
        ];
    }
}

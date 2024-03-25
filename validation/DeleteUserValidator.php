<?php

namespace Validation;

class DeleteUserValidator extends Validator
{

    public function validate(array $user = null): array
    {
        $this->clearErrors();
        $this->data += ['user_id' => $user["user_id"], 'saved_password' => getCurrentUser()["password"]];

        array_func($this->toValidate($user), $this->fields());
        // IF ERRORS WHERE FOUND:
        if ($this->foundErrors()) {
            redirectToAdmin("users");
        }
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

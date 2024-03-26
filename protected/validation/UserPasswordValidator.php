<?php

namespace Validation;

class UserPasswordValidator extends Validator
{

    public function validate(string $old = null): array
    {
        $this->clearErrors();

        array_func($this->toValidate($old), $this->fields());


        $this->checkPassword("current_password", $old, "Incorrect Current Password");
        // IF ERRORS WHERE FOUND:
        $this->foundErrors();

        return $this->data;
    }


    function toValidate(string $old = null): array
    {
        return [
            'current_password' =>  $this->required("current_password", "Current password must be entered."),
            'new_password' => $this->required("new_password")
                ->required("repeat_password")
                ->minLength("new_password", 8)
                ->matches("new_password", "repeat_password", "New Passwords must match."),
            'repeat_password' => $this->different("new_password", "current_password", "New Password must be different.")
                ->checkPassword("current_password", $old, "Incorrect Current Password")
        ];
    }


    function fields(): array
    {
        return [
            'current_password',
            'new_password',
            'repeat_password'
        ];
    }
}

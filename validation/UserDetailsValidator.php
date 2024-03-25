<?php

namespace Validation;

class UserDetailsValidator extends Validator
{

    public function validate(int $user_id = null): array
    {
        $this->clearErrors();

        $this->exists("users", "user_id", $user_id, "edit", "User does not exist");

        array_func($this->toValidate($user_id), $this->fields());

        if ($this->foundErrors()) {
            if (strpos($_SERVER["HTTP_REFERER"], "profile")) {
                redirectToProfile();
            } else {
                redirectToAdmin('users');
            }
        }

        return $this->data;
    }

    public function toValidate(int $user_id = null): array
    {
        return [
            "username" =>  $this->minLength("new_username", 5)
                ->unique("username", "new_username", [$user_id], "Username is already in use."),
            'email' => $this->isEmail("new_email")
                ->unique("email", "new_email", [$user_id], "Email is already in use.")
        ];
    }

    public function fields(): array
    {
        return [
            "new_username",
            "new_email"
        ];
    }
}

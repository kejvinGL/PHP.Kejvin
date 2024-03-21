<?php

namespace Validation;

class UserDetailsValidator extends Validator
{

    public function validate($data)
    {
        $this->clearErrors();
        $this->setFields($data);

        $this->exists("users", "user_id", $data["user_id"], "edit", "User does not exist")
            ->minLength("new_username", 5)->isEmail("new_email")
            ->unique("username", "new_username", [$data["user_id"]], "Username is already in use.")
            ->unique("email", "new_email", [$data["user_id"]], "Email is already in use.");

        if ($this->foundErrors()) {
            redirectToAdmin('users');
        }

        return $data;
    }
}

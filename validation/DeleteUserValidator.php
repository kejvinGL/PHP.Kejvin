<?php

namespace Validation;

class deleteUserValidator extends Validator
{


    public function validate($data)
    {
        $this->clearErrors();
        $data = $this->setFields($data);
        $user = getCurrentUser();
        $saved_password = $user['password'];
        $this->exists("user_id", $this->data["user_id"], "delete")
            ->required("password", "Your current password must be entered.")->checkPassword("password", $saved_password);

        if ($this->foundErrors()) {
            redirectToAdmin("users");
        }
    }
}
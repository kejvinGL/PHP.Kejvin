<?php

namespace Validation;

class LoginValidator extends Validator
{

    public function validate($data, string $options = "")
    {
        $this->clearErrors();
        $data = $this->setFields($data);
        $this->required("username");

        $this->required("password")->minLength("password", 8);


        $user = getUserByUsername($this->data["username"]);

        $this->exists("users", "username", $this->data["username"], "username", "User does not exist")->checkPassword("password", $user['password']);

        if ($this->foundErrors()) {
            foreach ($this->errors as $field => $value) {
                unset($_SESSION["input"][$field]);
                if ($this->checkErr($field)) {
                    $_SESSION["input"][$field] = $this->data[$field];
                }
            }
            redirectToAuth('login');
        }
        return $this->data;
    }
}

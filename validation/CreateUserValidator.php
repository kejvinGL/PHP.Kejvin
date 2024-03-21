<?php

namespace Validation;

class CreateUserValidator extends Validator
{
    public function validate($data, string $options = "")
    {
        $this->clearErrors();
        $this->setFields($data);
        //CHECK FULLNAME
        $this->required($options . "fullname")->isFullname($options . "fullname");

        //CHECK PASSWORD
        $this->required($options . "password")->minLength($options . "password", 8);

        //CHECK USERNAME
        $this->required($options . "username")->minLength($options . "username", 5)->unique("username", $options . "username");

        //CHECK EMAIL
        $this->required($options . "email")->isEmail($options . "email")->unique("email", $options . "email");

        // IF ERRORS WHERE FOUND:
        if ($this->foundErrors()) {
            foreach ($this->errors as $field => $value) {
                unset($_SESSION["input"][$field]);
                if ($this->checkErr($field)) {
                    $_SESSION["input"][$field] = $data[$field];
                }
            }
            redirectToAuth("register");
        }

        return $data;
    }




    // public function toValidate($field): array | false
    // {
    //     return [
    //         'fullname' => ["->required('$field')->isFullname('$field')"],
    //         'username' => ['minLength(5)', "unique('username', '$field')"],
    //         'email' => ["required('$field')", "isEmail('$field')", "unique('email', '$field')"],
    //         'password' => ["required('$field')", "minLength('$field' , 8)"]

    //     ];
    // }
}

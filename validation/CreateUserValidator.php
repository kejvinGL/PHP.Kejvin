<?php

namespace Validation;

class CreateUserValidator extends Validator
{
    private string $options;

    public function __construct(string $options = "")
    {
        $this->options = $options;
        $this->data = array_only($_REQUEST, $this->fields($options));
        $this->errors = array_fill_keys($this->fields($options), []);
    }


    public function validate(): array
    {

        $this->clearErrors();

        array_func($this->toValidate(), $this->fields($this->options));

        $this->saveInput();

        // IF ERRORS WHERE FOUND:
        $this->foundErrors();

        return $this->data;
    }


    public function toValidate(): array
    {
        return
            [
                "$this->options .fullname" => $this->required($this->options . "fullname"),
                "$this->options .email" => $this->required($this->options . "email")->isEmail($this->options . "email")->unique("email", $this->options . "email"),
                "$this->options .password" => $this->required($this->options . "password")->minLength($this->options . "password", 8),
                "$this->options .username" => $this->required($this->options . "username")->minLength($this->options . "username", 5)->unique("username", $this->options . "username"),
            ];
    }


    public function fields(string $options = ""): array
    {
        return
            [
                $options . 'fullname',
                $options . 'username',
                $options . 'email',
                $options . 'password',
            ];
    }
}

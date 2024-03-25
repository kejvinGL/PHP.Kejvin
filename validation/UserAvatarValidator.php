<?php

namespace Validation;

class UserAvatarValidator extends Validator
{

    public function validate(): array
    {
        $this->clearErrors();

        $file_ext = strtolower(pathinfo(basename($_FILES["avatar"]["name"]), PATHINFO_EXTENSION));
        $file_size = $_FILES['avatar']['size'];

        $this->data += ["ext" => $file_ext, "size" => $file_size];

        array_func($this->toValidate(), $this->fields());


        // IF ERRORS WHERE FOUND:
        if ($this->foundErrors()) {
            redirectToProfile();
        }

        return $this->data;
    }


    function toValidate(): array
    {
        return [
            'avatar' =>  $this->imgType("avatar", $this->data["ext"])->size("avatar", $this->data["size"])
        ];
    }
    function fields(): array
    {
        return [
            "avatar"
        ];
    }
}

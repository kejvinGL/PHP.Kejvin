<?php

namespace Validation;

class CreatePostValidator extends Validator
{
    public function validate(): array
    {
        $this->clearErrors();

        array_func($this->toValidate(), $this->fields());

        $this->foundErrors();

        redirectBack();

        return $this->data;
    }


    public function toValidate(): array
    {
        return [
            'title' => $this->required("title", "Post title cannot be empty"),
            'body' => $this->required("body", "Post body cannot be empty")
        ];
    }


    public function fields(): array
    {
        return [
            "title",
            "body"
        ];
    }
}

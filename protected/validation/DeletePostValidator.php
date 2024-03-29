<?php

namespace Validation;

use Models\Post;
use Models\User;

class DeletePostValidator extends Validator
{

    public function destroy($id)
    {
        $this->clearErrors();
        array_func($this->toValidate($id), $this->fields());


        $this->foundErrors();

        $this->data = Post::select(["ID" => $id])[0];

        if (User::getCurrentRole() === 1 && $_SESSION["user_id"] !== $this->data["user_id"]) {
            http_response_code(400);
            $this->errors["post_id"] += ["Not authorised to delete Post"];
        }

        $this->foundErrors();

        return $this->data;
    }

    function toValidate($post_id = null): array
    {
        return [
            'post_id' => $this->exists("posts", "post_id", $post_id, "post_id")
        ];
    }
    function fields(): array
    {
        return [
            "post_id"
        ];
    }
}

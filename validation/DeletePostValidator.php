<?php

namespace Validation;

class DeletePostValidator extends Validator
{

    public function destroy($id)
    {
        $this->clearErrors();
        array_func($this->toValidate($id), $this->fields());
        if ($this->foundErrors()) {
            redirectToHome();
        }
        $this->data = getPostByPostID($id);

        if (getCurrentUserRole() === 1 && $_SESSION["user_id"] !== $this->data["user_id"]) {
            http_response_code(400);
            array_push($this->errors["post_id"], "Not authorised to delete Post");
        }

        if ($this->foundErrors()) {
            redirectToHome();
        }


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

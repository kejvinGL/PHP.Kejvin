<?php

namespace Validation;

class PostValidator extends Validator
{
    public function store($data)
    {
        $this->clearErrors();
        $this->setFields($data);


        $this->required("title", "Post title cannot be empty")->required("body", "Post body cannot be empty");


        if ($this->foundErrors()) {
            redirectToHome();
        }


        return $data;
    }
    public function destroy($data)
    {
        $this->clearErrors();
        $this->setFields($data);
        $this->exists("posts", "post_id", $data["post_id"], "post_id");
        if ($this->foundErrors()) {
            redirectToHome();
        }
        $data = getPostByPostID($data["post_id"]);
        if (getCurrentUserRole() === 1 && $_SESSION["user_id"] !== $data["user_id"]) {
            http_response_code(400);
            array_push($this->errors["post_id"], "Not authorised to delete Post");
        }

        if ($this->foundErrors()) {
            redirectToHome();
        }


        return $data;
    }
}

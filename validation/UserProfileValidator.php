<?php

namespace Validation;

class UserProfileValidator extends Validator
{

    public function avatar($file)
    {
        $this->clearErrors();
        $this->setFields($file);
        $file_ext = strtolower(pathinfo(basename($file["avatar"]["name"]), PATHINFO_EXTENSION));
        $file_size = $_FILES['avatar']['size'];

        $this->imgType("avatar", $file_ext);

        $this->size("avatar", $file_size);


        if ($this->foundErrors()) {
            redirectToProfile();
        }

        return array_merge($file, ["file_ext" => $file_ext, "file_size" => $file_size]);
    }


    public function password($data)
    {
        $this->clearErrors();
        $this->setFields($data);

        $this->required("current_password", "Current password must be entered.")
            ->required("new_password")
            ->required("repeat_password")
            ->minLength("new_password", 8)
            ->matches("new_password", "repeat_password", "New Passwords must match.")
            ->different("new_password", "current_password", "New Password must be different.");

        $user = getCurrentUser();
        $old_password = $user['password'];
        $this->checkPassword("current_password", $old_password, "Incorrect Current Password");

        if ($this->foundErrors()) {
            redirectToProfile();
        }
        return $data;
    }
}

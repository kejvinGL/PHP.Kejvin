<?php

namespace Models;

class User extends Model implements BaseModel
{
    protected static string $table = "users";
    protected static array $fields = ['role_id',  'fullname', 'email', 'username', 'password', "last_login"];



    public static function getUsername($id)
    {
        return User::select(['ID' => $id])[0]["username"];
    }


    public static function getLastLogin($id)
    {
        return User::select(['ID' => $id])[0]["last_login"];
    }
    public static function getAvatar(int $id): array|null
    {

        return Media::select(["user_id" => $id, "type" => "avatar"])[0];
    }
    public static function getCurrentAvatar()
    {
        $user_id = $_SESSION['user_id'];
        $avatar = Media::select(["user_id" => $user_id, "type" => "avatar"])[0];
        return !empty($avatar) ? "assets/media/" . $avatar["path"] : "assets/media/default/default.svg";
    }
    public static function getAvatarPath(int $id): string
    {

        $avatar = Media::select(["user_id" => $id, "type" => "avatar"]);
        return $avatar ? "assets/media/" . $avatar[0]["path"] : "assets/media/default/default.svg";
    }

    public static function hasAvatar(int $id): bool
    {
        return !empty(Media::select(["user_id" => $id, "type" => "avatar"]));
    }


    public static function getCurrentRole(): int | null
    {
        $user_id = $_SESSION['user_id'] ?? null;
        return User::select(['ID' => $user_id])[0]["role_id"];
    }

    public static function getRole(int $id): int
    {
        return User::select(['ID' => $id])[0]["role_id"];
    }


    public static function totalClients(): int
    {

        return count(User::select(["role_id" => 1]));
    }


    public static function totalAdmins(): int
    {
        return count(User::select(["role_id" => 0]));
    }


    public static function setTheme(): bool
    {
        $mode = $_SESSION["darkmode"];
        $username = $_SESSION["username"];
        return User::update(['darkmode' => $mode], ['username' => $username]);
    }

}

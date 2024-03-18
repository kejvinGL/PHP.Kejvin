<?php

function dd($v): void
{
    echo "<pre>";
    var_dump($v);
    echo "</pre>";
    die();
}


/**
 *
 *      CREATE
 *
 */


/**
 * Creates a new user with the role CLIENT using the given information.
 *
 * @param string $fullname The full name of the client.
 * @param string $username The username of the client.
 * @param string $email The email address of the client.
 * @param string $password The password of the client.
 * @return bool|null Returns the result of the query, or null if the query fails.
 */


function
createUser(int $role, string $fullname, string $username, string $email, string $password): bool|null
{
    require "db.php";
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (role_id, fullname, email, username, password) VALUES (?, ?, ?, ?, ?)");
    return $stmt->execute([$role, $fullname, $email, $username, $hashed_password]);
}

/**
 *
 *      DELETE
 *
 */


/**
 * Deletes a user from the system.
 *
 * @param int $id The ID of the user to be deleted.
 * @return bool Returns true if the user is successfully deleted, false otherwise.
 */
function deleteUser(int $id): bool
{
    require "db.php";
    //Delete Media
    if (getUserByID($id) == null) {
        return false;
    }

    $stmt = $pdo->prepare("DELETE FROM media WHERE user_id = ?");
    $stmt->execute([$id]);
    $folderPath = basePath("/assets/media/") . $id;
    if (is_dir($folderPath)) {
        array_map('unlink', glob($folderPath . '/*'));
        rmdir($folderPath);
    }
    //Delete Posts
    $stmt = $pdo->prepare("DELETE FROM posts WHERE user_id = ?");
    $stmt->execute([$id]);
    //Delete User
    $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = ?");
    return $stmt->execute([$id]);
}


/**
 * Deletes the avatar of a user.
 *
 * @param int $id The ID of the user.
 * @return bool Returns true if the avatar is successfully deleted, false otherwise.
 */
function deleteUserAvatar(int $id): bool
{
    require "db.php";
    $stmt = $pdo->prepare("DELETE FROM media WHERE user_id = ? AND type='avatar'");
    return $stmt->execute([$id]);
}


/**
 *
 *  GETTERS
 *
 */

/**
 * Retrieves the current user.
 *
 * @return array|null The current user as an array, or null if no user is logged in.
 */
function getCurrentUser(): array | bool
{
    require "db.php";
    $username = $_SESSION['username'] ?? "null";
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


/**
 * Retrieves a user by their ID.
 *
 * @param int $id The ID of the user to retrieve.
 * @return array|null The user data if found, or null if not found.
 */
function getUserByID(int $id): array|false
{
    require "db.php";
    $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


/**
 * Retrieves a user by their username.
 *
 * @param string $username The username of the user to retrieve.
 * @return array|null An array containing the user's information if found, or null if not found.
 */
function getUserByUsername(string $username): array|false
{
    require "db.php";
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


/**
 * Retrieves a user from the database based on their email address.
 *
 * @param string $email The email of the user to retrieve.
 * @return array|null An array containing the user's information if found, or null if not found.
 */
function getUserByEmail(string $email): array|false
{
    require "db.php";
    require "db.php";
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


/**
 * Checks if a user is logged in.
 *
 * @return void Returns true if the user is logged in, false otherwise.
 */
function isLoggedIn(): void
{
    if (isset($_SESSION['user_id']) && getCurrentUser()) {
        if ($_SERVER['REQUEST_URI'] == '/login' || $_SERVER['REQUEST_URI'] == '/register') {
            getCurrentUserRole() === 0 ? redirectToAdmin('overall') : redirectToHome();
            exit;
        }
    } else {
        if ($_SERVER['REQUEST_URI'] != '/login' && $_SERVER['REQUEST_URI'] != '/register') {
            redirectToAuth('login');
            exit;
        }
    }
}


/**
 * Checks if the user is an admin.
 *
 * @return void Redirects user to /Home if user is not an Admin.
 */
function isAdmin(): void
{
    if (getCurrentUserRole() !== 0) {
        session_unset();
        redirectToAuth('login');
    }
}


/**
 * Checks if the user is a client.
 *
 * @return void Redirects user to /Home if user is not a Client.
 */
function isClient(): void
{
    if (getCurrentUserRole() !== 1) {
        redirectToAuth('login');
    }
}


function getUserUsername($id)
{
    $user = getUserByID($id);
    return $user["username"];
}
function getUserLastLogin($id)
{
    $user = getUserByID($id);
    return $user["last_login"];
}


/**
 * Retrieves the avatar of the current user.
 *
 * @return string|null Returns the PATH of the user's avatar, or the PATH of the default avatar if no avatar was found.
 */
function getCurrentAvatar(): string|null
{
    require "db.php";
    $user_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare("SELECT * FROM media WHERE user_id = ? AND type='avatar'");
    $stmt->execute([$user_id]);
    $path = $stmt->fetchColumn();
    return $path ? "assets/media/" . $path : "assets/media/default/default.svg";
}


/**
 * Checks if a user has an avatar.
 *
 * @param int $id The ID of the user.
 * @return bool Returns true if the user's avatar exists, or false if the user does not have an avatar.
 */
function hasUserAvatar(int $id): bool
{
    require "db.php";
    $stmt = $pdo->prepare("SELECT * FROM media WHERE user_id = ? AND type='avatar'");
    $stmt->execute([$id]);
    return $stmt->rowCount();
}


/**
 * Retrieves the file path of the user's avatar based on their ID.
 *
 * @param int $id The ID of the user.
 * @return string The PATH of the user's avatar.
 */
function getUserAvatarPath(int $id): string
{
    require "db.php";
    $stmt = $pdo->prepare("SELECT * FROM media WHERE user_id = ? AND type='avatar'");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    return $row ? "assets/media/" . $row["path"] : "assets/media/default/default.svg";
}


/**
 * Retrieves the avatar of a user based on their ID.
 *
 * @param int $id The ID of the user.
 * @return array|null The user's avatar as an array, or null if the user does not have an avatar.
 */
function getUserAvatar(int $id): array|null
{
    require "db.php";
    $stmt = $pdo->prepare("SELECT * FROM media WHERE user_id = ? AND type='avatar'");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


/**
 * Retrieves the current user's role.
 *
 * @return int The current user's role as an integer
 * (0 - admin, 1 - client )
 */
function getCurrentUserRole(): int | null
{
    require "db.php";
    $user_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare("SELECT role_id FROM users where user_id=$user_id");
    $stmt->execute();
    return $stmt->fetchColumn();
}


/**
 * Retrieves the role of a user based on their ID.
 *
 * @param int $id The ID of the user.
 * @return int The role of the user.
 */
function getUserRole(int $id): int
{
    require "db.php";
    $user = getUserByID($id);
    return $user['role_id'];
}


/**
 * Returns the total number of clients.
 *
 * @return int The total number of clients.
 */
function totalClients(): int
{
    require "db.php";
    $stmt = $pdo->prepare("SELECT * FROM users WHERE role_id = 1");
    $stmt->execute();
    return $stmt->rowCount();
}


/**
 * Returns the total number of admins.
 *
 * @return int The total number of admins.
 */
function totalAdmins(): int
{
    require "db.php";
    $stmt = $pdo->prepare("SELECT * FROM users WHERE role_id = 0");
    $stmt->execute();
    return $stmt->rowCount();
}

/**
 * Retrieves a list of clients from the database.
 *
 * @return mysqli_result The result set containing the clients.
 */
function getClients(): array
{
    require "db.php";
    $stmt = $pdo->prepare("SELECT * FROM users WHERE role_id = 1");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


/**
 * Retrieves the list of users from the database.
 *
 * @return array The result set containing the users.
 */

function getUsers(): array|null
{
    require "db.php";
    $stmt = $pdo->prepare("SELECT * FROM users;");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


/**
 * Checks if a username is unique in the system.
 *
 * @param string $username The username to be checked.
 * @return bool Returns true if the username is unique, false otherwise.
 */
function verifyUsernameUnique(string $username, array  $ignore = []): bool
{
    require "db.php";
    if (empty($ignore)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
    } else {
        $inQuery = implode(',', array_fill(0, count($ignore), '?'));
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND user_id NOT IN ($inQuery)");
        $params = array_merge([$username], $ignore);
        $stmt->execute($params);
    }
    return $stmt->rowCount() == 0;
}


/**
 * Checks if the given email is unique in the system.
 *
 * @param string $email The email to be checked.
 * @param array $ignore An array of email addresses to ignore during the check.
 * @return bool Returns true if the email is unique, false otherwise.
 */
function verifyEmailUnique(string $email, array $ignore = []): bool
{
    require "db.php";
    if (empty($ignore)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
    } else {
        $inQuery = implode(',', array_fill(0, count($ignore), '?'));
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND user_id NOT IN ($inQuery)");
        $params = array_merge([$email], $ignore);
        $stmt->execute($params);
    }
    return $stmt->rowCount() == 0;
}


/**
 *
 *
 * SETTERS
 *
 */


function setUserSession($user): void
{
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['darkmode'] = $user['darkmode'];
}

function unsetUserSession($user): void
{
    unset($_SESSION['user_id']);
    unset($_SESSION['username']);
    unset($_SESSION['email']);
    unset($_SESSION['darkmode']);
}

/**
 * Sets the avatar for a user.
 *
 * @param string $saved_path The path where the avatar file is saved.
 * @param string $hash_name The hashed name of the avatar file.
 * @param string $file_name The original name of the avatar file.
 * @param string $file_ext The extension of the avatar file.
 * @param int $file_size The size of the avatar file in bytes.
 * @return bool Returns true if the avatar is set successfully, false otherwise.
 */
function setUserAvatar(string $saved_path, string $hash_name, string $file_name, string $file_ext, int $file_size): bool
{
    require "db.php";
    $user_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare("INSERT INTO media VALUES (?, ?, ?, ?, ?, 'avatar', ?)");
    return $stmt->execute([$saved_path, $hash_name, $file_name, $file_ext, $file_size, $user_id]);
}


/**
 * Updates the details of a user.
 *
 * @param string $username The current username of the user.
 * @param string $email The current email of the user.
 * @param string $new_username The new username to be set for the user.
 * @param string $new_email The new email to be set for the user.
 * @return bool Returns true if the details are successfully updated, false otherwise.
 */
function setDetails(string $username, string $email, string $new_username, string $new_email): bool
{
    require "db.php";
    $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE username = ? AND email = ?");
    return $stmt->execute([$new_username, $new_email, $username, $email]);
}


/**
 * Sets a new password for a user.
 *
 * @param string $new The new password to be set for the user.
 * @param int $id The ID of the user.
 * @return bool Returns true if the password was successfully set, false otherwise.
 */
function setPassword(string $new, int $id): bool
{
    require "db.php";
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE user_id= ?");
    return $stmt->execute([$new, $id]);;
}


/**
 * Updates the last login timestamp for a user.
 *
 * @param int $id The ID of the user.
 * @return bool Returns true if the last login timestamp was successfully updated, false otherwise.
 */
function setUserLastLogin(int $id): bool
{
    require "db.php";
    $stmt = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE user_id = ?");
    return $stmt->execute([$id]);
}

function setUserTheme(): bool
{
    require "db.php";
    $mode = $_SESSION["darkmode"];
    $username = $_SESSION["username"];
    $stmt = $pdo->prepare("UPDATE users SET darkmode = ?  WHERE username = ?");
    return $stmt->execute([$mode, $username]);
}

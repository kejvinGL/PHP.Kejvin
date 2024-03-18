<?php

use Controllers\AuthController;
use Controllers\AdminController;
use Controllers\ProfileController;
use Controllers\PostController;
use Controllers\ThemeController;


//VIEWS
$router->get('/', function () {
    $post = new PostController();
    $post->index('home');
});
$router->get('/login', function () {
    $auth = new AuthController();
    $auth->index("login");
});
$router->get('/register', function () {
    $auth = new AuthController();
    $auth->index("register");
});
$router->get('/overall', function () {
    $admin = new AdminController();
    $admin->index("overall");
});
$router->get('/users', function () {
    $admin = new AdminController();
    $admin->index("users");
});
$router->get('/posts', function () {
    $admin = new AdminController();
    $admin->index("posts");
});
$router->get('/access', function () {
    $admin = new AdminController();
    $admin->index("access");
});

$router->get('/home', function () {
    $post = new PostController();
    $post->index('home');
});

$router->get('/profile', function () {
    $profile = new ProfileController();
    $profile->index('profile');
});




// AUTHENTICATION
$router->post('/auth/clientRegister', function () {
    $auth = new AuthController();
    $auth->clientRegister();
});
$router->get('/auth/userLogin', function () {
    $auth = new AuthController();
    $auth->userLogin();
});
$router->get('/auth/logout', function () {
    $auth = new AuthController();
    $auth->userLogout();
});


$router->post('/admin/createUser/{role}', function ($params) {
    $admin = new AdminController();
    $admin->createUser($params['role']);
});
$router->delete('/admin/deleteUser/{user_id}', function ($params) {
    $admin = new AdminController();
    $admin->deleteUser($params['user_id']);
});
$router->put('/admin/changeUser/{user_id}', function ($params) {
    $admin = new AdminController();
    $admin->changeUser($params['user_id']);
});


$router->put('/profile/changeAvatar', function () {
    $profile = new ProfileController();
    $profile->changeAvatar();
});
$router->put('/profile/changeDetails', function () {
    $profile = new ProfileController();
    $profile->changeDetails();
});
$router->put('/profile/changePassword', function () {
    $profile = new ProfileController();
    $profile->changePassword();
});
$router->delete('/profile/deleteSelf', function () {
    $profile = new ProfileController();
    $profile->deleteSelf();
});



$router->post('/posts/createPost', function () {
    $post = new PostController();
    $post->createPost();
});

$router->delete('/posts/deletePost/{post_id}', function ($params) {
    $post = new PostController();
    $post->deletePost($params['post_id']);
});


$router->put('/user/changeTheme', function () {
    $user = new ThemeController();
    $user->changeTheme();
});

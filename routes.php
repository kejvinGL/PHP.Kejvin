<?php

use Controllers\AuthController;
use Controllers\AdminController;
use Controllers\PostController;
use Controllers\ThemeController;
use Controllers\ProfileController;


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
$router->post('/auth/register', function () {
    $auth = new AuthController();
    $auth->store();
});
$router->get('/auth/login', function () {
    $auth = new AuthController();
    $auth->login();
});
$router->get('/auth/logout', function () {
    $auth = new AuthController();
    $auth->logout();
});


$router->post('/admin/create/{role}', function ($params) {
    $admin = new AdminController();
    $admin->store($params['role']);
});
$router->delete('/admin/delete/{user_id}', function ($params) {
    $admin = new AdminController();
    $admin->destroy($params['user_id']);
});
$router->put('/admin/change/{user_id}', function ($params) {
    $admin = new AdminController();
    $admin->edit($params['user_id']);
});


$router->put('/profile/avatar', function () {
    $profile = new ProfileController();
    $profile->changeAvatar();
});
$router->put('/profile/details', function () {
    $profile = new ProfileController();
    $profile->changeDetails();
});
$router->put('/profile/password', function () {
    $profile = new ProfileController();
    $profile->changePassword();
});
$router->delete('/profile/deleteSelf', function () {
    $profile = new ProfileController();
    $profile->deleteSelf();
});



$router->post('/posts/create', function () {
    $post = new PostController();
    $post->store();
});

$router->delete('/posts/delete/{post_id}', function ($params) {
    $post = new PostController();
    $post->destroy($params['post_id']);
});


$router->put('/user/changeTheme', function () {
    $user = new ThemeController();
    $user->changeTheme();
});

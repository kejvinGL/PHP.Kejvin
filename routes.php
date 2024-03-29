<?php

use Controllers\Admin\AdminController;
use Controllers\AuthController;
use Controllers\Client\ClientController;
use Controllers\PostController;
use Controllers\ThemeController;
use Controllers\ProfileController;

//VIEWS
$router->get('/', function () {
    ClientController::index();
}, ['isLoggedIn', 'isClient']);
$router->get('/login', function () {
    AuthController::showLogin();
}, ['isLoggedIn']);
$router->get('/register', function () {
    AuthController::showRegister();
}, ['isLoggedIn']);
$router->get('/overall', function () {
    AdminController::showOverall();
}, ["isLoggedIn", "isAdmin"]);
$router->get('/users', function () {
    AdminController::showUsers();
}, ['isLoggedIn', 'isAdmin']);
$router->get('/posts', function () {
    AdminController::showPosts();
}, ['isLoggedIn', 'isAdmin']);
$router->get('/access', function () {
    AdminController::showAccess();
}, ['isLoggedIn', 'isAdmin']);
$router->get('/home', function () {
    ClientController::index();
}, ['isLoggedIn', 'isClient']);

$router->get('/profile', function () {
    ProfileController::index();
}, ['isLoggedIn']);


// AUTHENTICATION
$router->post('/auth/register', function () {
    AuthController::store();
});
$router->get('/auth/login', function () {
    AuthController::login();
});
$router->get('/auth/logout', function () {
    AuthController::logout();
});

//ADMIN FUNCTIONS
$router->post('/admin/create/{role}', function ($params) {
    AdminController::store($params['role']);
}, ["isLoggedIn", "isAdmin"]);
$router->delete('/admin/delete/{user_id}', function ($params) {
    AdminController::destroy($params['user_id']);
}, ["isLoggedIn", "isAdmin"]);
$router->put('/admin/change/{user_id}', function ($params) {
    AdminController::edit($params['user_id']);
}, ["isLoggedIn", "isAdmin"]);

//PROFILE FUNCTiONS
$router->put('/profile/avatar', function () {
    ProfileController::changeAvatar();
}, ["isLoggedIn"]);
$router->put('/profile/details', function () {
    $profile = new ProfileController();
    $profile->changeDetails();
    ProfileController::changeDetails();
}, ["isLoggedIn"]);
$router->put('/profile/password', function () {
    ProfileController::changePassword();
}, ["isLoggedIn"]);
$router->delete('/profile/deleteSelf', function () {
    ProfileController::deleteSelf();
}, ["isLoggedIn"]);


//POST FUNCTIONS
$router->post('/posts/create', function () {
    PostController::store();
});
$router->delete('/posts/delete/{post_id}', function ($params) {
    PostController::destroy($params['post_id']);
});


//THEME CHANGER
$router->put('/user/changeTheme', function () {
    ThemeController::changeTheme();
});

<?php
//VIEWS
$router->get('/', 'controllers/home.php');
$router->get('/login', '/controllers/login.php');
$router->get('/register', '/controllers/register.php');
$router->get('/overall', '/controllers/overall.php');
$router->get('/users', '/controllers/users.php');
$router->get('/posts', '/controllers/posts.php');
$router->get('/access', '/controllers/access.php');

$router->get('/home', '/controllers/home.php');

$router->get('/profile', '/controllers/profile.php');



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
$router->update('/admin/changeUser/{user_id}', function ($params) {
    $admin = new AdminController();
    $admin->changeUser($params['user_id']);
});


$router->update('/profile/changeAvatar', function () {
    $profile = new ProfileController();
    $profile->changeAvatar();
});
$router->update('/profile/changeDetails', function () {
    $profile = new ProfileController();
    $profile->changeDetails();
});
$router->update('/profile/changePassword', function () {
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


$router->update('/user/changeTheme', function () {
    $user = new ThemeController();
    $user->changeTheme();
});

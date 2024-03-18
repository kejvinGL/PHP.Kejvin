<?php

function view($view)
{
    require "views/partials/header.php";
    isLoggedIn();

    require 'views/' . $view . "View.php";


    require "views/partials/footer.php";
}

<?php
switch ($_SERVER["REQUEST_URI"]) {
    case '/loginpage/views/client.php':
        $footer = '<footer footer-center p-4 text-base-content bottom-0';
        break;
    case '/loginpage/views/posts.php':
        $footer = '<footer footer-center p-4 text-base-content bottom-0';
        break;
    case '/loginpage/views/users.php':
        $footer = '<footer footer-center p-4 text-base-content bottom-0';
        break;
    default:
        $footer = '<footer footer-center p-4 text-base-content absolute bottom-0">';
        break;
}

echo $footer;
?>
<aside>
    <p>2024 - Kejvin Braka | PHP Intern @ ATIS Albania </p>
</aside>
</footer>
</body>

</html>
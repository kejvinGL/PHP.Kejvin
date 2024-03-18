<?php
switch ($_SERVER["REQUEST_URI"]) {
    case '/client':
        $footer = '<footer class="footer footer-center p-4 text-base-content bottom-0"';
        break;
    case '/posts.php':
        $footer = '<footer class="footer footer-center p-4 text-base-content bottom-0"';
        break;
    case '/users.php':
        $footer = '<footer class="footer footer-center p-4 text-base-content bottom-0"';
        break;
    default:
        $footer = '<footer class="footer footer-center p-4 text-base-content absolute bottom-0"">';
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
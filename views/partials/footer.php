<?php
$option = match ($_SERVER["REQUEST_URI"]) {
    '/home' , '/posts', '/users' => 'footer footer-center p-4 text-base-content bottom-0',
    default => 'footer footer-center p-4 text-base-content absolute bottom-0',
};
?>
<footer class="<?php echo $option ?>">
<aside>
    <p>2024 - Kejvin Braka | PHP Intern @ ATIS Albania </p>
</aside>
</footer>
</body>

</html>
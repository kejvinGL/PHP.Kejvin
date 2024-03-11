<div class=" h-1/5">
    <?= isset($_SESSION["errors"]["user"]) ? showErrors('user') : null ?>
</div>
<div class="h-4/5 w-1/2">
    <div class="flex flex-col items-center justify-between w-full h-[420px]">
        <?php require "partials/forms/loginForm.php" ?>
    </div>
</div>
<?php
require "partials/footer.php";
?>
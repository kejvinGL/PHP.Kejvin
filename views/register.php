<?php
require("partials/header.php");
isLoggedIn();
?>
<div class="h-1/5">
</div>
<div class="h-4/5 w-1/2">
    <div class=" flex flex-col items-center justify-between w-full h-[420px]">
        <?php require("partials/forms/registerForm.php") ?>
    </div>
</div>

<?php include "partials/footer.php" ?>
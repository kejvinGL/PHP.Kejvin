<div class="flex text-xl my-5">
    <p class="flex items-center justify-center">Login
    </p>
</div>
<form id="login-form" action="../src/requests/auth/userLogin.php" method="post" class="h-[45%] flex flex-col justify-evenly max-w-[500px] w-full">
    <div class="h-1/2">
        <label class="input input-bordered flex items-center gap-2 <?php echo empty($_SESSION["errors"]["username"]) ? "" : "input-error" ?>">
            <i class="fa-solid fa-user"></i>
            <input name="username" type="text" class="grow " placeholder="Username" value="<?php echo $_SESSION["input"]["username"] ?? "" ?>" />
        </label>
        <?php echo isset($_SESSION["errors"]["username"]) ? showErrors("username") : "" ?>
    </div>
    <div class="h-1/2">
        <label class="input input-bordered flex items-center gap-2 <?php echo empty($_SESSION["errors"]["password"]) ? "" : "input-error" ?>">
            <i class="fa-solid fa-key"></i>
            <input name="password" type="password" class="grow" placeholder="********" />
        </label>
        <?php echo isset($_SESSION["errors"]["password"]) ? showErrors("password") : "";
        unset($_SESSION["errors"]["username"]); ?>
    </div>
</form>
<div class="flex justify-evenly">
    <input type="submit" class="btn w-5/12" name="submit" form="login-form" value="Login">
    <div class="divider divider-horizontal">OR</div>
    <a class="btn w-5/12" href="/loginpage/views/register.php">Register</a>
</div>
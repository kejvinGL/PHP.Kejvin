<div class=" h-1/5">
    <?php showErrors('user') ?? null ?>
</div>
<div class="h-4/5 w-1/2">
    <div class="flex flex-col items-center justify-between w-full h-[420px]">
        <div class="flex text-xl my-5">
            <p class="flex items-center justify-center">Login
            </p>
        </div>
        <form id="login-form" action="/auth/userLogin" method="GET" class="h-[45%] flex flex-col justify-evenly max-w-[500px] w-full">
            <div class="h-1/2">
                <label class="input input-bordered flex items-center gap-2 <?php echo empty($_SESSION["errors"]["username"]) ? "" : "input-error" ?>">
                    <i class="fa-solid fa-user"></i>
                    <input name="username" type="text" class="grow " placeholder="Username" value="<?php echo $_SESSION["input"]["username"] ?? "" ?>" />
                </label>
                <?php showErrors("username") ?? null ?>
            </div>
            <div class="h-1/2">
                <label class="input input-bordered flex items-center gap-2 <?php echo empty($_SESSION["errors"]["password"]) ? "" : "input-error" ?>">
                    <i class="fa-solid fa-key"></i>
                    <input name="password" type="password" class="grow" placeholder="********" />
                </label>
                <?php showErrors("password") ?? null ?>
            </div>
        </form>
        <div class="flex justify-evenly">
            <input type="submit" class="btn w-5/12" name="submit" form="login-form" value="Login">
            <div class="divider divider-horizontal">OR</div>
            <a class="btn w-5/12" href="/register">Register</a>
        </div>
    </div>
</div>
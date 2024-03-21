<div class="h-1/5">
</div>
<div class="h-4/5 w-1/2">
    <div class=" flex flex-col items-center justify-between w-full h-[420px]">
        <p class="text-center text-xl m-5">Register as User</p>
        <form id="register-form" action="/auth/register" method="post" class="h-full flex flex-col justify-evenly max-w-[500px] w-full">
            <div class="h-1/4">
                <label class="input input-bordered flex items-center gap-2 <?php echo empty($_SESSION["errors"]["fullname"]) ? "" : "input-error" ?>">
                    <i class="fa-solid fa-id-card fa-sm"></i>
                    <input name="fullname" type="text" class="grow" placeholder="Full Name" value="<?php echo $_SESSION["input"]["fullname"] ?? null ?>" />
                </label>
                <div class="label pt-0">
                    <?php showErrors("fullname") ?? null ?>
                </div>
            </div>
            <div class="h-1/4">
                <label class="input input-bordered flex items-center gap-2 <?php echo empty($_SESSION["errors"]["email"]) ? "" : "input-error" ?>">
                    <i class="fa-solid fa-envelope"></i>
                    <input name="email" type="email" class="grow" placeholder="E-mail" value="<?php echo $_SESSION["input"]["email"] ?? "" ?>" />
                </label>
                <div class="label pt-0">
                    <?php showErrors("email") ?? null ?></div>
            </div>
            <div class="h-1/4">
                <label class="input input-bordered flex items-center gap-2 <?php echo empty($_SESSION["errors"]["username"]) ? "" : "input-error" ?>">
                    <i class="fa-solid fa-user"></i>
                    <input name="username" type="text" class="grow" placeholder="Username" value="<?php echo $_SESSION["input"]["username"] ?? "" ?>" />
                </label>
                <div class="label pt-0">
                    <?php showErrors("username") ?? null ?></div>
            </div>
            <div class="h-1/4">
                <label class="input input-bordered flex items-center gap-2 <?php echo empty($_SESSION["errors"]["password"]) ? "" : "input-error" ?>">
                    <i class="fa-solid fa-key"></i>
                    <input name="password" type="password" class="grow" placeholder="********" />
                </label>
                <div class="label pt-0">
                    <?php showErrors("password") ?? null ?>
                </div>
            </div>
        </form>
        <div class="btns flex justify-evenly">
            <a class="btn w-5/12" href="/login">Login instead</a>
            <div class="divider divider-horizontal">OR</div>
            <input type="submit" class="btn w-5/12" name="submit" form="register-form" value="Register">
        </div>
    </div>
</div>
<?php include "partials/admin/sideNav.php" ?>
<main class="w-full md:w-[calc(100%-256px)] md:ml-64 bg-base-200 min-h-screen transition-all main flex flex-col md:flex-row md:justify-evenly items-center active">
    <div class="bg-base-300 px-10 pb-5 min-w-[350px] lg:min-w-[400px] my-8 h-2/5 min-h-[360px]">
        <p class="text-center text-xl m-5">Create a new Admin</p>
        <form id="admin-form" action="admin/create/admin" method="post" class="h-1/2 flex flex-col justify-evenly max-w-[500px] w-full">
            <div class="h-1/4">
                <label class=" h-3/5 input input-bordered flex items-center gap-2 <?php echo empty($_SESSION["errors"]["admin-fullname"]) ? "" : "input-error" ?>">
                    <i class="fa-solid fa-id-card fa-sm" style="opacity: 0.7;"></i>
                    <input name="admin-fullname" type="text" class="grow" placeholder="Full Name" value="<?php echo $_SESSION["input"]["admin-fullname"] ?? null ?>" />
                </label>
                <?php showErrors("admin-fullname") ?? null ?>
            </div>
            <div class="h-1/4">
                <label class="h-3/5 input input-bordered flex items-center gap-2 <?php echo empty($_SESSION["errors"]["admin-email"]) ? "" : "input-error" ?>">
                    <i class="fa-solid fa-envelope"></i>
                    <input name="admin-email" type="email" class="grow" placeholder="E-mail" value="<?php echo $_SESSION["input"]["admin-email"] ?? null ?>" />
                </label>

                <?php showErrors("admin-email") ?? null ?>
            </div>
            <div class="h-1/4">
                <label class="h-3/5 input input-bordered flex items-center gap-2 <?php echo empty($_SESSION["errors"]["admin-username"]) ? "" : "input-error" ?>">
                    <i class="fa-solid fa-user"></i>
                    <input name="admin-username" type="text" class="grow" placeholder="Username" value="<?php echo $_SESSION["input"]["admin-username"] ?? null ?>" />
                </label>
                <?php showErrors("admin-username") ?? null ?>
            </div>
            <div class="h-1/4">

                <label class="h-3/5 input input-bordered flex items-center gap-2 <?php echo empty($_SESSION["errors"]["admin-password"]) ? "" : "input-error" ?>">
                    <i class="fa-solid fa-key"></i>
                    <input name="admin-password" type="password" class="grow" placeholder="********" />
                </label>

                <?php showErrors("admin-password") ?? null  ?>
            </div>

        </form>
        <div class="flex justify-evenly">
            <input type="submit" class="btn btn-outline w-5/12" name="submit" form="admin-form" value="Register">
        </div>
        <div class="flex justify-center">
            <?php echo isset($_SESSION["messages"]["admin"]) ? showMessages("admin") : "" ?>
        </div>

    </div>

    <div class="bg-base-300 px-10 pb-5 min-w-[350px] lg:min-w-[400px] h-2/5 min-h-[360px]">
        <p class=" text-center text-xl m-5">Create a new Client</p>
        <form id="client-form" action="admin/create/client" method="post" class="h-1/2 flex flex-col justify-evenly max-w-[500px] w-full">
            <div class="h-1/4">
                <label class="h-3/5 input input-bordered flex items-center gap-2 <?php echo empty($_SESSION["errors"]["client-fullname"]) ? "" : "input-error" ?>">
                    <i class="fa-solid fa-id-card fa-sm" style="opacity: 0.7;"></i>
                    <input name="client-fullname" type="text" class="grow" placeholder="Full Name" value="<?php echo $_SESSION["input"]["client-fullname"] ?? null ?>" />
                </label>
                <?php echo isset($_SESSION["errors"]["client-fullname"]) ? showErrors("client-fullname") : "" ?>
            </div>


            <div class="h-1/4">
                <label class="h-3/5 input input-bordered flex items-center gap-2 <?php echo empty($_SESSION["errors"]["client-email"]) ? "" : "input-error" ?>">
                    <i class="fa-solid fa-envelope"></i>
                    <input name="client-email" type="emial" class="grow" placeholder="E-mail" value="<?php echo $_SESSION["input"]["client-email"] ?? null ?>" />
                </label>
                <?php echo isset($_SESSION["errors"]["client-email"]) ? showErrors("client-email") : "" ?>
            </div>



            <div class="h-1/4">
                <label class="h-3/5 input input-bordered flex items-center gap-2 <?php echo empty($_SESSION["errors"]["client-username"]) ? "" : "input-error" ?>">
                    <i class="fa-solid fa-user"></i>
                    <input name="client-username" type="text" class="grow" placeholder="Username" value="<?php echo $_SESSION["input"]["client-username"] ?? null ?>" />
                </label>
                <?php echo isset($_SESSION["errors"]["client-username"]) ? showErrors("client-username") : "" ?>
            </div>



            <div class="h-1/4">
                <label class="h-3/5 input input-bordered flex items-center gap-2 <?php echo empty($_SESSION["errors"]["client-password"]) ? "" : "input-error" ?>">
                    <i class="fa-solid fa-key"></i>
                    <input name="client-password" type="password" class="grow" placeholder="********" />
                </label>
                <?php echo isset($_SESSION["errors"]["client-password"]) ? showErrors("client-password") : "" ?>
            </div>

        </form>
        <div class="flex justify-evenly">
            <input type="submit" class="btn btn-outline w-5/12" name="submit" form="client-form" value="Register">
        </div>
        <div class="flex justify-center">
            <?php echo isset($_SESSION["messages"]["client"]) ? showMessages("client") : "" ?>
        </div>
    </div>

</main>
<script src="assets/js/sidebar.js"></script>
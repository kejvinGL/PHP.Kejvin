<?php
switch ($_SERVER["REQUEST_URI"]) {
    case '/home':
        $sticky = 'sticky';
        break;
    case '/users':
        $sticky = 'sticky';
        break;
    case '/posts':
        $sticky = 'sticky';
        break;
    default:
        $sticky = "";
}
?>


<div class="navbar bg-base-100 top-0 z-10 <?php echo $sticky ?> ">
    <?php
    if (isset($_SESSION['username'])) { ?>

        <div class="flex-1">

            <?php if (getCurrentUserRole() === 0 && $_SERVER["REQUEST_URI"] != "/views/profile") { ?>
                <button type="button" class="text-lg text-neutral-400 size-10 btn btn-ghost sidebar-toggle">
                    <i class="fa-solid fa-bars"></i>
                </button>

            <?php } ?>

            <a class="btn btn-ghost text-xl pl-1 pr-0" href="/home">PHP.Kejvin</a>
            <span class="text-3xl px-2">/</span>
            <a class="btn-ghost text-neutral-500" href="/profile"><?php echo $_SESSION["username"] ?? null ?></a>
        </div>
        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar mx-4 flex">
                <div class="w-10 rounded-full">
                    <img alt="avatar" src="<?php echo getCurrentAvatar() ?>" />
                </div>
            </div>
            <ul tabindex="0" class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52">
                <li><a href="/profile">Profile</a></li>
                <li><a href="/auth/logout">Logout</a></li>
            </ul>
        </div>
        <form class="m-0 size-10 " action="user/changeTheme" method="POST">
            <input type="hidden" name="_method" value="PUT">
            <label class="size-10 cursor-pointer">
                <i class="fa-solid fa-lightbulb fa-xl"></i>
                <input type="submit" value="">
            </label>
        </form>
    <?php } else { ?>
        <div class="flex-1">
            <a class="btn btn-ghost text-xl" href="<?php $_SERVER["REQUEST_URI"] ?>">PHP.Kejvin</a>
        </div>
        <form class="m-0 size-10 " action="user/changeTheme" method="POST">
            <input type="hidden" name="_method" value="PUT">
            <label class="size-10 cursor-pointer">
                <i class="fa-solid fa-lightbulb fa-lg"></i>
                <input type="submit" value="">
            </label>
        </form>
    <?php } ?>
</div>
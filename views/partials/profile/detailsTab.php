<input type="radio" name="change_tabs" role="tab" class="tab" aria-label="Details" <?php echo $_SESSION['tab'] == "details" ? "checked" : null; ?> />
<div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box w-[450px] h-[350px]">
    <div class="flex flex-col items-center justify-evenly mx-auto h-3/4 w-[350px]">
        <!--  -->
        <form class="flex flex-col justify-between pt-8 h-3/4 w-full" name="details_change" id="details_change" action="/src/requests/profile/changeDetails" method="post">
            <div class="h-1/2 w-full">
                <label class="input input-bordered <?php echo empty($_SESSION["errors"]["details"]["username"]) ? "" : "input-error" ?> flex items-center gap-2">
                    <i class="fa-solid fa-user"></i>
                    <input name="new_username" class="grow " type="text" placeholder=" Username" value="<?php echo $_SESSION['username'] ?>" />
                </label>
                <div class="label pt-0">
                    <?php echo isset($_SESSION["errors"]["details"]["username"]) ? showErrorsAssoc("details", 'username') : ""; ?>
                </div>
            </div>
            <div class="h-1/2 w-full">
                <label class="input input-bordered flex items-center gap-2 w-full <?php echo empty($_SESSION["errors"]["details"]["email"]) ? "" : "input-error" ?>">
                    <i class="fa-solid fa-envelope"></i>
                    <input name="new_email" class="grow" type="email" placeholder="Email" value="<?php echo $_SESSION['email'] ?>" />
                </label>
                <div class="label pt-0">
                    <?php echo isset($_SESSION["errors"]["details"]["email"]) ? showErrorsAssoc("details", "email") : ""; ?>
                </div>
            </div>
        </form>
    </div>
    <div class="flex flex-col justify-end items-center w-full h-1/4 pb-3">
        <input type="submit" name="submit" class="btn flex w-4/5 self-center" id="detailsButton" form="details_change" value="Change Details">
    </div>
</div>
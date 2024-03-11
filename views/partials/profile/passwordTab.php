<input type="radio" name="change_tabs" role="tab" class="tab" aria-label="Password" <?php echo $_SESSION['tab'] == "password" ? "checked" : null; ?> />
<div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box w-[450px] h-[350px]">
    <div class="flex flex-col items-center justify-evenly mx-auto h-4/5 w-[350px]">
        <!--  -->
        <form class="flex flex-col justify-between pt-8 h-[250px] items-center w-full" name="password_change" id="password_change" action="/src/requests/profile/changePassword" method="post">
            <div class="h-1/3 w-full">
                <input name="current_password" type="password" class="input input-bordered w-full <?php echo empty($_SESSION["errors"]["password"]["current"]) ? "" : "input-error" ?>" placeholder="Current Password" />
                <div class="label pt-0">
                    <?php echo isset($_SESSION["errors"]["password"]["current"]) ? showErrorsAssoc("password", "current") : ""; ?>
                </div>
            </div>
            <div class="h-1/3 w-full">
                <input name="new_password" type="password" class="input input-bordered w-full <?php echo empty($_SESSION["errors"]["password"]["new_password"]) ? "" : "input-error" ?>" placeholder="New Password" />
                <div class="label pt-0">
                    <?php
                    echo isset($_SESSION["errors"]["password"]["new_password"]) ? showErrorsAssoc("password", "new_password") : ""; ?>
                </div>
            </div>
            <div class="h-1/3 w-full">
                <input name="repeat_password" type="password" class="input input-bordered w-full <?php echo empty($_SESSION["errors"]["password"]["repeat_password"]) ? "" : "input-error" ?>" placeholder="Repeat New Password" />
                <div class="label pt-0">
                    <?php echo isset($_SESSION["errors"]["password"]["repeat_password"]) ? showErrorsAssoc("password", "repeat_password") : ""; ?>
                </div>
            </div>
        </form>
    </div>
    <div class="flex flex-col justify-end items-center w-full h-1/5 pb-3">
        <input type="submit" name="submit" class="btn flex w-4/5 self-center" form="password_change" value="Change Password">
    </div>
</div>
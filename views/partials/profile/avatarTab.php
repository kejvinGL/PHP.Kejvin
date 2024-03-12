<input type="radio" name="change_tabs" role="tab" class="tab" aria-label="Avatar" <?php echo $_SESSION['tab'] == "avatar" ? "checked" : null; ?> />
<div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box w-[450px] h-[350px]">
    <div class="flex flex-col items-center justify-evenly mx-auto h-3/4 w-[300px]">
        <form class="flex flex-col justify-between h-3/4" name="avatar-change" id="avatar-change" action="/profile/changeAvatar" enctype="multipart/form-data" method="post">
            <div class="flex flex-col items-center justify-evenly">
                <div class="size-36 rounded">
                    <img src="<?php echo getCurrentAvatar() ?>" />
                </div>
                <label class="form-control w-full self-end">
                    <input name="new-avatar" type="file" accept="image/png, image/gif, image/jpeg" class="file-input file-input-bordered <?php echo empty($_SESSION["errors"]["avatar"]) ? "" : "file-input-error" ?> w-full max-w-xs " onchange="enableChange(this)" />
                </label>
            </div>
        </form>
    </div>
    <div class="flex flex-col justify-end items-center w-full h-1/4 pb-3">
        <?php echo isset($_SESSION["errors"]["avatar"]) ? showErrors("avatar") : ""; ?>
        <input type="submit" name="submit" class="btn flex w-4/5 self-center" id="avatarButton" form="avatar-change" value="Change Avatar" disabled>
    </div>
</div>
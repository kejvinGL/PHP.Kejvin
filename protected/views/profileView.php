<div class="flex flex-col mt-14 errors_messages h-1/5 w-4/5 justify-end items-center">
    <?php
    if (!isset($_SESSION['tab'])) {
        $_SESSION['tab'] = 'avatar';
    }
    showProfileResponses();
    ?>
</div>
<div class="h-4/5 ">
    <div class="flex flex-col items-center w-[450px] h-[380px]">
        <div role="tablist" class="tabs tabs-lifted">
            <?php include 'partials/profile/avatarTab.php' ?>
            <?php include 'partials/profile/detailsTab.php' ?>
            <?php include 'partials/profile/passwordTab.php' ?>
        </div>
    </div>
    <div class="divider"></div>
    <?php include 'partials/profile/deleteTab.php' ?>
</div>
<script src="../../assets/js/enableInput.js"></script>
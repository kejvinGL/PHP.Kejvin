<?php include "partials/admin/sideNav.php" ?>
<main class="w-full md:w-[calc(100%-256px)] md:ml-64 bg-base-200 h-full transition-all main flex flex-col active">
    <div class="p-5 flex flex-col items-center">
        <div class="grid grid-cols-1 md:grid-cols-2 w-3/4 gap-6 mb-6">
            <div class="stat bg-base-100">
                <div class="stat-figure text-secondary pr-3">
                    <i class="fa-regular fa-user fa-2xl"></i>
                </div>
                <div class="stat-title">Total Clients</div>
                <div class="stat-value"><?php echo $data['totalClients'] ?></div>
            </div>
            <div class="stat bg-base-100">
                <div class="stat-figure text-secondary pr-3">
                    <i class="fa-solid fa-hammer fa-2xl"></i>
                </div>
                <div class="stat-title">Total Admins</div>
                <div class="stat-value"><?php echo $data['totalAdmins'] ?></div>

            </div>

        </div>
        <div class="grid grid-cols-1 md:grid-cols-1 mb-6 w-3/4">
            <div class="stat bg-base-100">
                <div class="stat-figure text-secondary pr-3">
                    <i class="fa-solid fa-inbox fa-2xl"></i>
                </div>
                <div class="stat-title">Total Number of Posts</div>
                <div class="stat-value"><?php echo $data['totalPosts'] ?></div>
                <div class="stat-desc"><?php echo $data['recentPosts'] ?></div>
            </div>
        </div>

    </div>
</main>

<script src="../../assets/js/sidebar.js"></script>
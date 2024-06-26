<?php include "partials/admin/sideNav.php" ?>
<main class="w-full md:ml-64 bg-base-200 h-full transition-all main active">
    <div class=" flex h-14 justify-center items-center">
        <?php
        showUserlistResponses();
        ?>

    </div>
    <table class="table rounded-xl lg:text-lg border-separate border-spacing-2">
        <thead>
            <tr class="border border-accent border-spacing-2 bg-base-300">
                <th class="hidden md:table-cell"></th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Email</th>
                <th class=" hidden md:table-cell">Last Login</th>
                <th>Posts</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($data as $user) {
            ?>
                <tr class="border-b border-accent border-spacing-2">
                    <!-- USER AVATAR -->
                    <td class="bg-base-100 hidden md:table-cell w-1/12 pr-0">
                        <div class="flex items-center gap-0 justify-center">
                            <div class="avatar">
                                <div class="mask mask-squircle size-6">
                                    <img src="<?php echo $user['avatar'] ?>" alt="avatar" />
                                </div>
                            </div>
                        </div>
                    </td>

                    <!-- FULL NAME -->
                    <td class="bg-base-100 pr-0 md:pr-1">
                        <div>
                            <div class="text-xs"><?php echo $user['fullname'] ?></div>
                        </div>
                    </td>

                    <!-- USERNAME & BADGE -->
                    <td class="bg-base-100 pr-0 md:pr-1">
                        <div>
                            <?php if ($user["role_id"]) {
                                echo '<div class="place-items-center">' . $user['username'] . '</div>';
                            } else {
                                echo '<div class="indicator">
                                <span class="indicator-item -translate-x-6 badge badge-warning scale-50">Admin</span>
                                <div class="place-items-center">' . $user['username'] . '</div>
                            </div>';
                            }
                            ?>
                        </div>
                    </td>

                    <!-- EMAIL -->
                    <td class="bg-base-100 pr-0 md:pr-1">
                        <div>
                            <div class="text-xs text-wrap"><?php echo $user['email'] ?></div>
                        </div>
                    </td>
                    <!-- LAST LOGIN -->
                    <td class="bg-base-100 hidden md:table-cell">
                        <?php
                        $date = date_create($user['last_login']);
                        echo date_format($date, 'd/m/y @ H:m') ?>
                    </td>
                    <td class="bg-base-100 ">
                        <?php echo $user["role"] ? $user['posts'] : "" ?>
                    </td>
                    <td class="bg-base-100 text-nowrap ">
                        <dialog id="<?php echo "user_" . $user["ID"] ?>" class="modal">
                            <div class="modal-box">
                                <h3><span class="text-red-500">WARNING! </span>Editing User Information</h3>
                                <p class="text-xs text-gray-600">Press ESC to cancel</p>
                                <div class="modal-action">
                                    <form method="POST" action="admin/change/<?php echo $user["ID"] ?>" id="edit_user" class="w-full">
                                        <input type="hidden" name="_method" value="PUT">
                                        <label class="input input-bordered flex items-center gap-2">
                                            <i class="fa-solid fa-user"></i>
                                            <input name="new_username" class="grow " type="text" placeholder="Username" value="<?php echo $user['username'] ?>" minlength="5" required />
                                        </label>
                                        <label class="input input-bordered flex items-center gap-2 w-full">
                                            <i class="fa-solid fa-envelope"></i>
                                            <input name="new_email" class="grow" type="email" placeholder="Email" value="<?php echo $user['email'] ?>" required />
                                        </label>
                                        <div class="flex justify-center">
                                            <input type="submit" name="edit" class="btn btn-error btn-outline btn-md text-xs" value="Save Changes" />
                                        </div>
                                    </form>
                                    <form method="dialog">
                                        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                                    </form>
                                </div>
                            </div>
                        </dialog>
                        <button class="btn btn-accent btn-xs rounded-md" onclick="<?php echo "user_" . $user["ID"] ?>.showModal()">
                            <i class="fa-solid fa-edit"></i>
                        </button>
                        <dialog id="<?php echo "delete_user_" . $user["ID"] ?>" class="modal">
                            <div class="modal-box">
                                <h3><span class="text-red-500">WARNING! </span>Deleting an user:
                                    <?php echo $user["fullname"] . " (@" . $user["username"] . ")" ?></h3>
                                <p class="text-xs text-gray-600">Press ESC to cancel</p>
                                <div class="modal-action flex flex-col">
                                    <form id="delete_form" class="inline-flex join" action="/admin/delete/<?php echo $user['ID'] ?>" method="post">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="password" name="password" class="input input-bordered join-item w-full max-w-xs" id="enter_pass" placeholder="********" />
                                        <input type="submit" name="delete" class="btn btn-outline join-item btn-error" id="deleteButton" value="Delete" />
                                    </form>
                                    <form method="dialog">
                                        <button class="btn">Close</button>
                                    </form>
                                </div>
                            </div>
                        </dialog>
                        <button class="btn btn-error btn-xs rounded-md" onclick="<?php echo "delete_user_" . $user["ID"] ?>.showModal()">
                            <i class="fa-solid fa-trash"></i>
                        </button>

                    </td>
                </tr>
            <?php } ?>
    </table>
</main>
<script src="../../assets/js/enableInput.js"></script>
<script src="../../assets/js/sidebar.js"></script>
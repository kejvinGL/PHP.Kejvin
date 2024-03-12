<main class="w-full md:ml-64 bg-base-200 h-full transition-all main active">
    <div class=" flex h-14 justify-center items-center">
        <?php echo empty($_SESSION["errors"]['changes']) ? "" : showErrors('changes') ?>
        <?php echo empty($_SESSION["messages"]) ? "" : showMessage('changes') ?>
    </div>
    <table class="table lg:text-lg">
        <thead>
            <tr>
                <th class="hidden md:table-cell"></th>
                <th>Poster</th>
                <th class=" hidden md:table-cell">Last Login</th>
                <th>Title</th>
                <th>Date Posted</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $posts = getPosts();
            foreach ($posts as $post) {
            ?>
                <tr>
                    <!-- USER AVATAR -->
                    <td class="hidden md:table-cell w-1/12 pr-0">
                        <div class="flex items-center gap-0 justify-center">
                            <div class="avatar">
                                <div class="mask mask-squircle size-6">
                                    <img src="<?php echo getUserAvatarPath($post['user_id']) ?>">
                                </div>
                            </div>
                        </div>
                    </td>

                    <!-- USERNAME -->
                    <td class="pr-0 md:pr-1">
                        <div>
                            <div><?php echo getUserUsername($post["user_id"]) ?></div>
                        </div>
                    </td>

                    <!-- LAST LOGIN -->
                    <td class="hidden md:table-cell w-1/6">
                        <?php echo getUserLastLogin($post["user_id"]) ?>
                    </td>
                    <td class="pr-0 md:pr-1">
                        <div>
                            <div><?php echo $post['title'] ?></div>
                        </div>
                    </td>
                    <td>
                        <?php
                        $date = date_create($post["date_created"]);
                        echo date_format($date, ' H:m @ d/m/y') ?>
                    </td>
                    <td>
                        <dialog id="<?php echo "post_" . $post["post_id"] ?>" class="modal">
                            <div class="modal-box">
                                <h3 class="text-lg"><?php echo $post["title"] ?></h3>
                                <p class="text-sm text-gray-200"><?php echo $post["body"] ?></p>
                                <div class="modal-action">
                                    <form method="dialog">
                                        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                                    </form>
                                </div>
                            </div>
                        </dialog>
                        <button class="btn btn-info btn-xs rounded-md" onclick="<?php echo "post_" . $post["post_id"] ?>.showModal()">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        <dialog id="<?php echo "delete_post_" . $post["post_id"] ?>" class="modal">
                            <div class="modal-box">
                                <h3>Are you sure you want to delete this Post?</h3>
                                <p class="text-xs text-gray-600">Press ESC to cancel</p>
                                <div class="modal-action">
                                    <form method="post" action="/posts/deletePost" class="w-full">
                                        <input type="hidden" name="post_id" value="<?php echo $post["post_id"] ?>">
                                        <div class="flex justify-center">
                                            <input type="submit" name="delete" class="btn btn-error btn-outline btn-md text-xs" value="Delete" />
                                        </div>
                                    </form>
                                    <form method="dialog">
                                        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                                    </form>
                                </div>
                            </div>
                        </dialog>
                        <button class="btn btn-error btn-xs rounded-md" onclick="<?php echo "delete_post_" . $post["post_id"] ?>.showModal()">
                            <i class="fa-solid fa-trash"></i>
                        </button>

                    </td>
                </tr>
            <?php } ?>
    </table>
</main>
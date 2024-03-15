<div class="h-1/5 flex flex-col align-middle">
    <dialog id="addNew" class="modal">
        <div class="modal-box">
            <h3>Creating New Post</h3>
            <p class="text-xs text-gray-600">Press ESC to cancel</p>
            <div class="modal-action">
                <form method="post" id="add_post" action="/posts/createPost" class="w-full">
                    <input type="text" name="title" class="input input-bordered w-full" placeholder="Post title here.." required>
                    <textarea type name="body" form="add_post" class="textarea textarea-bordered textarea-lg w-full h-[300px] text-sm mb-2" placeholder="Type post here..."></textarea>
                    <div class="flex justify-center">
                        <input type="submit" name="submit" class="btn btn-success btn-outline btn-md text-xs" value="Create" />
                    </div>
                </form>
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>
            </div>
        </div>
    </dialog>
    <button class="mx-auto btn m-10 size-16" onclick="addNew.showModal()"><i class="fa-solid fa-plus scale-150"></i></button>

    <?php showMessage() ?? null ?>
</div>
<?php
$posts = getCurrentUserPosts();
if (empty($posts)) { ?>
    <h3 class="align-middle m-10 text-2xl">No posts are made.</h3>
    <?php } else {
    foreach ($posts as $post) { ?>
        <div class="flex flex-col w-1/2 min-h-[200px] min-w-[400px] items-center bg-base-200 border border-secondary rounded-2xl p-2 mb-5">
            <div class="flex w-full h-1/6 items-center min-h-[45px]">
                <div class="avatar">
                    <div class="w-9 rounded-xl">
                        <img src="<?php echo getCurrentAvatar() ?>" />
                    </div>
                </div>
                <div class="flex flex-col title w-full justify-start pl-3 ">
                    <div class="text-xs sm:text-base md:text-md">
                        <?php echo $post["title"] ?>
                    </div>
                    <div class="flex justify-start pl-2 text-xs text-neutral-500">
                        <?php
                        $date = date_create($post["date_created"]);
                        echo date_format($date, 'd M Y')
                        ?>
                    </div>
                </div>
                <div class="flex delete w-1/12 justify-end pr-2">
                    <dialog id="<?php echo "post_" . $post["post_id"] ?>" class="modal">
                        <div class="modal-box">
                            <h3>Are you sure you want to delete this Post?</h3>
                            <p class="text-xs text-gray-600">Press ESC to cancel</p>
                            <div class="modal-action">
                                <form method="post" action="/posts/deletePost/<?php echo $post['post_id']; ?>" class="w-full">
                                    <input type="hidden" name="_method" value="DELETE">
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
                    <button class="btn btn-error btn-xs rounded-md" onclick="<?php echo "post_" . $post["post_id"] ?>.showModal()">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            </div>
            <div class="divider m-0"></div>
            <div class="w-full h-5/6 pl-3 text-sm overflow-auto">
                <?php echo $post['body'] ?>
            </div>
        </div>
<?php
    }
} ?>
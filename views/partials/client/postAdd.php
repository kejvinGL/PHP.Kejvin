<dialog id="addNew" class="modal">
    <div class="modal-box">
        <h3>Creating New Post</h3>
        <p class="text-xs text-gray-600">Press ESC to cancel</p>
        <div class="modal-action">
            <form method="post" id="add_post" action="/loginpage/src/requests/posts/createPost.php" class="w-full">
                <input type="text" name="title" class="input input-bordered w-full" placeholder="Post title here.."
                    required>
                <textarea type name="body" form="add_post"
                    class="textarea textarea-bordered textarea-lg w-full h-[300px] text-sm mb-2"
                    placeholder="Type post here..."></textarea>
                <div class="flex justify-center">
                    <input type="submit" name="submit" class="btn btn-success btn-outline btn-md text-xs"
                        value="Create" />
                </div>
            </form>
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
        </div>
    </div>
</dialog>
<button class="btn m-10" onclick="addNew.showModal()"><i class="fa-solid fa-plus scale-150"></i></button>
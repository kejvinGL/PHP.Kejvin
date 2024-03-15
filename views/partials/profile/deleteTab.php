<div class="flex flex-col items-center">
    <button class="btn btn-error w-[150px] mb-5" onclick="my_modal_1.showModal()">DELETE USER</button>
    <?php echo isset($_SESSION["errors"]["delete"]) ? showErrors('delete') : null; ?>
    <dialog id="my_modal_1" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Warning!</h3>
            <p class="py-4"><span class="text-xs text-gray-400">By Deleting User you can not recover lost
                    data!<br><br></span> <span class="text-sm"> Enter your password to continue:</span></p>
            <div class="modal-action flex flex-col">
                <form id="delete_form" class="inline-flex join" action="profile/deleteSelf" method="post">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="password" name="password" class="input input-bordered join-item w-full max-w-xs" id="enter_pass" placeholder="********" />
                    <input type="submit" name="submit" class="btn btn-outline join-item btn-error" id="deleteButton" value="Delete" />
                </form>
                <form method="dialog">
                    <button class="btn">Close</button>
                </form>
            </div>
        </div>
    </dialog>
</div>
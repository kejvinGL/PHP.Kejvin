<?php

/**
 * Adds messages to the session.
 *
 * @param array $messages An array of messages to be added.
 * @return void
 */
function addMessages($messages)
{
    $_SESSION['messages'] = array();
    foreach ($messages as  $message) {
        array_push($_SESSION['messages'], '<div role="alert" class="alert alert-success h-10 w-4/5 text-sm flex justify-start max-w-[700px] mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            ' . $message . '
            </div>');
    }
}


/**
 * Displays a message to the user if there is only one message in the session.
 *
 * @return void
 */
function showMessage()
{
    if (isset($_SESSION['messages'])) {
        echo '<span class="text-lg text-green-600">' . $_SESSION["messages"][0] . '</span> <br>';
        emptyMessages();
    }
}


/**
 * Displays a message to the user if there is an array of messages in the session.
 *
 * @return void
 */
function showMessages()
{
    if (isset($_SESSION['messages'])) {
        foreach ($_SESSION['messages'] as  $message) {
            echo $message ?? null;
        }
        emptyMessages();
    }
}




/**
 * Removes all messages from the session.
 *
 * @return void
 */
function emptyMessages()
{
    unset($_SESSION['messages']);
}

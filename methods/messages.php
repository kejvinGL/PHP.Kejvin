<?php

/**
 * Adds messages to the session.
 *
 * @param array $messages An array of messages to be added.
 * @return void
 */
function addMessages(array $messages): void
{
    $_SESSION['messages'] = $messages;
}


/**
 * Displays a message to the user if there is an array of messages in the session.
 *
 * @param $input
 * @return void
 */
function showMessages($input): void
{
    if (isset($_SESSION['messages'][$input])) {
        foreach ($_SESSION['messages'][$input] as  $message) {
            echo '<span class="text-lg text-green-600" >' . $message . '</span> <br>';
        }
    }
    emptyMessages($input);
}


/**
 * Removes all messages from the session.
 *
 * @param $input
 * @return void
 */
function emptyMessages($input): void
{
    unset($_SESSION['messages'][$input]);
}

<?php

/**
 * Adds messages to the session.
 *
 * @param array $messages An array of messages to be added.
 * @return void
 */
function addMessages($messages)
{
    $_SESSION['messages'] = $messages;
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
function showMessages($input)
{
    if (isset($_SESSION['messages'])) {
        foreach ($_SESSION['messages'][$input] as  $message) {
            echo '<span class="text-lg text-green-600" >' . $message . '</span> <br>';
        }
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

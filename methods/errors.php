<?php

/**
 * Adds an array of errors to the session 
 *
 * @param array $errors An array of errors to be added.
 * @return void
 */
function addErrors(array $errors): void
{
    $_SESSION["errors"] = $errors;
}

/**
 * Displays an error message in cases where there is an array of errors.
 *
 * @param mixed $input The input for which error messages should be displayed.
 * @return void
 */
function showErrors(mixed $input): void
{
    if (isset($_SESSION["errors"][$input])) {
        foreach ($_SESSION["errors"][$input] as $error) {
            echo '<span class="label-text-alt text-red-500">' . $error . '</span> <br>';
        }
    }

    emptyErrors($input);
}
function showErrorsLarge($input): void
{
    if (isset($_SESSION["errors"][$input])) {
        foreach ($_SESSION["errors"][$input] as $error) {
            echo '<span class="label-text-alt text-red-500 text-lg">' . $error . '</span> <br>';
        }
    }

    emptyErrors($input);
}


/**
 * Removes errors from a specific array in errors from the session.
 *
 * @param string $input The input to clear the error messages for.
 * @return void
 */
function emptyErrors(string $input): void
{
    unset($_SESSION['errors'][$input]);
}

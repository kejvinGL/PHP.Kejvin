<?php

/**
 * Adds an array of errors to the session 
 *
 * @param array $errors An array of errors to be added.
 * @return void
 */
function addErrors($errors)
{
    $_SESSION["errors"] = $errors;
}


/**
 * Displays an error message in cases where there is only one error.
 *
 * @return void
 */
function showError()
{
    if (isset($_SESSION["errors"])) {
        echo '<span class="text-lg text-red-500">' . $_SESSION["errors"][0] . '</span> <br>';
    }

    emptyError();
}


/**
 * Removes all errors from the session.
 *
 * @return void
 */
function emptyError()
{
    unset($_SESSION['errors']);
}




/**
 * Displays an error message in cases where there is an array of errors.
 *
 * @param mixed $input The input for which error messages should be displayed.
 * @return void
 */
function showErrors($input)
{
    if (isset($_SESSION["errors"][$input])) {
        foreach ($_SESSION["errors"][$input] as $error) {
            echo '<span class="label-text-alt text-red-500">' . $error . '</span> <br>';
        }
    }

    emptyErrors($input);
}
function showErrorsLarge($input)
{
    if (isset($_SESSION["errors"][$input])) {
        foreach ($_SESSION["errors"][$input] as $error) {
            echo '<span class="label-text-alt text-red-500 text-lg">' . $error . '</span> <br>';
        }
    }

    emptyErrors($input);
}


/**
 * Removes errors from a specific arra in errors from the session.
 *
 * @param mixed $input The input to clear the error messages for.
 * @return void
 */
function emptyErrors($input)
{
    unset($_SESSION['errors'][$input]);
}


/**
 * Displays the errors of an associtated array for each input.
 *
 * @param array $input The input data containing the errors.
 * @param string $field The name of the input field.
 * @return void
 */
function showErrorsAssoc($input, $field)
{
    if (isset($_SESSION["errors"])) {
        foreach ($_SESSION["errors"][$input][$field] as $error) {
            echo '<span class="label-text-alt text-red-500">' . $error . '</span> <br>';
        }
    }

    emptyErrorsAssoc($input, $field);
}


/**
 * Removes the errors of an associated array for an input.
 *
 * @param array $input The input array containing the errors.
 * @param string $field The field name to check for errors.
 * @return bool Returns true if there are no errors associated with the field, false otherwise.
 */
function emptyErrorsAssoc($input, $field)
{
    unset($_SESSION['errors'][$input][$field]);
}

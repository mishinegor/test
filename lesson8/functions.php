<?php

function validate_input($data_input) {
    $data_input = trim($data_input);
    $data_input = stripslashes($data_input);
    $data_input = htmlspecialchars($data_input);
    return $data_input;
}

 ?>

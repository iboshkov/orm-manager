<?php

function humanize_attribute($var) {
    $studly = studly_case($var);
    // Split at capital letters
    $pieces = preg_split('/(?=[A-Z]+)/', $studly);

    return join($pieces, " ");
}

<?php
declare (strict_types=1);

function is_input_empty($email, $pwd) {
    if (empty($email) ||  empty($pwd)){
        return true;
    } else{
        return false;
    }
}

function is_email_wrong($result) {
    return !$result || !is_array($result);
}

function is_password_wrong($pwd, $hashed_pwd){
    if (!password_verify($pwd, $hashed_pwd)){
        return true;
    } else{
        return false;
    }
}
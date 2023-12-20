<?php

function signupValidation($data)
{
    $isValid = true;
    //username >1 caractere
    $usernameIsValidData = usernameIsValid($data['username']);
    $error_username = $usernameIsValidData['msg'];
    $isValid = $usernameIsValidData['isValid'];

    //email voir regex
    $emailIsValidData = emailIsValid($data['email']);
    $error_email = $emailIsValidData['msg'];

    if ($isValid) {
        $isValid = $emailIsValidData['isValid'];
    }


    //pwd
    $error_pwd = '';
    $pwdIsValidData = pwdLenghtValidation($data['password']);
    $error_pwd = $pwdIsValidData['msg'];
    if ($isValid) {
        $isValid = $pwdIsValidData['isValid'];
    }


    return [
        "isValid" => $isValid,
        "error_username" => $error_username,
        "error_email" => $error_email,
        "error_pwd" => $error_pwd,
    ];
}

function usernameIsValid($username)
{
    if (strlen($username) < 2) {

        return [
            'isValid' => false,
            'msg' => "Votre nom d'utilisateur est trop court. il doit faire plus d'un caractère."
        ];
    }
    //get user by username
    $userInDB = getUserByUsername($username);

    if ($userInDB) {
        //error exist déja 
        return [
            'isValid' => false,
            'msg' => "Votre nom d'utilisateur est déjà utilisé."
        ];
    }

    return [
        'isValid' => true,
        'msg' => ''
    ];
}

function emailIsValid($email)
{

    $email_validation_regex = "/^[a-z0-9!#$%&'*+\\/=?^_`{|}~-]+(?:\\.[a-z0-9!#$%&'*+\\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/";
    if (!preg_match($email_validation_regex, $email)) {
        return [
            'isValid' => false,
            'msg' => "Format d'email invalid",
        ];
    }
    return [
        'isValid' => true,
        'msg' => '',
    ];
}

function pwdLenghtValidation($pwd)
{
    //minimum 8 max 16
    $length = strlen($pwd);

    if ($length < 8) {
        return [
            'isValid' => false,
            'msg' => 'Votre mot de passe est trop court. Doit être supérieur a 8 caractères'
        ];
    } elseif ($length > 16) {
        return [
            'isValid' => false,
            'msg' => 'Votre mot de passe est trop long. Doit être inférieur a 16 caractères'
        ];
    }
    return [
        'isValid' => true,
        'msg' => ''
    ];
}
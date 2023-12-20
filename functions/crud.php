<?php

function createUser($data)
{

    global $conn;

    $query = "INSERT INTO user (email, password, username, role_id, billing_address_id, shipping_address_id, id) VALUES (?, ?, ?, 2, NULL,NULL, NULL)";

    if ($stmt = mysqli_prepare($conn, $query)) {

        mysqli_stmt_bind_param(
            $stmt,
            "sss",
            $data['email'],
            $data['password'],
            $data['username']
        );

        $result = mysqli_stmt_execute($stmt);

        return $result;
    }
}

function getUserByUsername($username)
{
    global $conn;

    $query = "SELECT * FROM user WHERE username = '" . $username . "';";

    $result = mysqli_query($conn, $query);

    // avec fetch row : tableau indexé
    $data = mysqli_fetch_assoc($result);
    return $data;
}
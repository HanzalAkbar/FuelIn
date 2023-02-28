<?php
/*
 * Copyright (c) 2023. Hanzal Akbar
 */

namespace Fuelin;

use AllowDynamicProperties;
use mysqli_result;

#[AllowDynamicProperties] class UserController
{

    /**
     *
     */
    public function __construct()
    {
        $db = new DatabaseConnection;
        $this->conn = $db->conn;
    }

    /**
     * @param $value
     * @return string
     */
    public function escape_string($value): string
    {
        return $this->conn->real_escape_string($value);
    }

    /**
     * @param $username
     * @param $password
     * @return false|array
     */
    public function check_login($username, $password): false|array
    {
        $userQuery = "SELECT user.Username, user.Password FROM user WHERE Username='$username' LIMIT 1";
        $result = $this->conn->query($userQuery);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if (password_verify($password, $row['Password'])) {
                    $userQuery2 = "SELECT user.UserId, user.Category, user.FillingStationId FROM user WHERE Username='" . $row['Username'] . "' LIMIT 1";
                    $result2 = $this->conn->query($userQuery2);
                    $nrow = $result2->fetch_assoc();
                    return [$nrow['Category'], $nrow['FillingStationId'], $nrow['UserId']];
                }
            }
        }
        return false;
    }

    /**
     * @param $category
     * @param $id
     * @return mysqli_result|bool
     */
    public function index($category, $id): mysqli_result|bool
    {
        $userQuery = "SELECT user.UserId, user.Category, user.Email, user.Username, user.FillingStationId FROM user WHERE UserId='$id'";
        if ($category === 'Admin') {
            $userQuery = "SELECT user.UserId, user.Category, user.Email, user.Username, user.FillingStationId FROM user";
        }
        $result = $this->conn->query($userQuery);
        if ($result->num_rows > 0) {
            return $result;
        }
        return false;
    }

    /**
     * @return mysqli_result|bool
     */
    public function primes(): mysqli_result|bool
    {
        $userQuery = "SELECT DISTINCT user.UserId FROM user";
        $result = $this->conn->query($userQuery);
        if ($result->num_rows > 0) {
            return $result;
        }
        return false;
    }

    /**
     * @param $inputData
     * @return bool
     */
    public function create($inputData): bool
    {
        $category = $inputData['category'];
        $email = $inputData['email'];
        $username = $inputData['username'];
        $password = password_hash($inputData['password'], PASSWORD_DEFAULT);
        $fillingstationid = $inputData['fillingstationid'];

        $userQueryn = "SELECT user.Username FROM user WHERE Username='$username' LIMIT 1";
        $resultn = $this->conn->query($userQueryn);
        if ($resultn->num_rows <= 0) {
            $userQuery = "INSERT INTO user (Category, Email, Username, Password, FillingStationId) VALUES ('$category', '$email' ,'$username','$password','$fillingstationid')";
            $result = $this->conn->query($userQuery);
            if ($result) {
                return true;
            }
        }
        return false;

    }

    /**
     * @param $id
     * @return false|array|null
     */
    public function edit($id): false|array|null
    {
        $user_id = mysqli_real_escape_string($this->conn, $id);
        $userQuery = "SELECT * FROM user WHERE UserId='$user_id' LIMIT 1";
        $result = $this->conn->query($userQuery);
        if ($result->num_rows == 1) {
            return $result->fetch_assoc();
        }
        return false;
    }

    /**
     * @param $inputData
     * @param $id
     * @return bool
     */
    public function update($inputData, $id): bool
    {
        $user_id = mysqli_real_escape_string($this->conn, $id);
        $category = $inputData['category'];
        $email = $inputData['email'];
        $username = $inputData['username'];
        $password = password_hash($inputData['password'], PASSWORD_DEFAULT);
        $fillingstationid = $inputData['fillingstationid'];

        $userQuery = "UPDATE user SET Category='$category', Email='$email', FillingStationId='$fillingstationid', Username='$username', Password='$password' WHERE UserId='$user_id' LIMIT 1";
        $result = $this->conn->query($userQuery);
        if ($result) {
            return true;
        }
        return false;

    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        $user_id = mysqli_real_escape_string($this->conn, $id);
        $userQuery = "DELETE FROM user WHERE UserId='$user_id' LIMIT 1";
        $result = $this->conn->query($userQuery);
        if ($result) {
            return true;
        }
        return false;

    }
}
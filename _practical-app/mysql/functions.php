<?php

include "db.php";

// Function to show all data in a select dropdown
function showAllData()
{
    global $CONNECTION;
    $query = "SELECT id, username FROM users";
    $result = mysqli_query($CONNECTION, $query);
    if (!$result) {
        die("MYSQL QUERY FAILED: " . mysqli_error($CONNECTION));
    }
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='" . $row['id'] . "'>" . $row['username'] . "</option>";
    }
}

// Function to update user data
function updateTable()
{
    global $CONNECTION;

    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['id'])) {
        $username = mysqli_real_escape_string($CONNECTION, $_POST['username']);
        $password = mysqli_real_escape_string($CONNECTION, $_POST['password']);
        $id = mysqli_real_escape_string($CONNECTION, $_POST['id']);

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Create query with concatenated strings
        $query = "UPDATE users SET ";
        $query .= "username = '" . $username . "', ";
        $query .= "password = '" . $passwordHash . "' ";
        $query .= "WHERE id = '" . $id . "'";
        $result = mysqli_query($CONNECTION, $query);

        if (!$result) {
            die("MYSQL QUERY FAILED: " . mysqli_error($CONNECTION));
        } else {
            echo "User updated successfully.";
        }
    } else {
        echo "Please fill in all fields.";
    }
}

// Function to delete a user
function deleteRows()
{
    global $CONNECTION;

    if (isset($_POST['id'])) {
        $id = mysqli_real_escape_string($CONNECTION, $_POST['id']);

        // Create query with concatenated strings
        $query = "DELETE FROM users WHERE id = '" . $id . "'";
        $result = mysqli_query($CONNECTION, $query);

        if (!$result) {
            die("MYSQL QUERY FAILED: " . mysqli_error($CONNECTION));
        } else {
            echo "User Deleted Successfully.";
        }
    } else {
        echo "Please fill in all fields.";
    }
}

// Function to create a new user
function createRows()
{
    global $CONNECTION;

    if (isset($_POST['submit'])) {
        $username = mysqli_real_escape_string($CONNECTION, $_POST['username']);
        $password = mysqli_real_escape_string($CONNECTION, $_POST['password']);
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        if (empty($username) || empty($password)) {
            die('Please fill out both fields.');
        }

        // Create query with concatenated strings
        $query = "INSERT INTO users (username, password) VALUES ('" . $username . "', '" . $passwordHash . "')";
        $result = mysqli_query($CONNECTION, $query);

        if ($result) {
            echo "User registered successfully.";
        } else {
            die('QUERY FAILED: ' . mysqli_error($CONNECTION));
        }

        mysqli_close($CONNECTION);
    }
}

// Function to read and display all users
function readRows()
{
    global $CONNECTION;

    // Create query
    $query = "SELECT * FROM users";
    $result = mysqli_query($CONNECTION, $query);

    if (!$result) {
        die("MYSQL QUERY FAILED: " . mysqli_error($CONNECTION));
    }

    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $username = $row['username'];
        $password = $row['password'];

        // Output data as HTML table rows
        echo "<tr>";
        echo "<th scope='row'>" . $id . "</th>";
        echo "<td>" . $username . "</td>";
        echo "<td>" . $password . "</td>";
        echo "<td><a href='login_update.php?id=" . $id . "'>Edit</a></td>";
        echo "</tr>";
    }
}

?>

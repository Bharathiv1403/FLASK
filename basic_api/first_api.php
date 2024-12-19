<?php
header("Content-Type: application/json");

// Database connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "api_demo";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed."]));
}

// Get the request method
$method = $_SERVER['REQUEST_METHOD'];

// API Logic
switch ($method) {
    case 'GET':
        // Fetch all users or a specific user
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $query = "SELECT * FROM users WHERE id = $id";
        } else {
            $query = "SELECT * FROM users";
        }

        $result = $conn->query($query);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode(["status" => "success", "data" => $data]);
        break;

    case 'POST':
        // Create a new user
        $input = json_decode(file_get_contents("php://input"), true);
        $name = $input['name'];
        $email = $input['email'];

        $query = "INSERT INTO users (name, email) VALUES ('$name', '$email')";
        if ($conn->query($query) === TRUE) {
            echo json_encode(["status" => "success", "message" => "User created successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to create user."]);
        }
        break;

    case 'PUT':
        // Update an existing user
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $input = json_decode(file_get_contents("php://input"), true);
            $name = $input['name'];
            $email = $input['email'];

            $query = "UPDATE users SET name='$name', email='$email' WHERE id=$id";
            if ($conn->query($query) === TRUE) {
                echo json_encode(["status" => "success", "message" => "User updated successfully."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to update user."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "ID is required for updating."]);
        }
        break;

    case 'DELETE':
        // Delete a user
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $query = "DELETE FROM users WHERE id=$id";
            if ($conn->query($query) === TRUE) {
                echo json_encode(["status" => "success", "message" => "User deleted successfully."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to delete user."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "ID is required for deletion."]);
        }
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Invalid request method."]);
        break;
}

$conn->close();
?>

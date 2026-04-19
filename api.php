<?php
session_start();
include 'db.php';
header('Content-Type: application/json'); // Always reply in JSON format

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == 'check_user') {
    // Tells the HTML if someone is logged in
    if (isset($_SESSION['user_id'])) {
        echo json_encode(["logged_in" => true, "username" => $_SESSION['username'], "user_id" => $_SESSION['user_id']]);
    } else {
        echo json_encode(["logged_in" => false]);
    }
} 
elseif ($action == 'logout') {
    session_destroy();
    echo json_encode(["success" => true]);
} 
elseif ($action == 'signup') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    
    if ($check->get_result()->num_rows > 0) {
        echo json_encode(["success" => false, "message" => "Username taken!"]);
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name, email, username, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $username, $password);
        $stmt->execute();
        echo json_encode(["success" => true]);
    }
} 
elseif ($action == 'login') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Wrong username or password"]);
    }
} 
elseif ($action == 'get_posts') {
    // Get all posts for the feed
    $sql = "SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.created_at DESC";
    $result = $conn->query($sql);
    $posts = [];
    while($row = $result->fetch_assoc()) { $posts[] = $row; }
    echo json_encode($posts);
} 
elseif ($action == 'get_single_post') {
    // Get one post (used for the edit page)
    $stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    echo json_encode($stmt->get_result()->fetch_assoc());
}
elseif ($action == 'create_post') {
    if(isset($_SESSION['user_id'])) {
        $stmt = $conn->prepare("INSERT INTO posts (user_id, title, content, tags) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $_SESSION['user_id'], $_POST['title'], $_POST['content'], $_POST['tags']);
        $stmt->execute();
        echo json_encode(["success" => true]);
    }
} 
elseif ($action == 'update_post') {
    if(isset($_SESSION['user_id'])) {
        $stmt = $conn->prepare("UPDATE posts SET title=?, content=?, tags=? WHERE id=? AND user_id=?");
        $stmt->bind_param("sssii", $_POST['title'], $_POST['content'], $_POST['tags'], $_POST['id'], $_SESSION['user_id']);
        $stmt->execute();
        echo json_encode(["success" => true]);
    }
} 
elseif ($action == 'delete_post') {
    if(isset($_SESSION['user_id'])) {
        $stmt = $conn->prepare("DELETE FROM posts WHERE id=? AND user_id=?");
        $stmt->bind_param("ii", $_POST['id'], $_SESSION['user_id']);
        $stmt->execute();
        echo json_encode(["success" => true]);
    }
}
?>
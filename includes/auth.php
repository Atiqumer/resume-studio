<?php
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getUser($pdo) {
    if (!isLoggedIn()) return null;
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function requireAuth() {
    if (!isLoggedIn()) {
        header('Location: index.php');
        exit();
    }
}
?>
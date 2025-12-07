<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';

if (!isLoggedIn()) {
    header('Location: ../index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resume_id = $_POST['resume_id'] ?? null;
    
    if (!$resume_id) {
        $_SESSION['error'] = "Resume ID is required";
        header('Location: ../dashboard.php');
        exit();
    }
    
    // Verify that the resume belongs to the logged-in user
    $stmt = $pdo->prepare("SELECT id FROM resumes WHERE id = ? AND user_id = ?");
    $stmt->execute([$resume_id, $_SESSION['user_id']]);
    $resume = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$resume) {
        $_SESSION['error'] = "Resume not found or you don't have permission to delete it";
        header('Location: ../dashboard.php');
        exit();
    }
    
    // Delete the resume
    $stmt = $pdo->prepare("DELETE FROM resumes WHERE id = ? AND user_id = ?");
    $result = $stmt->execute([$resume_id, $_SESSION['user_id']]);
    
    if ($result) {
        $_SESSION['success'] = "Resume deleted successfully";
    } else {
        $_SESSION['error'] = "Failed to delete resume";
    }
    
    header('Location: ../dashboard.php');
    exit();
} else {
    // If not POST request, redirect to dashboard
    header('Location: ../dashboard.php');
    exit();
}
?>
<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';

if (!isLoggedIn()) {
    header('Location: ../index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resume_id = $_POST['resume_id'] ?? null;
    $title = $_POST['title'] ?? 'Untitled Resume';
    $template = $_POST['template'] ?? 'template1'; // Get template from POST
    
    // Debug: log the template value
    error_log("Saving resume with template: " . $template);
    
    $data = [
        'personal_info' => $_POST['personal_info'] ?? [],
        'experience' => $_POST['experience'] ?? [],
        'education' => $_POST['education'] ?? [],
        'skills' => $_POST['skills'] ?? []
    ];
    
    if ($resume_id) {
        // Update existing resume
        $stmt = $pdo->prepare("UPDATE resumes SET title = ?, template = ?, personal_info = ?, experience = ?, education = ?, skills = ?, updated_at = NOW() WHERE id = ? AND user_id = ?");
        $stmt->execute([
            $title, 
            $template,
            json_encode($data['personal_info']), 
            json_encode($data['experience']), 
            json_encode($data['education']), 
            json_encode($data['skills']), 
            $resume_id, 
            $_SESSION['user_id']
        ]);
    } else {
        // Create new resume
        $stmt = $pdo->prepare("INSERT INTO resumes (user_id, title, template, personal_info, experience, education, skills) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_SESSION['user_id'], 
            $title, 
            $template,
            json_encode($data['personal_info']), 
            json_encode($data['experience']), 
            json_encode($data['education']), 
            json_encode($data['skills'])
        ]);
        $resume_id = $pdo->lastInsertId();
    }
    
    header("Location: ../create_resume.php?id=$resume_id");
    exit();
}
?>
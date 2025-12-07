<?php
require_once '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $template = $_POST['template'] ?? 'template1';
    
    // Prepare data from form
    $data = [
        'personal_info' => [
            'full_name' => $_POST['personal_info']['full_name'] ?? '',
            'email' => $_POST['personal_info']['email'] ?? '',
            'phone' => $_POST['personal_info']['phone'] ?? '',
            'linkedin' => $_POST['personal_info']['linkedin'] ?? '',
            'summary' => $_POST['personal_info']['summary'] ?? ''
        ],
        'experience' => $_POST['experience'] ?? [],
        'education' => $_POST['education'] ?? [],
        'skills' => $_POST['skills'] ?? []
    ];
    
    // Load and render template (web version)
    if (file_exists("../templates/$template.php")) {
        require_once "../templates/$template.php";
        $function = "render$template";
        if (function_exists($function)) {
            $function($data, false); // Pass false for web version
        }
    } else {
        echo "<p class='text-red-500'>Template not found</p>";
    }
}
?>
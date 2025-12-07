<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';

if (!isLoggedIn()) {
    header('Location: ../index.php');
    exit();
}

// Include DomPDF manually
require_once '../dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$resume_id = $_GET['id'] ?? null;
if (!$resume_id) {
    die("Resume ID required");
}

// Get resume data including template
$stmt = $pdo->prepare("SELECT * FROM resumes WHERE id = ? AND user_id = ?");
$stmt->execute([$resume_id, $_SESSION['user_id']]);
$resume = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$resume) {
    die("Resume not found");
}

// Use the template saved in the database
$template = $resume['template'] ?? 'template1';
error_log("Generating PDF with template: " . $template); // For debugging

if (!file_exists("../templates/$template.php")) {
    die("Template not found: " . $template);
}

require_once "../templates/$template.php";

// Prepare data
$data = [
    'personal_info' => json_decode($resume['personal_info'], true) ?? [],
    'experience' => json_decode($resume['experience'], true) ?? [],
    'education' => json_decode($resume['education'], true) ?? [],
    'skills' => json_decode($resume['skills'], true) ?? []
];

// Start output buffering
ob_start();
$function = "render$template";
if (function_exists($function)) {
    $function($data, true); // Pass true for PDF version
} else {
    die("Template function not found: " . $function);
}
$html = ob_get_clean();

// Configure DomPDF
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$options->set('defaultFont', 'DejaVu Sans');
$options->set('chroot', realpath('../'));
$options->set('isPhpEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html, 'UTF-8');
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Output PDF
$filename = "resume-" . preg_replace('/[^a-zA-Z0-9_-]/', '_', $resume['title']) . ".pdf";
$dompdf->stream($filename, [
    "Attachment" => true
]);
?>
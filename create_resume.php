<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

if (!isLoggedIn()) {
    header('Location: index.php');
    exit();
}

$resume_id = $_GET['id'] ?? null;
$resume = null;
$personal_info = [];
$experience = [];
$education = [];
$skills = [];
$template = 'template1';

if ($resume_id) {
    // Edit existing resume
    $stmt = $pdo->prepare("SELECT * FROM resumes WHERE id = ? AND user_id = ?");
    $stmt->execute([$resume_id, $_SESSION['user_id']]);
    $resume = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($resume) {
        $personal_info = json_decode($resume['personal_info'], true) ?? [];
        $experience = json_decode($resume['experience'], true) ?? [];
        $education = json_decode($resume['education'], true) ?? [];
        $skills = json_decode($resume['skills'], true) ?? [];
        $template = $resume['template'] ?? 'template1';
    } else {
        $resume_id = null; // Resume doesn't belong to user
    }
}

$user = getUser($pdo);

// Define available templates for the selector with placeholder image URLs
$templates = [
    'template1' => ['name' => 'Classic Pro', 'icon' => 'article', 'color' => 'blue', 'image_url' => 'assets/template_previews/classic_pro.jpg'],
    'template2' => ['name' => 'Modern Grid', 'icon' => 'view_comfy', 'color' => 'indigo', 'image_url' => 'assets/template_previews/creative_flow.jpg'],
    'template3' => ['name' => 'Creative Flow', 'icon' => 'format_paint', 'color' => 'teal', 'image_url' => 'assets/template_previews/modern_grid.jpg' ]
];

$current_template = $resume['template'] ?? 'template1';
?>

<!DOCTYPE html>
<html class="light" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <title><?= $resume ? 'Edit Resume' : 'Create New Resume' ?> - ResumeStudio</title>
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap"
            rel="stylesheet"
        />
        <link
            href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined"
            rel="stylesheet"
        />
        <script id="tailwind-config">
            tailwind.config = {
                darkMode: "class",
                theme: {
                    extend: {
                        colors: {
                            primary: "#308ce8",
                            "background-light": "#ffffff", /* Changed from f6f7f8 for a cleaner look */
                            "background-dark": "#0a0f16", /* Matched dashboard dark background */
                            'primary-800': '#1e5f9e', // Custom color for skill tag text
                            'primary-200': '#93c5fd', // Custom color for dark mode skill tag text
                        },
                        fontFamily: {
                            display: ["Inter", "sans-serif"],
                        },
                        borderRadius: {
                            DEFAULT: "0.5rem", /* Consistent with dashboard */
                            lg: "0.75rem",
                            xl: "1rem",
                            "2xl": "1.5rem",
                            full: "9999px",
                        },
                    },
                },
            };
        </script>
        <style>
            .material-symbols-outlined {
                font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 24;
            }
            .gradient-text {
                background: linear-gradient(135deg, #308ce8 0%, #60a5fa 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }
            .form-input {
                @apply flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-slate-900 dark:text-slate-50 focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 focus:border-primary h-12 placeholder:text-slate-400 dark:placeholder:text-slate-500 px-4 text-sm font-normal;
            }
            .form-textarea {
                @apply flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-slate-900 dark:text-slate-50 focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 focus:border-primary h-24 placeholder:text-slate-400 dark:placeholder:text-slate-500 px-4 py-3 text-sm font-normal;
            }
        </style>
    </head>
    <body 
        class="font-display bg-slate-50 dark:bg-background-dark text-slate-800 dark:text-slate-200 min-h-screen"
    >
        <div class="relative flex min-h-screen w-full flex-col">
            <div class="fixed inset-0 pointer-events-none overflow-hidden">
                <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-80 h-80 bg-blue-400/5 rounded-full blur-3xl"></div>
            </div>

            <header
                class="sticky top-0 z-50 bg-white/80 dark:bg-background-dark/80 backdrop-blur-sm border-b border-slate-200/50 dark:border-slate-700/50"
            >
                <div
                    class="mx-auto flex max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8 py-4"
                >
                <a href="dashboard.php" class="flex items-center gap-3 group cursor-pointer">
                    <div class="flex items-center gap-3 group cursor-pointer">
                        <div class="text-primary bg-primary/10 p-2 rounded-xl group-hover:scale-110 transition-transform duration-300">
                            <span class="material-symbols-outlined text-2xl">description</span>
                        </div>
                        <h2 class="text-[#0e141b] dark:text-slate-50 text-xl font-black tracking-tight">
                            Resume<span class="gradient-text">Studio</span>
                        </h2>
                    </div>
        </a>
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-3 px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-gradient-to-br from-primary to-blue-500 text-white font-bold text-sm">
                                <?= strtoupper(substr($user['name'], 0, 1)) ?>
                            </div>
                            <span
                                class="text-sm font-semibold text-slate-700 dark:text-slate-300 hidden sm:inline"
                                ><?= htmlspecialchars($user['name']) ?></span
                            >
                        </div>
                        <a
                            href="process/logout.php"
                            class="flex h-10 cursor-pointer items-center justify-center gap-2 overflow-hidden rounded-xl px-4 text-sm font-semibold bg-slate-200 hover:bg-slate-300 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 transition-all duration-300 hover:scale-105"
                        >
                            <span class="material-symbols-outlined text-lg">logout</span>
                            <span class="truncate hidden sm:inline">Logout</span>
                        </a>
                    </div>
                </div>
            </header>

            <main class="flex-1 relative z-10">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8 md:py-12">
                    <form id="resumeForm" method="POST" action="process/save_resume.php">
                        <input type="hidden" name="resume_id" value="<?= $resume_id ?>">
                        
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                            <div class="flex flex-col gap-8 lg:col-span-6">
                                <a
                                    href="dashboard.php"
                                    class="flex w-fit max-w-full cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 px-4 bg-slate-200/50 dark:bg-slate-800/50 text-slate-700 dark:text-slate-300 gap-2 text-sm font-semibold leading-normal hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors"
                                >
                                    <span class="material-symbols-outlined text-base">arrow_back</span>
                                    <span class="truncate">Back to Dashboard</span>
                                </a>

                                <div class="bg-white dark:bg-slate-900/50 p-6 rounded-xl shadow-lg border border-slate-200 dark:border-slate-800">
                                    <h3 class="text-xl font-bold text-slate-900 dark:text-slate-50 mb-4">
                                        <span class="material-symbols-outlined align-middle mr-2 text-primary">edit_document</span>
                                        Resume Details
                                    </h3>
                                    <label class="flex flex-col">
                                        <p class="text-slate-700 dark:text-slate-300 text-sm font-medium leading-normal pb-2">Resume Title</p>
                                        <input
                                            name="title"
                                            class="form-input"
                                            placeholder="e.g., Software Engineer Resume"
                                            value="<?= htmlspecialchars($resume['title'] ?? 'My Resume') ?>"
                                        />
                                    </label>
                                </div>
                                
                                <div class="bg-white dark:bg-slate-900/50 p-6 rounded-xl shadow-lg border border-slate-200 dark:border-slate-800">
                                    <h3 class="text-xl font-bold text-slate-900 dark:text-slate-50 mb-4">
                                        <span class="material-symbols-outlined align-middle mr-2 text-primary">palette</span>
                                        Choose Template
                                    </h3>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                        <?php foreach ($templates as $template_key => $template_info): ?>
                                            <?php $is_selected = $current_template === $template_key; ?>
                                            <label class="relative cursor-pointer transition-all hover:scale-[1.02] duration-300">
                                                <input type="radio" name="template" value="<?= $template_key ?>" 
                                                       <?= $is_selected ? 'checked' : '' ?> 
                                                       class="hidden template-radio">
                                                <div class="p-3 rounded-xl border-2 transition-all h-full flex flex-col items-center justify-between 
                                                            <?= $is_selected ? 'border-primary shadow-xl shadow-primary/20 bg-primary/10' : 'border-slate-300 dark:border-slate-700 hover:border-primary dark:hover:border-primary' ?>">
                                                    
                                                    <div class="w-full rounded-lg overflow-hidden border border-slate-200 dark:border-slate-700 shadow-md aspect-[4/5] sm:aspect-[3/4] bg-slate-100 dark:bg-slate-800">
                                                        <img 
                                                            src="<?= $template_info['image_url'] ?? '' ?>" 
                                                            alt="Preview of <?= $template_info['name'] ?> Template" 
                                                            class="w-full h-full object-cover"
                                                            onerror="this.onerror=null;this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'100%\' height=\'100%\' viewBox=\'0 0 100 130\'><rect width=\'100\' height=\'130\' fill=\'#f1f5f9\'/><text x=\'50%\' y=\'50%\' dominant-baseline=\'middle\' text-anchor=\'middle\' font-size=\'10\' fill=\'#94a3b8\'>Template Preview</text><rect x=\'10\' y=\'10\' width=\'80\' height=\'20\' fill=\'<?= $template_info['color'] === 'blue' ? '#308ce8' : ($template_info['color'] === 'indigo' ? '#4f46e5' : '#10b981') ?>\'/><rect x=\'10\' y=\'40\' width=\'30\' height=\'5\' fill=\'#94a3b8\'/><rect x=\'10\' y=\'50\' width=\'80\' height=\'3\' fill=\'#cbd5e1\'/><rect x=\'10\' y=\'60\' width=\'80\' height=\'3\' fill=\'#cbd5e1\'/><rect x=\'10\' y=\'75\' width=\'80\' height=\'5\' fill=\'#94a3b8\'/><rect x=\'10\' y=\'85\' width=\'80\' height=\'3\' fill=\'#cbd5e1\'/></svg>'"
                                                        >
                                                    </div>
                                                    
                                                    <div class="flex items-center gap-2 mt-3">
                                                        <span class="material-symbols-outlined text-lg" style="color: <?= $template_info['color'] === 'blue' ? '#308ce8' : ($template_info['color'] === 'indigo' ? '#4f46e5' : '#10b981') ?>;">
                                                            <?= $template_info['icon'] ?>
                                                        </span>
                                                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-300"><?= $template_info['name'] ?></p>
                                                    </div>
                                                </div>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-6">
                                    <details
                                        class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/50 shadow-lg p-6 group"
                                        open
                                    >
                                        <summary class="flex cursor-pointer items-center justify-between gap-6 pb-2 border-b border-slate-100 dark:border-slate-800/50">
                                            <p class="text-slate-900 dark:text-slate-50 text-xl font-bold leading-normal flex items-center">
                                                <span class="material-symbols-outlined mr-2 text-primary">person</span>
                                                Personal Info
                                            </p>
                                            <span class="material-symbols-outlined text-slate-500 dark:text-slate-400 group-open:rotate-180 transition-transform">expand_more</span>
                                        </summary>
                                        <div class="pt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <label class="flex flex-col col-span-2">
                                                <p class="text-slate-700 dark:text-slate-300 text-sm font-medium leading-normal pb-2">Full Name</p>
                                                <input
                                                    name="personal_info[full_name]"
                                                    class="form-input"
                                                    placeholder="Jane Doe"
                                                    value="<?= htmlspecialchars($personal_info['full_name'] ?? '') ?>"
                                                />
                                            </label>
                                            <label class="flex flex-col">
                                                <p class="text-slate-700 dark:text-slate-300 text-sm font-medium leading-normal pb-2">Email</p>
                                                <input
                                                    name="personal_info[email]"
                                                    class="form-input"
                                                    placeholder="jane.doe@example.com"
                                                    type="email"
                                                    value="<?= htmlspecialchars($personal_info['email'] ?? '') ?>"
                                                />
                                            </label>
                                            <label class="flex flex-col">
                                                <p class="text-slate-700 dark:text-slate-300 text-sm font-medium leading-normal pb-2">Phone</p>
                                                <input
                                                    name="personal_info[phone]"
                                                    class="form-input"
                                                    placeholder="(123) 456-7890"
                                                    type="tel"
                                                    value="<?= htmlspecialchars($personal_info['phone'] ?? '') ?>"
                                                />
                                            </label>
                                            <label class="flex flex-col col-span-2">
                                                <p class="text-slate-700 dark:text-slate-300 text-sm font-medium leading-normal pb-2">LinkedIn Profile (URL)</p>
                                                <input
                                                    name="personal_info[linkedin]"
                                                    class="form-input"
                                                    placeholder="linkedin.com/in/janedoe"
                                                    value="<?= htmlspecialchars($personal_info['linkedin'] ?? '') ?>"
                                                />
                                            </label>
                                            <label class="flex flex-col col-span-2">
                                                <p class="text-slate-700 dark:text-slate-300 text-sm font-medium leading-normal pb-2">Professional Summary</p>
                                                <textarea
                                                    name="personal_info[summary]"
                                                    class="form-textarea h-32"
                                                    placeholder="Brief overview of your professional background and career goals..."
                                                ><?= htmlspecialchars($personal_info['summary'] ?? '') ?></textarea>
                                            </label>
                                        </div>
                                    </details>

                                    <details
                                        class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/50 shadow-lg p-6 group"
                                    >
                                        <summary class="flex cursor-pointer items-center justify-between gap-6 pb-2 border-b border-slate-100 dark:border-slate-800/50">
                                            <p class="text-slate-900 dark:text-slate-50 text-xl font-bold leading-normal flex items-center">
                                                <span class="material-symbols-outlined mr-2 text-primary">work</span>
                                                Experience
                                            </p>
                                            <span class="material-symbols-outlined text-slate-500 dark:text-slate-400 group-open:rotate-180 transition-transform">expand_more</span>
                                        </summary>
                                        <div class="mt-6 space-y-6" id="experience-container">
                                            <?php if (empty($experience)): ?>
                                                <p class="text-slate-500 dark:text-slate-400 text-sm font-normal leading-normal text-center empty-state-message">
                                                    No experience added yet. Click **Add Experience** below.
                                                </p>
                                            <?php endif; ?>
                                            <?php foreach ($experience as $index => $exp): ?>
                                                <div class="experience-item rounded-lg p-4 bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-inner">
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                        <label class="flex flex-col">
                                                            <p class="text-slate-700 dark:text-slate-300 text-sm font-medium leading-normal pb-2">Job Title</p>
                                                            <input name="experience[<?= $index ?>][job_title]" value="<?= htmlspecialchars($exp['job_title'] ?? '') ?>" class="form-input" placeholder="Software Engineer">
                                                        </label>
                                                        <label class="flex flex-col">
                                                            <p class="text-slate-700 dark:text-slate-300 text-sm font-medium leading-normal pb-2">Company</p>
                                                            <input name="experience[<?= $index ?>][company]" value="<?= htmlspecialchars($exp['company'] ?? '') ?>" class="form-input" placeholder="Tech Company Inc.">
                                                        </label>
                                                        <label class="flex flex-col">
                                                            <p class="text-slate-700 dark:text-slate-300 text-sm font-medium leading-normal pb-2">Duration</p>
                                                            <input name="experience[<?= $index ?>][duration]" value="<?= htmlspecialchars($exp['duration'] ?? '') ?>" class="form-input" placeholder="Jan 2020 - Present">
                                                        </label>
                                                        <div class="col-span-2 flex items-center gap-4">
                                                            <label class="flex items-center text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer">
                                                                <input type="checkbox" name="experience[<?= $index ?>][is_current]" value="1" <?= (isset($exp['is_current']) && $exp['is_current']) ? 'checked' : '' ?> class="rounded border-gray-300 text-primary shadow-sm focus:border-primary focus:ring focus:ring-primary/50 dark:bg-slate-700 dark:border-slate-600">
                                                                <span class="ml-2">Currently Work Here</span>
                                                            </label>
                                                        </div>
                                                        <label class="flex flex-col col-span-2">
                                                            <p class="text-slate-700 dark:text-slate-300 text-sm font-medium leading-normal pb-2">Description (Bullet points recommended)</p>
                                                            <textarea name="experience[<?= $index ?>][description]" class="form-textarea h-24" placeholder="- Developed feature X with Y technology&#10;- Achieved Z result..."><?= htmlspecialchars($exp['description'] ?? '') ?></textarea>
                                                        </label>
                                                    </div>
                                                    <button type="button" onclick="removeExperience(this)" class="mt-4 text-red-500 text-sm font-semibold flex items-center gap-1 hover:text-red-600 transition-colors">
                                                        <span class="material-symbols-outlined text-base">delete</span>
                                                        Remove Job
                                                    </button>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <button type="button" onclick="addExperience()" class="mt-6 flex items-center gap-2 text-primary text-sm font-bold border border-primary/50 rounded-full px-4 py-2 hover:bg-primary/10 transition-colors">
                                            <span class="material-symbols-outlined text-base">add_circle</span>
                                            Add Experience
                                        </button>
                                    </details>

                                    <details
                                        class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/50 shadow-lg p-6 group"
                                    >
                                        <summary class="flex cursor-pointer items-center justify-between gap-6 pb-2 border-b border-slate-100 dark:border-slate-800/50">
                                            <p class="text-slate-900 dark:text-slate-50 text-xl font-bold leading-normal flex items-center">
                                                <span class="material-symbols-outlined mr-2 text-primary">school</span>
                                                Education
                                            </p>
                                            <span class="material-symbols-outlined text-slate-500 dark:text-slate-400 group-open:rotate-180 transition-transform">expand_more</span>
                                        </summary>
                                        <div class="mt-6 space-y-6" id="education-container">
                                            <?php if (empty($education)): ?>
                                                <p class="text-slate-500 dark:text-slate-400 text-sm font-normal leading-normal text-center empty-state-message">
                                                    No education added yet. Click **Add Education** below.
                                                </p>
                                            <?php endif; ?>
                                            <?php foreach ($education as $index => $edu): ?>
                                                <div class="education-item rounded-lg p-4 bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-inner">
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                        <label class="flex flex-col">
                                                            <p class="text-slate-700 dark:text-slate-300 text-sm font-medium leading-normal pb-2">Degree/Certification</p>
                                                            <input name="education[<?= $index ?>][degree]" value="<?= htmlspecialchars($edu['degree'] ?? '') ?>" class="form-input" placeholder="Bachelor of Science">
                                                        </label>
                                                        <label class="flex flex-col">
                                                            <p class="text-slate-700 dark:text-slate-300 text-sm font-medium leading-normal pb-2">Institution</p>
                                                            <input name="education[<?= $index ?>][institution]" value="<?= htmlspecialchars($edu['institution'] ?? '') ?>" class="form-input" placeholder="University Name">
                                                        </label>
                                                        <label class="flex flex-col">
                                                            <p class="text-slate-700 dark:text-slate-300 text-sm font-medium leading-normal pb-2">Completion Year</p>
                                                            <input name="education[<?= $index ?>][year]" value="<?= htmlspecialchars($edu['year'] ?? '') ?>" class="form-input" placeholder="2020">
                                                        </label>
                                                        <label class="flex flex-col">
                                                            <p class="text-slate-700 dark:text-slate-300 text-sm font-medium leading-normal pb-2">City/Location</p>
                                                            <input name="education[<?= $index ?>][location]" value="<?= htmlspecialchars($edu['location'] ?? '') ?>" class="form-input" placeholder="New York, NY">
                                                        </label>
                                                    </div>
                                                    <button type="button" onclick="removeEducation(this)" class="mt-4 text-red-500 text-sm font-semibold flex items-center gap-1 hover:text-red-600 transition-colors">
                                                        <span class="material-symbols-outlined text-base">delete</span>
                                                        Remove Education
                                                    </button>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <button type="button" onclick="addEducation()" class="mt-6 flex items-center gap-2 text-primary text-sm font-bold border border-primary/50 rounded-full px-4 py-2 hover:bg-primary/10 transition-colors">
                                            <span class="material-symbols-outlined text-base">add_circle</span>
                                            Add Education
                                        </button>
                                    </details>

                                    <details
                                        class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/50 shadow-lg p-6 group"
                                        open
                                    >
                                        <summary class="flex cursor-pointer items-center justify-between gap-6 pb-2 border-b border-slate-100 dark:border-slate-800/50">
                                            <p class="text-slate-900 dark:text-slate-50 text-xl font-bold leading-normal flex items-center">
                                                <span class="material-symbols-outlined mr-2 text-primary">handyman</span>
                                                Skills
                                            </p>
                                            <span class="material-symbols-outlined text-slate-500 dark:text-slate-400 group-open:rotate-180 transition-transform">expand_more</span>
                                        </summary>
                                        <div class="mt-6">
                                            <label class="flex flex-col">
                                                <p class="text-slate-700 dark:text-slate-300 text-sm font-medium leading-normal pb-2">
                                                    Enter your key skills (Press **Enter** to add a skill)
                                                </p>
                                                <div
                                                    class="flex items-center flex-wrap gap-2 p-3 rounded-lg border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 min-h-[48px]"
                                                    id="skills-container"
                                                >
                                                    <?php foreach ($skills as $index => $skill): ?>
                                                        <span class="flex items-center gap-2 bg-primary/20 text-primary-800 dark:bg-primary/30 dark:text-primary-200 text-sm font-medium px-3 py-1 rounded-full skill-tag transition-all duration-300 hover:bg-red-500/30 hover:text-red-600 dark:hover:text-red-400 cursor-default">
                                                            <?= htmlspecialchars($skill) ?>
                                                            <button type="button" onclick="removeSkill(this)" class="p-1 -mr-2 rounded-full hover:bg-white/30 dark:hover:bg-black/30 transition-colors">
                                                                <span class="material-symbols-outlined text-sm">close</span>
                                                            </button>
                                                            <input type="hidden" name="skills[]" value="<?= htmlspecialchars($skill) ?>">
                                                        </span>
                                                    <?php endforeach; ?>
                                                    <input
                                                        id="skill-input"
                                                        class="flex-1 min-w-24 bg-transparent border-none focus:ring-0 text-slate-900 dark:text-slate-50 placeholder:text-slate-400 dark:placeholder:text-slate-500 h-6 p-0 text-sm"
                                                        placeholder="Add a skill..."
                                                        onkeypress="handleSkillInput(event)"
                                                    />
                                                </div>
                                            </label>
                                        </div>
                                    </details>
                                </div>
                            </div>
                            
                            <div class="flex flex-col gap-6 lg:col-span-6 sticky top-24 h-[calc(100vh-8rem)]">
                                <div class="flex gap-4">
                                    <button type="submit" class="flex flex-1 cursor-pointer items-center justify-center overflow-hidden rounded-xl h-12 px-6 bg-gradient-to-r from-primary to-blue-500 text-white gap-2 text-base font-bold shadow-xl shadow-primary/30 transition-all hover:shadow-2xl hover:shadow-primary/40 hover:scale-[1.01] duration-300">
                                        <span class="material-symbols-outlined">save</span>
                                        <span class="truncate">Save Resume</span>
                                    </button>
                                    <?php if ($resume_id): ?>
                                        <button type="button" onclick="generatePDF(event)" class="flex flex-1 cursor-pointer items-center justify-center overflow-hidden rounded-xl h-12 px-6 bg-green-600 text-white gap-2 text-base font-bold shadow-xl shadow-green-600/30 transition-all hover:shadow-2xl hover:shadow-green-600/40 hover:scale-[1.01] duration-300 pdf-download-btn">
                                            <span class="material-symbols-outlined">download</span>
                                            <span class="truncate">Download PDF</span>
                                        </button>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="flex-1 bg-white dark:bg-background-dark/50 rounded-xl shadow-2xl overflow-y-auto p-4 md:p-8 border border-slate-200 dark:border-slate-800">
                                    <div class="w-full min-h-[800px] border border-slate-300 dark:border-slate-700 p-4 md:p-8" id="resumePreview">
                                        <div class="text-center py-10 text-slate-500 dark:text-slate-400">
                                            <span class="material-symbols-outlined text-4xl mb-2">description</span>
                                            <p>Resume Preview will appear here. Start filling out the sections to see your resume come to life!</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </main>
            
            <footer class="relative z-10 mt-auto border-t border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900/30">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                        <p class="text-sm text-slate-600 dark:text-slate-400">
                            © 2025 ResumeStudio. All rights reserved.
                        </p>
                        <div class="flex items-center gap-6">
                            <a href="#" class="text-sm text-slate-600 dark:text-slate-400 hover:text-primary dark:hover:text-primary transition-colors">Privacy</a>
                            <a href="#" class="text-sm text-slate-600 dark:text-slate-400 hover:text-primary dark:hover:text-primary transition-colors">Terms</a>
                            <a href="#" class="text-sm text-slate-600 dark:text-slate-400 hover:text-primary dark:hover:text-primary transition-colors">Support</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        
        <script>
            let experienceCount = <?= count($experience) ?>;
            let educationCount = <?= count($education) ?>;
            let currentResumeId = <?= $resume_id ?? 'null' ?>;

            document.addEventListener('DOMContentLoaded', function() {
                // Initial Preview Load
                if (currentResumeId) {
                    updatePreview();
                } else {
                    // Manually inject a blank template preview if no ID exists (new resume)
                    // This assumes a default content/structure is loaded in update_preview.php
                    // For now, the PHP fallback div is used, but we'll run updatePreview once to render a base template.
                    updatePreview(); 
                }
                
                // Initialize form input listeners
                const form = document.getElementById('resumeForm');
                const debouncedUpdate = debounce(updatePreview, 500);
                form.addEventListener('input', debouncedUpdate);
                form.addEventListener('change', debouncedUpdate);
                
                // Initialize template selection visual
                const selectedTemplate = document.querySelector('.template-radio:checked');
                if (selectedTemplate) {
                    updateTemplateSelection(selectedTemplate.value);
                }
            });
            
            // --- Template Selection Functions ---
            
            const templateRadios = document.querySelectorAll('.template-radio');
            templateRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    updateTemplateSelection(this.value);
                    updatePreview();
                    setTimeout(() => { autoSaveTemplate(); }, 500);
                });
            });

            function updateTemplateSelection(selectedValue) {
                const allLabels = document.querySelectorAll('label.relative');
                allLabels.forEach(label => {
                    const div = label.querySelector('div');
                    div.classList.remove('border-primary', 'shadow-xl', 'shadow-primary/20', 'bg-primary/10');
                    div.classList.add('border-slate-300', 'dark:border-slate-700', 'hover:border-primary', 'dark:hover:border-primary');
                });
                
                const selectedLabel = document.querySelector(`input[value="${selectedValue}"]`).closest('label');
                const selectedDiv = selectedLabel.querySelector('div');
                selectedDiv.classList.add('border-primary', 'shadow-xl', 'shadow-primary/20', 'bg-primary/10');
                selectedDiv.classList.remove('border-slate-300', 'dark:border-slate-700', 'hover:border-primary', 'dark:hover:border-primary');
            }

            function autoSaveTemplate() {
                const form = document.getElementById('resumeForm');
                const formData = new FormData(form);
                
                fetch('process/save_resume.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (response.ok) {
                        showNotification('Template updated successfully!', 'success');
                    } else {
                        throw new Error('Failed to save template');
                    }
                })
                .catch(error => {
                    console.error('Error saving template:', error);
                    showNotification('Error saving template. Please save manually.', 'error');
                });
            }

            // --- Dynamic Section Functions (Experience/Education) ---

            function updateEmptyState(containerId, itemClass) {
                const container = document.getElementById(containerId);
                const items = container.querySelectorAll(`.${itemClass}`);
                const emptyMessage = container.querySelector('.empty-state-message');

                if (items.length === 0) {
                    if (!emptyMessage) {
                        const message = document.createElement('p');
                        message.className = 'text-slate-500 dark:text-slate-400 text-sm font-normal leading-normal text-center empty-state-message';
                        message.innerHTML = 'No items added yet. Click the button below to add your first entry.';
                        container.prepend(message);
                    }
                } else if (emptyMessage) {
                    emptyMessage.remove();
                }
            }

            function addExperience() {
                const container = document.getElementById('experience-container');
                const item = document.createElement('div');
                item.className = 'experience-item rounded-lg p-4 bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-inner';
                item.innerHTML = `
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="flex flex-col">
                            <p class="text-slate-700 dark:text-slate-300 text-sm font-medium leading-normal pb-2">Job Title</p>
                            <input name="experience[${experienceCount}][job_title]" class="form-input" placeholder="Software Engineer">
                        </label>
                        <label class="flex flex-col">
                            <p class="text-slate-700 dark:text-slate-300 text-sm font-medium leading-normal pb-2">Company</p>
                            <input name="experience[${experienceCount}][company]" class="form-input" placeholder="Tech Company Inc.">
                        </label>
                        <label class="flex flex-col">
                            <p class="text-slate-700 dark:text-slate-300 text-sm font-medium leading-normal pb-2">Duration</p>
                            <input name="experience[${experienceCount}][duration]" class="form-input" placeholder="Jan 2020 - Present">
                        </label>
                        <div class="col-span-2 flex items-center gap-4">
                            <label class="flex items-center text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer">
                                <input type="checkbox" name="experience[${experienceCount}][is_current]" value="1" class="rounded border-gray-300 text-primary shadow-sm focus:border-primary focus:ring focus:ring-primary/50 dark:bg-slate-700 dark:border-slate-600">
                                <span class="ml-2">Currently Work Here</span>
                            </label>
                        </div>
                        <label class="flex flex-col col-span-2">
                            <p class="text-slate-700 dark:text-slate-300 text-sm font-medium leading-normal pb-2">Description (Bullet points recommended)</p>
                            <textarea name="experience[${experienceCount}][description]" class="form-textarea h-24" placeholder="- Developed feature X with Y technology&#10;- Achieved Z result..."></textarea>
                        </label>
                    </div>
                    <button type="button" onclick="removeExperience(this)" class="mt-4 text-red-500 text-sm font-semibold flex items-center gap-1 hover:text-red-600 transition-colors">
                        <span class="material-symbols-outlined text-base">delete</span>
                        Remove Job
                    </button>
                `;
                container.appendChild(item);
                experienceCount++;
                updateEmptyState('experience-container', 'experience-item');
                updatePreview();
            }

            function removeExperience(button) {
                button.closest('.experience-item').remove();
                updateEmptyState('experience-container', 'experience-item');
                updatePreview();
            }

            function addEducation() {
                const container = document.getElementById('education-container');
                const item = document.createElement('div');
                item.className = 'education-item rounded-lg p-4 bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-inner';
                item.innerHTML = `
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="flex flex-col">
                            <p class="text-slate-700 dark:text-slate-300 text-sm font-medium leading-normal pb-2">Degree/Certification</p>
                            <input name="education[${educationCount}][degree]" class="form-input" placeholder="Bachelor of Science">
                        </label>
                        <label class="flex flex-col">
                            <p class="text-slate-700 dark:text-slate-300 text-sm font-medium leading-normal pb-2">Institution</p>
                            <input name="education[${educationCount}][institution]" class="form-input" placeholder="University Name">
                        </label>
                        <label class="flex flex-col">
                            <p class="text-slate-700 dark:text-slate-300 text-sm font-medium leading-normal pb-2">Completion Year</p>
                            <input name="education[${educationCount}][year]" class="form-input" placeholder="2020">
                        </label>
                        <label class="flex flex-col">
                            <p class="text-slate-700 dark:text-slate-300 text-sm font-medium leading-normal pb-2">City/Location</p>
                            <input name="education[${educationCount}][location]" class="form-input" placeholder="New York, NY">
                        </label>
                    </div>
                    <button type="button" onclick="removeEducation(this)" class="mt-4 text-red-500 text-sm font-semibold flex items-center gap-1 hover:text-red-600 transition-colors">
                        <span class="material-symbols-outlined text-base">delete</span>
                        Remove Education
                    </button>
                `;
                container.appendChild(item);
                educationCount++;
                updateEmptyState('education-container', 'education-item');
                updatePreview();
            }

            function removeEducation(button) {
                button.closest('.education-item').remove();
                updateEmptyState('education-container', 'education-item');
                updatePreview();
            }
            
            // --- Skills Tag Functions ---

            function handleSkillInput(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    const input = document.getElementById('skill-input');
                    const skill = input.value.trim();
                    
                    if (skill) {
                        addSkill(skill);
                        input.value = '';
                    }
                }
            }

            function addSkill(skill) {
                const container = document.getElementById('skills-container');
                const skillElement = document.createElement('span');
                skillElement.className = 'flex items-center gap-2 bg-primary/20 text-primary-800 dark:bg-primary/30 dark:text-primary-200 text-sm font-medium px-3 py-1 rounded-full skill-tag transition-all duration-300 hover:bg-red-500/30 hover:text-red-600 dark:hover:text-red-400 cursor-default';
                skillElement.innerHTML = `
                    ${skill}
                    <button type="button" onclick="removeSkill(this)" class="p-1 -mr-2 rounded-full hover:bg-white/30 dark:hover:bg-black/30 transition-colors">
                        <span class="material-symbols-outlined text-sm">close</span>
                    </button>
                    <input type="hidden" name="skills[]" value="${skill}">
                `;
                container.insertBefore(skillElement, document.getElementById('skill-input'));
                updatePreview();
            }

            function removeSkill(button) {
                // To support both clicking the button and clicking the parent span
                const skillTag = button.closest('.skill-tag');
                if (skillTag) {
                    skillTag.remove();
                }
                updatePreview();
            }

            // --- PDF Generation and Preview Update ---

            function generatePDF(event) {
                event.preventDefault();
                
                if (!currentResumeId) {
                    showNotification('Please **Save** your resume first before generating PDF.', 'error');
                    return;
                }
                
                const downloadBtn = event.target.closest('button');
                const originalHTML = downloadBtn.innerHTML;
                
                downloadBtn.innerHTML = `
                    <span class="material-symbols-outlined animate-spin">refresh</span>
                    <span>Generating...</span>
                `;
                downloadBtn.disabled = true;
                
                const iframe = document.createElement('iframe');
                iframe.style.display = 'none';
                iframe.src = `process/generate_pdf.php?id=${currentResumeId}`;
                document.body.appendChild(iframe);
                
                iframe.onload = function() {
                    // Slight delay to ensure the download initiates
                    setTimeout(() => {
                        downloadBtn.innerHTML = originalHTML;
                        downloadBtn.disabled = false;
                        document.body.removeChild(iframe);
                        showNotification('PDF generation requested. Check your downloads!', 'success');
                    }, 1000);
                };
            }

            function updatePreview() {
                const form = document.getElementById('resumeForm');
                const preview = document.getElementById('resumePreview');
                const formData = new FormData(form);
                
                // Add a hidden field to indicate this is only for preview
                formData.append('is_preview', '1'); 
                
                fetch('process/update_preview.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(html => {
                    preview.innerHTML = html;
                })
                .catch(error => {
                    console.error('Error updating preview:', error);
                    preview.innerHTML = `<div class="text-center py-10 text-red-500 dark:text-red-400">
                        <span class="material-symbols-outlined text-4xl mb-2">error</span>
                        <p>Could not load preview: ${error.message}</p>
                    </div>`;
                });
            }

            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }

            function showNotification(message, type = 'info') {
                const existingNotification = document.querySelector('.pdf-notification');
                if (existingNotification) {
                    existingNotification.remove();
                }
                
                const bgColor = type === 'error' ? 'bg-red-600' : 
                                type === 'success' ? 'bg-green-600' : 'bg-blue-600';
                
                const notification = document.createElement('div');
                notification.className = `pdf-notification fixed top-4 right-4 p-4 rounded-xl shadow-2xl z-50 ${bgColor} text-white transition-opacity duration-300 opacity-0`;
                notification.innerHTML = `
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-xl">
                            ${type === 'error' ? 'error' : type === 'success' ? 'check_circle' : 'info'}
                        </span>
                        <span class="text-sm font-medium">${message}</span>
                        <button onclick="this.closest('.pdf-notification').remove()" class="ml-2 p-1 rounded-full hover:bg-white/30 transition-colors">
                            <span class="material-symbols-outlined text-base">close</span>
                        </button>
                    </div>
                `;
                
                document.body.appendChild(notification);
                
                // Trigger fade-in
                setTimeout(() => {
                    notification.classList.remove('opacity-0');
                }, 10);
                
                // Auto-remove
                setTimeout(() => {
                    if (notification.parentElement) {
                        notification.classList.add('opacity-0');
                        setTimeout(() => notification.remove(), 300);
                    }
                }, 5000);
            }
        </script>
    </body>
</html>
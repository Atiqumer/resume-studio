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
?>
<!DOCTYPE html>
<html class="light" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title><?= $resume ? 'Edit Resume' : 'Create New Resume' ?> - ResumeBuilder</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&amp;display=swap"
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
              "background-light": "#f6f7f8",
              "background-dark": "#111921",
            },
            fontFamily: {
              display: ["Inter", "sans-serif"],
            },
            borderRadius: {
              DEFAULT: "0.25rem",
              lg: "0.5rem",
              xl: "0.75rem",
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
    </style>
  </head>
  <body class="font-display">
    <div
      class="relative flex h-auto min-h-screen w-full flex-col bg-background-light dark:bg-background-dark group/design-root overflow-x-hidden"
    >
      <div class="layout-container flex h-full grow flex-col">
        <header
          class="sticky top-0 z-50 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-sm border-b border-slate-200 dark:border-slate-800"
        >
          <div
            class="mx-auto flex max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8 py-3"
          >
            <div class="flex items-center gap-4 text-primary">
              <span class="material-symbols-outlined text-3xl"
                >description</span
              >
              <h2 class="text-[#0e141b] dark:text-slate-50 text-xl font-bold">
                ResumeStudio
              </h2>
            </div>
            <div class="flex items-center gap-4">
              <div class="flex items-center gap-2">
                <span
                  class="material-symbols-outlined text-xl text-slate-500 dark:text-slate-400"
                  >account_circle</span
                >
                <span
                  class="text-sm font-medium text-slate-700 dark:text-slate-300"
                  ><?= htmlspecialchars($user['name']) ?></span
                >
              </div>
              <a
                href="process/logout.php"
                class="flex h-9 cursor-pointer items-center justify-center overflow-hidden rounded-md px-4 text-sm font-medium bg-slate-200/80 hover:bg-slate-200 dark:bg-slate-800/80 dark:hover:bg-slate-800 text-slate-800 dark:text-slate-200 transition-colors"
              >
                <span class="truncate">Logout</span>
              </a>
            </div>
          </div>
        </header>
        <main class="flex-1 pt-24 px-10">
          <form id="resumeForm" method="POST" action="process/save_resume.php">
            <input type="hidden" name="resume_id" value="<?= $resume_id ?>">
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 h-full">
              <!-- Left Column: Form -->
              <div class="flex flex-col gap-6">
                <a
                  href="dashboard.php"
                  class="flex w-fit max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-transparent text-slate-700 dark:text-slate-300 gap-2 text-sm font-bold leading-normal tracking-[0.015em] hover:bg-slate-100 dark:hover:bg-slate-800"
                >
                  <span class="material-symbols-outlined text-base"
                    >arrow_back</span
                  >
                  <span class="truncate">Back to Dashboard</span>
                </a>

                <!-- Resume Title -->
                <div class="flex flex-col gap-2">
                  <label class="flex flex-col">
                    <p class="text-slate-800 dark:text-slate-200 text-sm font-medium leading-normal pb-2">Resume Title</p>
                    <input
                      name="title"
                      class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-slate-900 dark:text-slate-50 focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-background-dark focus:border-primary h-12 placeholder:text-slate-400 dark:placeholder:text-slate-500 px-4 text-sm font-normal"
                      placeholder="e.g., Software Engineer Resume"
                      value="<?= htmlspecialchars($resume['title'] ?? 'My Resume') ?>"
                    />
                  </label>
                </div>
                <!-- Template Selection -->
<div class="flex flex-col gap-4 mb-6">
    <h3 class="text-lg font-bold text-slate-900 dark:text-slate-50">Choose Template</h3>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        <?php
        $current_template = $resume['template'] ?? 'template1';
        $templates = [
            'template1' => ['name' => 'Professional', 'color' => 'blue'],
            'template2' => ['name' => 'Modern', 'color' => 'blue'],
            'template3' => ['name' => 'Creative', 'color' => 'green']
        ];
        
        foreach ($templates as $template_key => $template_info):
            $is_selected = $current_template === $template_key;
        ?>
        <label class="relative cursor-pointer">
            <input type="radio" name="template" value="<?= $template_key ?>" 
                   <?= $is_selected ? 'checked' : '' ?> 
                   class="hidden template-radio">
            <div class="border-2 rounded-lg p-4 transition-all <?= $is_selected ? 'border-primary bg-primary/10' : 'border-slate-300 hover:border-primary' ?>">
                <div class="bg-white p-3 rounded shadow-sm">
                    <?php if ($template_key === 'template1'): ?>
                        <div class="h-4 bg-blue-600 rounded mb-2"></div>
                        <div class="h-2 bg-gray-300 rounded mb-1"></div>
                        <div class="h-2 bg-gray-300 rounded w-3/4"></div>
                    <?php elseif ($template_key === 'template2'): ?>
                        <div class="h-6 bg-blue-800 rounded mb-2"></div>
                        <div class="grid grid-cols-3 gap-2">
                            <div class="h-2 bg-gray-300 rounded"></div>
                            <div class="h-2 bg-gray-300 rounded"></div>
                            <div class="h-2 bg-gray-300 rounded"></div>
                        </div>
                    <?php else: ?>
                        <div class="h-4 bg-green-600 rounded mb-2"></div>
                        <div class="h-2 bg-gray-300 rounded mb-1"></div>
                        <div class="h-2 bg-gray-300 rounded"></div>
                    <?php endif; ?>
                </div>
                <p class="text-sm font-medium mt-2 text-center"><?= $template_info['name'] ?></p>
            </div>
        </label>
        <?php endforeach; ?>
    </div>
</div>
                <!-- Form Sections -->
                <div class="flex flex-col gap-4">
                  <!-- Personal Info -->
                  <details
                    class="flex flex-col rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-background-dark/50 p-4 group"
                    open
                  >
                    <summary
                      class="flex cursor-pointer items-center justify-between gap-6"
                    >
                      <p
                        class="text-slate-900 dark:text-slate-50 text-base font-medium leading-normal"
                      >
                        Personal Info
                      </p>
                      <span
                        class="material-symbols-outlined text-slate-500 dark:text-slate-400 group-open:rotate-180 transition-transform"
                        >expand_more</span
                      >
                    </summary>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                      <label class="flex flex-col col-span-2">
                        <p
                          class="text-slate-800 dark:text-slate-200 text-sm font-medium leading-normal pb-2"
                        >
                          Full Name
                        </p>
                        <input
                          name="personal_info[full_name]"
                          class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-slate-900 dark:text-slate-50 focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-background-dark focus:border-primary h-12 placeholder:text-slate-400 dark:placeholder:text-slate-500 px-4 text-sm font-normal"
                          placeholder="Jane Doe"
                          value="<?= htmlspecialchars($personal_info['full_name'] ?? '') ?>"
                        />
                      </label>
                      <label class="flex flex-col">
                        <p
                          class="text-slate-800 dark:text-slate-200 text-sm font-medium leading-normal pb-2"
                        >
                          Email
                        </p>
                        <input
                          name="personal_info[email]"
                          class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-slate-900 dark:text-slate-50 focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-background-dark focus:border-primary h-12 placeholder:text-slate-400 dark:placeholder:text-slate-500 px-4 text-sm font-normal"
                          placeholder="jane.doe@example.com"
                          type="email"
                          value="<?= htmlspecialchars($personal_info['email'] ?? '') ?>"
                        />
                      </label>
                      <label class="flex flex-col">
                        <p
                          class="text-slate-800 dark:text-slate-200 text-sm font-medium leading-normal pb-2"
                        >
                          Phone
                        </p>
                        <input
                          name="personal_info[phone]"
                          class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-slate-900 dark:text-slate-50 focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-background-dark focus:border-primary h-12 placeholder:text-slate-400 dark:placeholder:text-slate-500 px-4 text-sm font-normal"
                          placeholder="(123) 456-7890"
                          type="tel"
                          value="<?= htmlspecialchars($personal_info['phone'] ?? '') ?>"
                        />
                      </label>
                      <label class="flex flex-col col-span-2">
                        <p
                          class="text-slate-800 dark:text-slate-200 text-sm font-medium leading-normal pb-2"
                        >
                          LinkedIn Profile
                        </p>
                        <input
                          name="personal_info[linkedin]"
                          class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-slate-900 dark:text-slate-50 focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-background-dark focus:border-primary h-12 placeholder:text-slate-400 dark:placeholder:text-slate-500 px-4 text-sm font-normal"
                          placeholder="linkedin.com/in/janedoe"
                          value="<?= htmlspecialchars($personal_info['linkedin'] ?? '') ?>"
                        />
                      </label>
                      <label class="flex flex-col col-span-2">
                        <p
                          class="text-slate-800 dark:text-slate-200 text-sm font-medium leading-normal pb-2"
                        >
                          Professional Summary
                        </p>
                        <textarea
                          name="personal_info[summary]"
                          class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-slate-900 dark:text-slate-50 focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-background-dark focus:border-primary h-24 placeholder:text-slate-400 dark:placeholder:text-slate-500 px-4 py-3 text-sm font-normal"
                          placeholder="Brief overview of your professional background and career goals..."
                        ><?= htmlspecialchars($personal_info['summary'] ?? '') ?></textarea>
                      </label>
                    </div>
                  </details>

                  <!-- Experience -->
                  <details
                    class="flex flex-col rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-background-dark/50 p-4 group"
                  >
                    <summary
                      class="flex cursor-pointer items-center justify-between gap-6"
                    >
                      <p
                        class="text-slate-900 dark:text-slate-50 text-base font-medium leading-normal"
                      >
                        Experience
                      </p>
                      <span
                        class="material-symbols-outlined text-slate-500 dark:text-slate-400 group-open:rotate-180 transition-transform"
                        >expand_more</span
                      >
                    </summary>
                    <div class="mt-4 space-y-4" id="experience-container">
                      <?php if (!empty($experience)): ?>
                        <?php foreach ($experience as $index => $exp): ?>
                          <div class="experience-item border rounded-lg p-4 bg-slate-50 dark:bg-slate-800/50">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                              <label class="flex flex-col">
                                <p class="text-slate-800 dark:text-slate-200 text-sm font-medium leading-normal pb-2">Job Title</p>
                                <input name="experience[<?= $index ?>][job_title]" value="<?= htmlspecialchars($exp['job_title'] ?? '') ?>" class="form-input" placeholder="Software Engineer">
                              </label>
                              <label class="flex flex-col">
                                <p class="text-slate-800 dark:text-slate-200 text-sm font-medium leading-normal pb-2">Company</p>
                                <input name="experience[<?= $index ?>][company]" value="<?= htmlspecialchars($exp['company'] ?? '') ?>" class="form-input" placeholder="Tech Company Inc.">
                              </label>
                              <label class="flex flex-col">
                                <p class="text-slate-800 dark:text-slate-200 text-sm font-medium leading-normal pb-2">Duration</p>
                                <input name="experience[<?= $index ?>][duration]" value="<?= htmlspecialchars($exp['duration'] ?? '') ?>" class="form-input" placeholder="Jan 2020 - Present">
                              </label>
                              <label class="flex flex-col md:col-span-2">
                                <p class="text-slate-800 dark:text-slate-200 text-sm font-medium leading-normal pb-2">Description</p>
                                <textarea name="experience[<?= $index ?>][description]" class="form-input h-20" placeholder="Describe your responsibilities and achievements..."><?= htmlspecialchars($exp['description'] ?? '') ?></textarea>
                              </label>
                            </div>
                            <button type="button" onclick="removeExperience(this)" class="mt-2 text-red-500 text-sm flex items-center gap-1">
                              <span class="material-symbols-outlined text-sm">delete</span>
                              Remove
                            </button>
                          </div>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <p class="text-slate-500 dark:text-slate-400 text-sm font-normal leading-normal pt-4">
                          No experience added yet. Click the button below to add your first work experience.
                        </p>
                      <?php endif; ?>
                    </div>
                    <button type="button" onclick="addExperience()" class="mt-4 flex items-center gap-2 text-primary text-sm font-medium">
                      <span class="material-symbols-outlined text-base">add</span>
                      Add Experience
                    </button>
                  </details>

                  <!-- Education -->
                  <details
                    class="flex flex-col rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-background-dark/50 p-4 group"
                  >
                    <summary
                      class="flex cursor-pointer items-center justify-between gap-6"
                    >
                      <p
                        class="text-slate-900 dark:text-slate-50 text-base font-medium leading-normal"
                      >
                        Education
                      </p>
                      <span
                        class="material-symbols-outlined text-slate-500 dark:text-slate-400 group-open:rotate-180 transition-transform"
                        >expand_more</span
                      >
                    </summary>
                    <div class="mt-4 space-y-4" id="education-container">
                      <?php if (!empty($education)): ?>
                        <?php foreach ($education as $index => $edu): ?>
                          <div class="education-item border rounded-lg p-4 bg-slate-50 dark:bg-slate-800/50">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                              <label class="flex flex-col">
                                <p class="text-slate-800 dark:text-slate-200 text-sm font-medium leading-normal pb-2">Degree</p>
                                <input name="education[<?= $index ?>][degree]" value="<?= htmlspecialchars($edu['degree'] ?? '') ?>" class="form-input" placeholder="Bachelor of Science">
                              </label>
                              <label class="flex flex-col">
                                <p class="text-slate-800 dark:text-slate-200 text-sm font-medium leading-normal pb-2">Institution</p>
                                <input name="education[<?= $index ?>][institution]" value="<?= htmlspecialchars($edu['institution'] ?? '') ?>" class="form-input" placeholder="University Name">
                              </label>
                              <label class="flex flex-col">
                                <p class="text-slate-800 dark:text-slate-200 text-sm font-medium leading-normal pb-2">Year</p>
                                <input name="education[<?= $index ?>][year]" value="<?= htmlspecialchars($edu['year'] ?? '') ?>" class="form-input" placeholder="2020">
                              </label>
                            </div>
                            <button type="button" onclick="removeEducation(this)" class="mt-2 text-red-500 text-sm flex items-center gap-1">
                              <span class="material-symbols-outlined text-sm">delete</span>
                              Remove
                            </button>
                          </div>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <p class="text-slate-500 dark:text-slate-400 text-sm font-normal leading-normal pt-4">
                          No education added yet. Click the button below to add your educational background.
                        </p>
                      <?php endif; ?>
                    </div>
                    <button type="button" onclick="addEducation()" class="mt-4 flex items-center gap-2 text-primary text-sm font-medium">
                      <span class="material-symbols-outlined text-base">add</span>
                      Add Education
                    </button>
                  </details>

                  <!-- Skills -->
                  <details
                    class="flex flex-col rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-background-dark/50 p-4 group"
                    open
                  >
                    <summary
                      class="flex cursor-pointer items-center justify-between gap-6"
                    >
                      <p
                        class="text-slate-900 dark:text-slate-50 text-base font-medium leading-normal"
                      >
                        Skills
                      </p>
                      <span
                        class="material-symbols-outlined text-slate-500 dark:text-slate-400 group-open:rotate-180 transition-transform"
                        >expand_more</span
                      >
                    </summary>
                    <div class="mt-4">
                      <label class="flex flex-col">
                        <p
                          class="text-slate-800 dark:text-slate-200 text-sm font-medium leading-normal pb-2"
                        >
                          Enter your skills
                        </p>
                        <div
                          class="flex items-center flex-wrap gap-2 p-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-background-light dark:bg-background-dark"
                          id="skills-container"
                        >
                          <?php if (!empty($skills)): ?>
                            <?php foreach ($skills as $index => $skill): ?>
                              <span class="flex items-center gap-2 bg-primary/20 text-primary-800 dark:bg-primary/30 dark:text-primary-200 text-sm font-medium px-3 py-1 rounded-full skill-tag">
                                <?= htmlspecialchars($skill) ?>
                                <button type="button" onclick="removeSkill(this)">
                                  <span class="material-symbols-outlined text-sm">close</span>
                                </button>
                                <input type="hidden" name="skills[]" value="<?= htmlspecialchars($skill) ?>">
                              </span>
                            <?php endforeach; ?>
                          <?php endif; ?>
                          <input
                            id="skill-input"
                            class="form-input flex-1 min-w-24 bg-transparent border-none focus:ring-0 text-slate-900 dark:text-slate-50 placeholder:text-slate-400 dark:placeholder:text-slate-500"
                            placeholder="Add a skill..."
                            onkeypress="handleSkillInput(event)"
                          />
                        </div>
                      </label>
                    </div>
                  </details>
                </div>
              </div>
<!-- Right Column: Resume Preview -->
<div class="flex flex-col gap-6 sticky top-24 h-[calc(100vh-8rem)]">
    <div class="flex gap-2">
        <button type="submit" class="flex flex-1 cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 px-6 bg-primary text-white gap-2 text-base font-bold leading-normal tracking-[0.015em] hover:bg-primary/90 transition-colors">
            <span class="material-symbols-outlined">save</span>
            <span class="truncate">Save Resume</span>
        </button>
        <?php if ($resume_id): ?>
            <button type="button" onclick="generatePDF()" class="flex flex-1 cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 px-6 bg-green-600 text-white gap-2 text-base font-bold leading-normal tracking-[0.015em] hover:bg-green-700 transition-colors pdf-download-btn">
                <span class="material-symbols-outlined">download</span>
                <span class="truncate">Download PDF</span>
            </button>
        <?php endif; ?>
    </div>
    
    <div class="flex-1 bg-white dark:bg-background-dark/50 rounded-lg shadow-lg overflow-y-auto p-8 border border-slate-200 dark:border-slate-800">
        <div class="w-full h-full min-h-[800px]" id="resumePreview">
            <?php
            // Render selected template
            if (file_exists("templates/$template.php")) {
                require_once "templates/$template.php";
                $function = "render$template";
                if (function_exists($function)) {
                    $function([
                        'personal_info' => $personal_info,
                        'experience' => $experience,
                        'education' => $education,
                        'skills' => $skills
                    ]);
                }
            }
            ?>
        </div>
    </div>
</div>
            </div>
          </form>
        </main>
      </div>
    </div>
    <script>
let experienceCount = <?= count($experience) ?>;
let educationCount = <?= count($education) ?>;

// Template selection handling
document.addEventListener('DOMContentLoaded', function() {
    const templateRadios = document.querySelectorAll('.template-radio');
    
    templateRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            // Update visual selection
            updateTemplateSelection(this.value);
            
            // Update preview immediately
            updatePreview();
            
            // Auto-save the form to ensure template is saved
            setTimeout(() => {
                autoSaveTemplate();
            }, 500);
        });
    });
    
    // Initialize template selection visual
    const selectedTemplate = document.querySelector('.template-radio:checked');
    if (selectedTemplate) {
        updateTemplateSelection(selectedTemplate.value);
    }
});

function updateTemplateSelection(selectedValue) {
    // Remove all selected styles
    const allLabels = document.querySelectorAll('label.relative');
    allLabels.forEach(label => {
        const div = label.querySelector('div');
        div.classList.remove('border-primary', 'bg-primary/10');
        div.classList.add('border-slate-300');
    });
    
    // Add selected style to current template
    const selectedLabel = document.querySelector(`input[value="${selectedValue}"]`).closest('label');
    const selectedDiv = selectedLabel.querySelector('div');
    selectedDiv.classList.add('border-primary', 'bg-primary/10');
    selectedDiv.classList.remove('border-slate-300');
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
            console.log('Template saved successfully');
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

// Rest of your existing functions (addExperience, removeExperience, etc.)
function addExperience() {
    const container = document.getElementById('experience-container');
    const item = document.createElement('div');
    item.className = 'experience-item border rounded-lg p-4 bg-slate-50 dark:bg-slate-800/50';
    item.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <label class="flex flex-col">
                <p class="text-slate-800 dark:text-slate-200 text-sm font-medium leading-normal pb-2">Job Title</p>
                <input name="experience[${experienceCount}][job_title]" class="form-input" placeholder="Software Engineer">
            </label>
            <label class="flex flex-col">
                <p class="text-slate-800 dark:text-slate-200 text-sm font-medium leading-normal pb-2">Company</p>
                <input name="experience[${experienceCount}][company]" class="form-input" placeholder="Tech Company Inc.">
            </label>
            <label class="flex flex-col">
                <p class="text-slate-800 dark:text-slate-200 text-sm font-medium leading-normal pb-2">Duration</p>
                <input name="experience[${experienceCount}][duration]" class="form-input" placeholder="Jan 2020 - Present">
            </label>
            <label class="flex flex-col md:col-span-2">
                <p class="text-slate-800 dark:text-slate-200 text-sm font-medium leading-normal pb-2">Description</p>
                <textarea name="experience[${experienceCount}][description]" class="form-input h-20" placeholder="Describe your responsibilities and achievements..."></textarea>
            </label>
        </div>
        <button type="button" onclick="removeExperience(this)" class="mt-2 text-red-500 text-sm flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">delete</span>
            Remove
        </button>
    `;
    container.appendChild(item);
    experienceCount++;
}

function removeExperience(button) {
    button.closest('.experience-item').remove();
    updatePreview();
}

function addEducation() {
    const container = document.getElementById('education-container');
    const item = document.createElement('div');
    item.className = 'education-item border rounded-lg p-4 bg-slate-50 dark:bg-slate-800/50';
    item.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <label class="flex flex-col">
                <p class="text-slate-800 dark:text-slate-200 text-sm font-medium leading-normal pb-2">Degree</p>
                <input name="education[${educationCount}][degree]" class="form-input" placeholder="Bachelor of Science">
            </label>
            <label class="flex flex-col">
                <p class="text-slate-800 dark:text-slate-200 text-sm font-medium leading-normal pb-2">Institution</p>
                <input name="education[${educationCount}][institution]" class="form-input" placeholder="University Name">
            </label>
            <label class="flex flex-col">
                <p class="text-slate-800 dark:text-slate-200 text-sm font-medium leading-normal pb-2">Year</p>
                <input name="education[${educationCount}][year]" class="form-input" placeholder="2020">
            </label>
        </div>
        <button type="button" onclick="removeEducation(this)" class="mt-2 text-red-500 text-sm flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">delete</span>
            Remove
        </button>
    `;
    container.appendChild(item);
    educationCount++;
}

function removeEducation(button) {
    button.closest('.education-item').remove();
    updatePreview();
}

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
    skillElement.className = 'flex items-center gap-2 bg-primary/20 text-primary-800 dark:bg-primary/30 dark:text-primary-200 text-sm font-medium px-3 py-1 rounded-full skill-tag';
    skillElement.innerHTML = `
        ${skill}
        <button type="button" onclick="removeSkill(this)">
            <span class="material-symbols-outlined text-sm">close</span>
        </button>
        <input type="hidden" name="skills[]" value="${skill}">
    `;
    container.insertBefore(skillElement, document.getElementById('skill-input'));
    updatePreview();
}

function removeSkill(button) {
    button.closest('.skill-tag').remove();
    updatePreview();
}

function generatePDF() {
    const resumeId = <?= $resume_id ?? 'null' ?>;
    if (!resumeId) {
        alert('Please save your resume first before generating PDF');
        return;
    }
    
    const downloadBtn = event.target.closest('button');
    const originalHTML = downloadBtn.innerHTML;
    
    downloadBtn.innerHTML = `
        <span class="material-symbols-outlined animate-spin">refresh</span>
        <span>Generating PDF...</span>
    `;
    downloadBtn.disabled = true;
    
    const iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    iframe.src = `process/generate_pdf.php?id=${resumeId}`;
    document.body.appendChild(iframe);
    
    iframe.onload = function() {
        setTimeout(() => {
            downloadBtn.innerHTML = originalHTML;
            downloadBtn.disabled = false;
            document.body.removeChild(iframe);
        }, 2000);
    };
    
    setTimeout(() => {
        if (downloadBtn.disabled) {
            downloadBtn.innerHTML = originalHTML;
            downloadBtn.disabled = false;
            document.body.removeChild(iframe);
        }
    }, 5000);
}

// Real-time preview update
function updatePreview() {
    const form = document.getElementById('resumeForm');
    const preview = document.getElementById('resumePreview');
    const formData = new FormData(form);
    
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
    
    const bgColor = type === 'error' ? 'bg-red-500' : 
                   type === 'success' ? 'bg-green-500' : 'bg-blue-500';
    
    const notification = document.createElement('div');
    notification.className = `pdf-notification fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${bgColor} text-white`;
    notification.innerHTML = `
        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-sm">
                ${type === 'error' ? 'error' : type === 'success' ? 'check_circle' : 'info'}
            </span>
            <span class="text-sm">${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-2">
                <span class="material-symbols-outlined text-sm">close</span>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 5000);
}

// Initialize event listeners for form inputs
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('resumeForm');
    
    // Debounced preview update for form inputs
    const debouncedUpdate = debounce(updatePreview, 500);
    form.addEventListener('input', debouncedUpdate);
    form.addEventListener('change', debouncedUpdate);
});
</script>
  </body>
</html>
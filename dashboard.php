<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

if (!isLoggedIn()) {
    header('Location: index.php');
    exit();
}

$user = getUser($pdo);

// Get user's resumes
$stmt = $pdo->prepare("SELECT * FROM resumes WHERE user_id = ? ORDER BY updated_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$resumes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html class="light" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>ResumeBuilder Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
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
  <body
    class="font-display bg-background-light dark:bg-background-dark text-slate-800 dark:text-slate-200"
  >
    <div class="relative flex min-h-screen w-full flex-col">
      <!-- TopNavBar -->
      <header
        class="sticky top-0 z-50 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-sm border-b border-slate-200 dark:border-slate-800"
      >
        <div
          class="mx-auto flex max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8 py-3"
        >
          <div class="flex items-center gap-4 text-primary">
            <span class="material-symbols-outlined text-3xl">description</span>
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
      <main class="flex-1">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8 md:py-12">
          <!-- PageHeading -->
          <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
            <h1
              class="text-3xl md:text-4xl font-black tracking-tighter text-slate-900 dark:text-slate-50"
            >
              Welcome Back, <?= htmlspecialchars(explode(' ', $user['name'])[0]) ?>!
            </h1>
            <a
              href="create_resume.php"
              class="flex h-10 min-w-[84px] cursor-pointer items-center justify-center gap-2 overflow-hidden rounded-lg bg-primary px-5 text-sm font-bold text-white shadow-lg shadow-primary/30 transition-all hover:bg-primary/90 hover:shadow-primary/40 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:ring-offset-2 dark:focus:ring-offset-background-dark"
            >
              <span class="material-symbols-outlined">add_circle</span>
              <span class="truncate">Create New Resume</span>
            </a>
          </div>
          <!-- SectionHeader -->
          <h2
            class="text-2xl font-bold tracking-tight text-slate-900 dark:text-slate-50 mb-6"
          >
            Your Resumes
          </h2>
          
          <!-- Resume Grid -->
          <div
            class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
          >
            <?php if (empty($resumes)): ?>
              <!-- Empty State -->
              <div class="col-span-full mt-12 flex flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-300 dark:border-slate-700 p-12 text-center">
                  <div class="mb-4 text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                  </div>
                  <p class="text-xl font-bold leading-tight tracking-tight text-slate-900 dark:text-slate-50">You have no resumes yet</p>
                  <p class="mt-2 max-w-sm text-sm text-slate-600 dark:text-slate-400">Get started by creating your first professional resume. It's quick and easy!</p>
                  <a href="create_resume.php" class="mt-6 flex h-10 min-w-[84px] cursor-pointer items-center justify-center gap-2 overflow-hidden rounded-lg bg-primary px-5 text-sm font-bold text-white shadow-lg shadow-primary/30 transition-all hover:bg-primary/90 hover:shadow-primary/40 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:ring-offset-2 dark:focus:ring-offset-background-dark">
                    <span class="material-symbols-outlined">add_circle</span>
                    <span class="truncate">Create New Resume</span>
                  </a>
              </div>
            <?php else: ?>
              <?php foreach ($resumes as $resume): ?>
                <div
                  class="group flex flex-col overflow-hidden rounded-xl bg-white dark:bg-slate-900 shadow-sm transition-all hover:shadow-lg dark:hover:shadow-slate-800/60 ring-1 ring-slate-200/80 dark:ring-slate-800/80"
                >
                  <div
                    class="w-full bg-slate-200 dark:bg-slate-800 aspect-[4/3] bg-cover bg-center"
                    data-alt="Thumbnail preview of <?= htmlspecialchars($resume['title']) ?>"
                    style="
                      background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDoBC71TEyy0I9nCxpDQroEO07wlV30vE0RQGNdMkX6gWdbm4Qyo7f8SsnZ5RHK62Qt4zMFr9Hve1v3dzAiDqsMnF5JRILTbFew_46xb1rtiQyYNMIuvqcxpBiOVWKeo8p1A7bg2KQ-Cl-MgHDzdHqf36chuFraWkEySnQpXS15oiGf_Zl0Z5ewrgV2f0ffXZ7J5WJ_eg8DYDeWBXMFnxbDCom5ghQ-vVlyTfJSLsZeutxBXGyq_R9edae17yi8BTaeRbqLyqIzlg');
                    "
                  ></div>
                  <div class="flex flex-1 flex-col p-4">
                    <div class="flex-1">
                      <p
                        class="text-base font-bold leading-normal text-slate-900 dark:text-slate-50"
                      >
                        <?= htmlspecialchars($resume['title']) ?>
                      </p>
                      <p
                        class="text-sm font-normal text-slate-500 dark:text-slate-400"
                      >
                        Last updated: <?= date('M j, Y', strtotime($resume['updated_at'])) ?>
                      </p>
                    </div>
                    <div class="mt-4 flex items-center gap-2">
                      <a
                        href="create_resume.php?id=<?= $resume['id'] ?>"
                        class="flex h-9 flex-1 items-center justify-center gap-2 rounded-lg bg-primary/20 text-sm font-bold text-primary transition-colors hover:bg-primary/30 dark:bg-primary/30 dark:hover:bg-primary/40"
                      >
                        <span class="material-symbols-outlined text-base"
                          >edit</span
                        >
                        Edit
                      </a>
<form method="POST" action="process/delete_resume.php" class="inline" onsubmit="return confirmDelete(this)">
    <input type="hidden" name="resume_id" value="<?= $resume['id'] ?>">
    <button type="submit" class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-500/10 text-sm font-bold text-red-500 transition-colors hover:bg-red-500/20 dark:bg-red-500/20 dark:hover:bg-red-500/30">
        <span class="material-symbols-outlined text-base">delete</span>
    </button>
</form>
                      <a
                        href="process/generate_pdf.php?id=<?= $resume['id'] ?>"
                        class="flex h-9 w-9 items-center justify-center rounded-lg bg-green-500/10 text-sm font-bold text-green-500 transition-colors hover:bg-green-500/20 dark:bg-green-500/20 dark:hover:bg-green-500/30"
                        target="_blank"
                      >
                        <span class="material-symbols-outlined text-base"
                          >download</span
                        >
                      </a>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
      </main>
    </div>
  </body>
</html>
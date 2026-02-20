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
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&amp;display=swap"
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
              "background-light": "#ffffff",
              "background-dark": "#0a0f16",
            },
            fontFamily: {
              display: ["Inter", "sans-serif"],
            },
            borderRadius: {
              DEFAULT: "0.5rem",
              lg: "0.75rem",
              xl: "1rem",
              "2xl": "1.5rem",
              full: "9999px",
            },
            animation: {
              'fade-in': 'fadeIn 0.5s ease-out',
              'slide-up': 'slideUp 0.5s ease-out',
            },
            keyframes: {
              fadeIn: {
                '0%': { opacity: '0' },
                '100%': { opacity: '1' },
              },
              slideUp: {
                '0%': { opacity: '0', transform: 'translateY(20px)' },
                '100%': { opacity: '1', transform: 'translateY(0)' },
              }
            }
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
      
      .glass-effect {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
      }
      
      .dark .glass-effect {
        background: rgba(10, 15, 22, 0.8);
      }
      
      .resume-card {
        position: relative;
        overflow: hidden;
      }
      
      .resume-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
        transition: left 0.5s;
      }
      
      .resume-card:hover::before {
        left: 100%;
      }
    </style>
  </head>
  <body
    class="font-display bg-slate-50 dark:bg-background-dark text-slate-800 dark:text-slate-200 min-h-screen"
  >
    <div class="relative flex min-h-screen w-full flex-col">
      <!-- Decorative Background -->
      <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-blue-400/5 rounded-full blur-3xl"></div>
      </div>

      <!-- TopNavBar -->
      <header
        class="sticky top-0 z-50 glass-effect border-b border-slate-200/50 dark:border-slate-700/50"
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
          <!-- Page Header -->
          <div class="mb-12 animate-fade-in">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
              <div>
                <h1
                  class="text-4xl md:text-5xl font-black tracking-tight text-slate-900 dark:text-slate-50 mb-2"
                >
                  Welcome Back, <span class="gradient-text"><?= htmlspecialchars(explode(' ', $user['name'])[0]) ?></span>!
                </h1>
                <p class="text-lg text-slate-600 dark:text-slate-400">
                  Ready to create your next professional resume?
                </p>
              </div>
              <a
                href="create_resume.php"
                class="group flex h-12 min-w-[200px] cursor-pointer items-center justify-center gap-2 overflow-hidden rounded-xl bg-gradient-to-r from-primary to-blue-500 px-6 text-base font-bold text-white shadow-xl shadow-primary/30 transition-all hover:shadow-2xl hover:shadow-primary/40 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:ring-offset-2 dark:focus:ring-offset-background-dark"
              >
                <span class="material-symbols-outlined">add_circle</span>
                <span class="truncate">Create New Resume</span>
                <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
              </a>
            </div>
          </div>

          <!-- Stats Cards -->
          <?php if (!empty($resumes)): ?>
          <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-12 animate-slide-up">
            <div class="bg-white dark:bg-slate-900/50 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-lg transition-all duration-300">
              <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary/10 text-primary">
                  <span class="material-symbols-outlined text-2xl">description</span>
                </div>
                <div>
                  <p class="text-sm font-medium text-slate-600 dark:text-slate-400">Total Resumes</p>
                  <p class="text-2xl font-black text-slate-900 dark:text-slate-50"><?= count($resumes) ?></p>
                </div>
              </div>
            </div>
            <div class="bg-white dark:bg-slate-900/50 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-lg transition-all duration-300">
              <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-500/10 text-green-500">
                  <span class="material-symbols-outlined text-2xl">check_circle</span>
                </div>
                <div>
                  <p class="text-sm font-medium text-slate-600 dark:text-slate-400">Completed</p>
                  <p class="text-2xl font-black text-slate-900 dark:text-slate-50"><?= count($resumes) ?></p>
                </div>
              </div>
            </div>
            <div class="bg-white dark:bg-slate-900/50 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-lg transition-all duration-300">
              <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-500/10 text-blue-500">
                  <span class="material-symbols-outlined text-2xl">update</span>
                </div>
                <div>
                  <p class="text-sm font-medium text-slate-600 dark:text-slate-400">Last Updated</p>
                  <p class="text-base font-bold text-slate-900 dark:text-slate-50"><?= date('M j', strtotime($resumes[0]['updated_at'])) ?></p>
                </div>
              </div>
            </div>
          </div>
          <?php endif; ?>

          <!-- Section Header -->
          <div class="mb-8 flex items-center justify-between">
            <div>
              <h2
                class="text-3xl font-black tracking-tight text-slate-900 dark:text-slate-50 mb-2"
              >
                Your Resumes
              </h2>
              <p class="text-slate-600 dark:text-slate-400">Manage and edit your professional resumes</p>
            </div>
            <?php if (!empty($resumes)): ?>
            <div class="text-sm font-semibold text-slate-500 dark:text-slate-400">
              <?= count($resumes) ?> <?= count($resumes) === 1 ? 'Resume' : 'Resumes' ?>
            </div>
            <?php endif; ?>
          </div>
          
          <!-- Resume Grid -->
          <div
            class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 animate-slide-up"
            style="animation-delay: 0.1s;"
          >
            <?php if (empty($resumes)): ?>
              <!-- Empty State -->
              <div class="col-span-full mt-8 flex flex-col items-center justify-center rounded-2xl border-2 border-dashed border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900/30 p-16 text-center">
                  <div class="mb-6 inline-flex items-center justify-center w-20 h-20 rounded-full bg-primary/10">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-primary">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                  </div>
                  <h3 class="text-2xl font-black leading-tight tracking-tight text-slate-900 dark:text-slate-50 mb-3">No resumes yet</h3>
                  <p class="max-w-md text-base text-slate-600 dark:text-slate-400 mb-8">Get started by creating your first professional resume. It's quick and easy with our intuitive builder!</p>
                  <a href="create_resume.php" class="group flex h-12 min-w-[200px] cursor-pointer items-center justify-center gap-2 overflow-hidden rounded-xl bg-gradient-to-r from-primary to-blue-500 px-6 text-base font-bold text-white shadow-xl shadow-primary/30 transition-all hover:shadow-2xl hover:shadow-primary/40 hover:scale-105">
                    <span class="material-symbols-outlined">add_circle</span>
                    <span class="truncate">Create Your First Resume</span>
                    <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                  </a>
              </div>
            <?php else: ?>
              <?php foreach ($resumes as $index => $resume): ?>
                <div
                  class="resume-card group flex flex-col overflow-hidden rounded-2xl bg-white dark:bg-slate-900 shadow-md transition-all hover:shadow-2xl hover:shadow-primary/10 dark:hover:shadow-slate-800/60 ring-1 ring-slate-200/80 dark:ring-slate-700/80 hover:-translate-y-2 duration-300"
                  style="animation: slideUp 0.5s ease-out <?= $index * 0.05 ?>s backwards;"
                >
                  <div class="relative">
                    <div
                      class="w-full bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-900 aspect-[4/3] bg-cover bg-center"
                      data-alt="Thumbnail preview of <?= htmlspecialchars($resume['title']) ?>"
                      style="
                        background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDoBC71TEyy0I9nCxpDQroEO07wlV30vE0RQGNdMkX6gWdbm4Qyo7f8SsnZ5RHK62Qt4zMFr9Hve1v3dzAiDqsMnF5JRILTbFew_46xb1rtiQyYNMIuvqcxpBiOVWKeo8p1A7bg2KQ-Cl-MgHDzdHqf36chuFraWkEySnQpXS15oiGf_Zl0Z5ewrgV2f0ffXZ7J5WJ_eg8DYDeWBXMFnxbDCom5ghQ-vVlyTfJSLsZeutxBXGyq_R9edae17yi8BTaeRbqLyqIzlg');
                      "
                    ></div>
                    <div class="absolute top-3 right-3 px-3 py-1 rounded-full text-xs font-bold bg-white/90 dark:bg-slate-900/90 text-slate-700 dark:text-slate-300 backdrop-blur-sm">
                      <?= date('M j', strtotime($resume['updated_at'])) ?>
                    </div>
                  </div>
                  <div class="flex flex-1 flex-col p-5">
                    <div class="flex-1 mb-4">
                      <p
                        class="text-lg font-bold leading-snug text-slate-900 dark:text-slate-50 mb-1 line-clamp-2"
                      >
                        <?= htmlspecialchars($resume['title']) ?>
                      </p>
                      <p
                        class="text-sm font-medium text-slate-500 dark:text-slate-400 flex items-center gap-1"
                      >
                        <span class="material-symbols-outlined text-base">update</span>
                        Updated <?= date('M j, Y', strtotime($resume['updated_at'])) ?>
                      </p>
                    </div>
                    <div class="flex items-center gap-2">
                      <a
                        href="create_resume.php?id=<?= $resume['id'] ?>"
                        class="flex h-10 flex-1 items-center justify-center gap-2 rounded-xl bg-primary/10 text-sm font-bold text-primary transition-all hover:bg-primary/20 hover:scale-105 dark:bg-primary/20 dark:hover:bg-primary/30"
                      >
                        <span class="material-symbols-outlined text-lg">edit</span>
                        Edit
                      </a>
                      <a
                        href="process/generate_pdf.php?id=<?= $resume['id'] ?>"
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-500/10 text-sm font-bold text-green-600 dark:text-green-500 transition-all hover:bg-green-500/20 hover:scale-105 dark:bg-green-500/20 dark:hover:bg-green-500/30"
                        target="_blank"
                        title="Download PDF"
                      >
                        <span class="material-symbols-outlined text-lg">download</span>
                      </a>
                      <form method="POST" action="process/delete_resume.php" class="inline" onsubmit="return confirmDelete(this)">
                        <input type="hidden" name="resume_id" value="<?= $resume['id'] ?>">
                        <button type="submit" class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-500/10 text-sm font-bold text-red-600 dark:text-red-500 transition-all hover:bg-red-500/20 hover:scale-105 dark:bg-red-500/20 dark:hover:bg-red-500/30" title="Delete Resume">
                            <span class="material-symbols-outlined text-lg">delete</span>
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
      </main>

      <!-- Footer -->
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
      function confirmDelete(form) {
        if (confirm('Are you sure you want to delete this resume? This action cannot be undone.')) {
          return true;
        }
        return false;
      }
    </script>
  </body>
</html>
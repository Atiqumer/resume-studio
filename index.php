<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html class="light" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>ResumeBuilder - Build a Resume That Gets Noticed</title>
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
    class="bg-background-light dark:bg-background-dark font-display text-[#0e141b] dark:text-slate-200"
  >
    <div class="relative flex min-h-screen w-full flex-col">
      <!-- TopNavBar -->
      <header
        class="fixed w-full top-0 z-50 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-sm border-b border-slate-200 dark:border-slate-800"
      >
        <div class="container mx-auto px-4">
          <div class="flex h-16 items-center justify-between">
            <div class="flex items-center gap-4 text-primary">
              <span class="material-symbols-outlined text-3xl"
                >description</span
              >
              <h2 class="text-[#0e141b] dark:text-slate-50 text-xl font-bold">
                ResumeStudio
              </h2>
            </div>
            <div class="flex items-center gap-2">
              <button
                class="flex min-w-[84px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-slate-200/80 dark:bg-slate-800 text-[#0e141b] dark:text-slate-50 text-sm font-bold leading-normal tracking-[0.015em] hover:bg-slate-300 dark:hover:bg-slate-700 transition-colors"
                onclick="showLoginModal()"
              >
                <span class="truncate">Login</span>
              </button>
              <button
                class="flex min-w-[84px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary text-slate-50 text-sm font-bold leading-normal tracking-[0.015em] hover:bg-primary/90 transition-colors"
                onclick="showSignupModal()"
              >
                <span class="truncate">Get Started</span>
              </button>
            </div>
          </div>
        </div>
      </header>
      <main class="flex-grow">
        <!-- HeroSection -->
        <section class="py-20 md:py-32">
          <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 items-center gap-12 md:grid-cols-2">
              <div class="flex flex-col gap-6 text-center md:text-left">
                <h1
                  class="text-4xl font-black leading-tight tracking-tight text-[#0e141b] dark:text-slate-50 md:text-5xl lg:text-6xl"
                >
                  Build a Resume That Gets Noticed
                </h1>
                <p
                  class="text-base font-normal leading-normal text-slate-600 dark:text-slate-400 md:text-lg"
                >
                  Create a professional, standout resume in minutes with our
                  easy-to-use tools.
                </p>
                <div
                  class="mt-4 flex flex-col items-center gap-4 sm:flex-row md:justify-start"
                >
                  <button
                    class="flex w-full sm:w-auto min-w-[120px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 px-5 bg-primary text-slate-50 text-base font-bold leading-normal tracking-[0.015em] hover:bg-primary/90 transition-colors shadow-lg shadow-primary/20"
                    onclick="showSignupModal()"
                  >
                    <span class="truncate">Get Started Now</span>
                  </button>
                </div>
              </div>
              <div class="flex justify-center">
                <img
                  class="rounded-xl shadow-2xl aspect-square object-cover w-full max-w-md"
                  data-alt="A professional reviewing a resume on a tablet in a modern office setting"
                  src="https://lh3.googleusercontent.com/aida-public/AB6AXuCiNSD7DyW9OfDLvArve2mWNCSGAZDnxf1_DlhDyoOCrNoubhewW3VqYBAO_I87rOg3dy5Xf2OpEdknJazFsDTDB6cPRImS652nt9cN5xLDxM30hhds6O5AmvaOKEZHf20NBz3wnVYShKdZidIv1_8oehi0-GKhNqpctpLpaiEkHCYun8nyxFUt3kDarO9Gx8Li6HOxSG1TQg1HsO-DzHt7kCjS0S3SoaHdCH0bFPTJxbwLfXl4HxC4MCXPg-FU7JmkzRxp_jaJ6w"
                />
              </div>
            </div>
          </div>
        </section>
        <!-- FeatureSection -->
        <section class="py-20 md:py-24 bg-slate-100 dark:bg-background-dark">
          <div class="container mx-auto px-4">
            <div class="flex flex-col gap-12">
              <div class="text-center">
                <h2
                  class="text-3xl font-bold leading-tight tracking-tight text-[#0e141b] dark:text-slate-50 md:text-4xl"
                >
                  Why Choose Us?
                </h2>
                <p
                  class="mt-4 max-w-2xl mx-auto text-base font-normal leading-normal text-slate-600 dark:text-slate-400 md:text-lg"
                >
                  Our platform is designed to make resume building simple, fast,
                  and effective.
                </p>
              </div>
              <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                <div
                  class="flex flex-col gap-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-background-light dark:bg-slate-900/50 p-6 text-center shadow-sm hover:shadow-lg transition-shadow"
                >
                  <div
                    class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-primary/10 text-primary"
                  >
                    <span class="material-symbols-outlined text-3xl"
                      >edit_document</span
                    >
                  </div>
                  <div class="flex flex-col gap-1">
                    <h3
                      class="text-lg font-bold leading-tight text-[#0e141b] dark:text-slate-50"
                    >
                      Easy to Use
                    </h3>
                    <p
                      class="text-sm font-normal leading-normal text-slate-500 dark:text-slate-400"
                    >
                      Our intuitive editor makes formatting your resume a
                      breeze, no design skills required.
                    </p>
                  </div>
                </div>
                <div
                  class="flex flex-col gap-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-background-light dark:bg-slate-900/50 p-6 text-center shadow-sm hover:shadow-lg transition-shadow"
                >
                  <div
                    class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-primary/10 text-primary"
                  >
                    <span class="material-symbols-outlined text-3xl"
                      >layers</span
                    >
                  </div>
                  <div class="flex flex-col gap-1">
                    <h3
                      class="text-lg font-bold leading-tight text-[#0e141b] dark:text-slate-50"
                    >
                      Professional Templates
                    </h3>
                    <p
                      class="text-sm font-normal leading-normal text-slate-500 dark:text-slate-400"
                    >
                      Choose from a library of professionally designed templates
                      proven to impress recruiters.
                    </p>
                  </div>
                </div>
                <div
                  class="flex flex-col gap-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-background-light dark:bg-slate-900/50 p-6 text-center shadow-sm hover:shadow-lg transition-shadow"
                >
                  <div
                    class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-primary/10 text-primary"
                  >
                    <span class="material-symbols-outlined text-3xl"
                      >auto_awesome</span
                    >
                  </div>
                  <div class="flex flex-col gap-1">
                    <h3
                      class="text-lg font-bold leading-tight text-[#0e141b] dark:text-slate-50"
                    >
                      AI-Powered Suggestions
                    </h3>
                    <p
                      class="text-sm font-normal leading-normal text-slate-500 dark:text-slate-400"
                    >
                      Get smart, data-driven tips to optimize your resume
                      content for any job application.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </main>
      <!-- Footer -->
      <footer
        class="bg-slate-100 dark:bg-background-dark border-t border-slate-200 dark:border-slate-800"
      >
        <div class="container mx-auto px-4 py-10">
          <div class="flex flex-col items-center gap-6 text-center">
            <div
              class="flex flex-wrap items-center justify-center gap-x-6 gap-y-2"
            >
              <a
                class="text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-primary text-sm font-medium leading-normal transition-colors"
                href="#"
                >About</a
              >
              <a
                class="text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-primary text-sm font-medium leading-normal transition-colors"
                href="#"
                >Contact</a
              >
              <a
                class="text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-primary text-sm font-medium leading-normal transition-colors"
                href="#"
                >Privacy Policy</a
              >
              <a
                class="text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-primary text-sm font-medium leading-normal transition-colors"
                href="#"
                >Terms of Service</a
              >
            </div>
            <div class="flex justify-center gap-4">
              <a
                class="text-slate-400 dark:text-slate-500 hover:text-primary dark:hover:text-primary transition-colors"
                href="#"
              >
                <svg
                  aria-hidden="true"
                  class="h-6 w-6"
                  fill="currentColor"
                  viewbox="0 0 24 24"
                >
                  <path
                    d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.71v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"
                  ></path>
                </svg>
              </a>
              <a
                class="text-slate-400 dark:text-slate-500 hover:text-primary dark:hover:text-primary transition-colors"
                href="#"
              >
                <svg
                  aria-hidden="true"
                  class="h-6 w-6"
                  fill="currentColor"
                  viewbox="0 0 24 24"
                >
                  <path
                    clip-rule="evenodd"
                    d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"
                    fill-rule="evenodd"
                  ></path>
                </svg>
              </a>
              <a
                class="text-slate-400 dark:text-slate-500 hover:text-primary dark:hover:text-primary transition-colors"
                href="#"
              >
                <svg
                  aria-hidden="true"
                  class="h-6 w-6"
                  fill="currentColor"
                  viewbox="0 0 24 24"
                >
                  <path
                    clip-rule="evenodd"
                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                    fill-rule="evenodd"
                  ></path>
                </svg>
              </a>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400">
              © 2025 ResumeStudio. All rights reserved.
            </p>
          </div>
        </div>
      </footer>
    </div>

    <!-- Login Modal -->
    <div
      class="w-full h-full fixed top-0 left-0 bg-black/50 hidden justify-center items-center z-[1000]"
      id="loginModal"
    >
      <div class="relative bg-white w-[90%] max-w-[450px] rounded-xl p-[2rem]">
        <span
          class="absolute top-[20px] right-[20px] text-2xl cursor-pointer text-[#95a5a6]"
          onclick="closeLoginModal()"
          >&times;</span
        >
        <h1 class="font-bold text-2xl text-center mb-[1.5rem]">Welcome Back</h1>
        
        <?php if (isset($_SESSION['login_errors'])): ?>
            <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                <?php foreach ($_SESSION['login_errors'] as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
                <?php unset($_SESSION['login_errors']); ?>
            </div>
        <?php endif; ?>
        
        <form action="process/login.php" method="POST">
            <div class="mb-[1.25rem]">
                <label for="login_email" class="block font-medium mb-[0.25rem]">Email Address</label>
                <input type="email" name="email" id="login_email" placeholder="Enter your email" 
                       value="<?= htmlspecialchars($_SESSION['old_login']['email'] ?? '') ?>" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary/50">
            </div>
            <div class="mb-[1.25rem]">
                <label for="login_password" class="block font-medium mb-[0.25rem]">Password</label>
                <input type="password" name="password" id="login_password" placeholder="Enter your password" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary/50">
            </div>
            <button type="submit" class="w-full cursor-pointer mt-[0.5rem] rounded-lg p-[0.75rem] bg-primary text-slate-50 text-sm font-bold leading-normal tracking-[0.015em] hover:bg-primary/90 transition-colors">
                <span class="truncate">Login</span>
            </button>
            <div class="mt-[1.5rem] text-center text-[0.875rem]">
                Don't have an account?
                <button type="button" class="text-primary border-none font-medium" onclick="switchToSignup()">
                    Sign Up
                </button>
            </div>
        </form>
      </div>
    </div>

    <!-- Signup Modal -->
    <div
      class="w-full h-full fixed top-0 left-0 bg-black/50 hidden justify-center items-center z-[1000]"
      id="signupModal"
    >
      <div class="bg-white w-[90%] max-w-[450px] rounded-xl p-[2rem] relative">
        <span
          class="absolute top-[20px] right-[20px] text-2xl cursor-pointer text-[#95a5a6]"
          onclick="closeSignupModal()"
          >&times;</span
        >
        <h1 class="font-bold text-2xl text-center mb-[1.5rem]">Create Your Account</h1>
        
        <?php if (isset($_SESSION['signup_errors'])): ?>
            <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                <?php foreach ($_SESSION['signup_errors'] as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
                <?php unset($_SESSION['signup_errors']); ?>
            </div>
        <?php endif; ?>
        
        <form action="process/signup.php" method="POST">
            <div class="mb-[1.25rem]">
                <label for="signup_name" class="block font-medium mb-[0.25rem]">Full Name</label>
                <input type="text" name="name" id="signup_name" placeholder="Enter your full name" 
                       value="<?= htmlspecialchars($_SESSION['old_signup']['name'] ?? '') ?>"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary/50">
            </div>
            <div class="mb-[1.25rem]">
                <label for="signup_email" class="block font-medium mb-[0.25rem]">Email Address</label>
                <input type="email" name="email" id="signup_email" placeholder="Enter your email" 
                       value="<?= htmlspecialchars($_SESSION['old_signup']['email'] ?? '') ?>"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary/50">
            </div>
            <div class="mb-[1.25rem]">
                <label for="signup_password" class="block font-medium mb-[0.25rem]">Password</label>
                <input type="password" name="password" id="signup_password" placeholder="Enter your password" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary/50">
            </div>
            <div class="mb-[1.25rem]">
                <label for="confirm_password" class="block font-medium mb-[0.25rem]">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm your password" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary/50">
            </div>
            <button type="submit" class="w-full cursor-pointer mt-[0.5rem] rounded-lg p-[0.75rem] bg-primary text-slate-50 text-sm font-bold leading-normal tracking-[0.015em] hover:bg-primary/90 transition-colors">
                <span class="truncate">Sign Up</span>
            </button>
            <div class="mt-[1.5rem] text-center text-[0.875rem]">
                Already have an account?
                <button type="button" class="text-primary border-none font-medium" onclick="switchToLogin()">
                    Login
                </button>
            </div>
        </form>
      </div>
    </div>

    <script>
      function showLoginModal() {
        const loginModal = document.getElementById("loginModal");
        loginModal.classList.add("flex");
        loginModal.classList.remove("hidden");
      }

      function showSignupModal() {
        const signupModal = document.getElementById("signupModal");
        signupModal.classList.add("flex");
        signupModal.classList.remove("hidden");
      }

      function closeLoginModal() {
        const loginModal = document.getElementById("loginModal");
        loginModal.classList.remove("flex");
        loginModal.classList.add("hidden");
      }

      function closeSignupModal() {
        const signupModal = document.getElementById("signupModal");
        signupModal.classList.remove("flex");
        signupModal.classList.add("hidden");
      }

      function switchToSignup() {
        closeLoginModal();
        showSignupModal();
      }

      function switchToLogin() {
        closeSignupModal();
        showLoginModal();
      }

      // Close modal when clicking outside
      window.onclick = function(event) {
        const loginModal = document.getElementById('loginModal');
        const signupModal = document.getElementById('signupModal');
        
        if (event.target === loginModal) {
          closeLoginModal();
        }
        if (event.target === signupModal) {
          closeSignupModal();
        }
      }
    </script>
  </body>
</html>
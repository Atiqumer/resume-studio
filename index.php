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
              'float': 'float 6s ease-in-out infinite',
              'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
            },
            keyframes: {
              float: {
                '0%, 100%': { transform: 'translateY(0px)' },
                '50%': { transform: 'translateY(-20px)' },
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
      
      @keyframes fadeInUp {
        from {
          opacity: 0;
          transform: translateY(30px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }
      
      .animate-fadeInUp {
        animation: fadeInUp 0.6s ease-out forwards;
      }
      
      .gradient-text {
        background: linear-gradient(135deg, #308ce8 0%, #60a5fa 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
      }
      
      .glass-effect {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
      }
      
      .dark .glass-effect {
        background: rgba(17, 25, 33, 0.7);
      }
      
      .hero-gradient {
        background: linear-gradient(135deg, rgba(48, 140, 232, 0.05) 0%, rgba(96, 165, 250, 0.05) 100%);
      }
      
      .dark .hero-gradient {
        background: linear-gradient(135deg, rgba(48, 140, 232, 0.1) 0%, rgba(96, 165, 250, 0.1) 100%);
      }
    </style>
  </head>
  <body
    class="bg-background-light dark:bg-background-dark font-display text-[#0e141b] dark:text-slate-200 overflow-x-hidden"
  >
    <div class="relative flex min-h-screen w-full flex-col">
      <!-- Decorative Background Elements -->
      <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="absolute top-20 left-10 w-72 h-72 bg-primary/10 rounded-full blur-3xl animate-pulse-slow"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-blue-400/10 rounded-full blur-3xl animate-pulse-slow" style="animation-delay: 2s;"></div>
      </div>

      <!-- TopNavBar -->
      <header
        class="fixed w-full top-0 z-50 glass-effect border-b border-slate-200/50 dark:border-slate-700/50"
      >
        <div class="container mx-auto px-4 lg:px-8">
          <div class="flex h-20 items-center justify-between">
            <a href="index.php" class="flex items-center gap-3 group cursor-pointer">
            <div class="flex items-center gap-3 group cursor-pointer">
              <div class="text-primary bg-primary/10 p-2 rounded-xl group-hover:scale-110 transition-transform duration-300">
                <span class="material-symbols-outlined text-3xl">description</span>
              </div>
              <h2 class="text-[#0e141b] dark:text-slate-50 text-2xl font-black tracking-tight">
                Resume<span class="gradient-text">Studio</span>
              </h2>
            </div>
    </a>
            <div class="flex items-center gap-3">
              <button
                class="flex min-w-[100px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-11 px-6 bg-slate-100 dark:bg-slate-800 text-[#0e141b] dark:text-slate-50 text-sm font-semibold leading-normal hover:bg-slate-200 dark:hover:bg-slate-700 transition-all duration-300 hover:scale-105"
                onclick="showLoginModal()"
              >
                <span class="truncate">Login</span>
              </button>
              <button
                class="flex min-w-[120px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-11 px-6 bg-gradient-to-r from-primary to-blue-500 text-white text-sm font-semibold leading-normal hover:shadow-xl hover:shadow-primary/30 transition-all duration-300 hover:scale-105"
                onclick="showSignupModal()"
              >
                <span class="truncate">Get Started</span>
              </button>
            </div>
          </div>
        </div>
      </header>

      <main class="flex-grow relative z-10">
        <!-- HeroSection -->
        <section class="pt-32 pb-20 md:pt-40 md:pb-32 hero-gradient">
          <div class="container mx-auto px-4 lg:px-8">
            <div class="grid grid-cols-1 items-center gap-16 lg:grid-cols-2">
              <div class="flex flex-col gap-8 text-center lg:text-left animate-fadeInUp">
                <div class="inline-flex items-center justify-center lg:justify-start">
                  <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/10 text-primary text-sm font-semibold">
                    <span class="material-symbols-outlined text-lg">auto_awesome</span>
                    Resume Builder
                  </span>
                </div>
                <h1
                  class="text-5xl font-black leading-tight tracking-tight text-[#0e141b] dark:text-slate-50 md:text-6xl lg:text-7xl"
                >
                  Build a Resume That <span class="gradient-text">Gets Noticed</span>
                </h1>
                <p
                  class="text-lg font-normal leading-relaxed text-slate-600 dark:text-slate-400 md:text-xl max-w-2xl mx-auto lg:mx-0"
                >
                  Create a professional, standout resume in minutes with our easy-to-use tools and AI-powered suggestions.
                </p>
                <div
                  class="mt-4 flex flex-col items-center gap-4 sm:flex-row lg:justify-start"
                >
                  <button
                    class="group flex w-full sm:w-auto min-w-[180px] cursor-pointer items-center justify-center gap-2 overflow-hidden rounded-xl h-14 px-8 bg-gradient-to-r from-primary to-blue-500 text-white text-base font-bold leading-normal hover:shadow-2xl hover:shadow-primary/40 transition-all duration-300 hover:scale-105"
                    onclick="showSignupModal()"
                  >
                    <span class="truncate">Get Started Now</span>
                    <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                  </button>
                  <button
                    class="flex w-full sm:w-auto min-w-[140px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-14 px-8 border-2 border-slate-200 dark:border-slate-700 text-[#0e141b] dark:text-slate-50 text-base font-semibold leading-normal hover:border-primary dark:hover:border-primary hover:bg-primary/5 transition-all duration-300"
                    onclick="document.querySelector('#features').scrollIntoView({behavior: 'smooth'})"
                  >
                    <span class="truncate">Learn More</span>
                  </button>
                </div>
                <div class="flex items-center justify-center lg:justify-start gap-8 mt-6">
                  <div class="text-center lg:text-left">
                    <div class="text-3xl font-bold text-[#0e141b] dark:text-slate-50">10K+</div>
                    <div class="text-sm text-slate-500 dark:text-slate-400">Resumes Created</div>
                  </div>
                  <div class="w-px h-12 bg-slate-200 dark:bg-slate-700"></div>
                  <div class="text-center lg:text-left">
                    <div class="text-3xl font-bold text-[#0e141b] dark:text-slate-50">95%</div>
                    <div class="text-sm text-slate-500 dark:text-slate-400">Success Rate</div>
                  </div>
                  <div class="w-px h-12 bg-slate-200 dark:bg-slate-700"></div>
                  <div class="text-center lg:text-left">
                    <div class="text-3xl font-bold text-[#0e141b] dark:text-slate-50">4.9★</div>
                    <div class="text-sm text-slate-500 dark:text-slate-400">User Rating</div>
                  </div>
                </div>
              </div>
              <div class="flex justify-center lg:justify-end animate-fadeInUp" style="animation-delay: 0.2s;">
                <div class="relative">
                  <div class="absolute inset-0 bg-gradient-to-br from-primary/20 to-blue-500/20 rounded-3xl blur-2xl"></div>
                  <img
                    class="relative rounded-3xl shadow-2xl aspect-square object-cover w-full max-w-lg border-4 border-white/50 dark:border-slate-800/50 hover:scale-105 transition-transform duration-500 animate-float"
                    alt="A professional reviewing a resume on a tablet in a modern office setting"
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuCiNSD7DyW9OfDLvArve2mWNCSGAZDnxf1_DlhDyoOCrNoubhewW3VqYBAO_I87rOg3dy5Xf2OpEdknJazFsDTDB6cPRImS652nt9cN5xLDxM30hhds6O5AmvaOKEZHf20NBz3wnVYShKdZidIv1_8oehi0-GKhNqpctpLpaiEkHCYun8nyxFUt3kDarO9Gx8Li6HOxSG1TQg1HsO-DzHt7kCjS0S3SoaHdCH0bFPTJxbwLfXl4HxC4MCXPg-FU7JmkzRxp_jaJ6w"
                  />
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- FeatureSection -->
        <section id="features" class="py-24 md:py-32 bg-slate-50 dark:bg-slate-900/30">
          <div class="container mx-auto px-4 lg:px-8">
            <div class="flex flex-col gap-16">
              <div class="text-center max-w-3xl mx-auto">
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/10 text-primary text-sm font-semibold mb-6">
                  <span class="material-symbols-outlined text-lg">workspace_premium</span>
                  Features
                </span>
                <h2
                  class="text-4xl font-black leading-tight tracking-tight text-[#0e141b] dark:text-slate-50 md:text-5xl lg:text-6xl"
                >
                  Why Choose <span class="gradient-text">ResumeStudio</span>?
                </h2>
                <p
                  class="mt-6 text-lg font-normal leading-relaxed text-slate-600 dark:text-slate-400 md:text-xl"
                >
                  Our platform is designed to make resume building simple, fast, and effective with cutting-edge features.
                </p>
              </div>
              <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                <div
                  class="group flex flex-col gap-6 rounded-2xl border border-slate-200/50 dark:border-slate-700/50 bg-white dark:bg-slate-900/50 p-8 shadow-lg hover:shadow-2xl hover:shadow-primary/10 transition-all duration-500 hover:-translate-y-2"
                >
                  <div
                    class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-primary/20 to-blue-400/20 text-primary group-hover:scale-110 transition-transform duration-300"
                  >
                    <span class="material-symbols-outlined text-4xl">edit_document</span>
                  </div>
                  <div class="flex flex-col gap-3">
                    <h3
                      class="text-2xl font-bold leading-tight text-[#0e141b] dark:text-slate-50"
                    >
                      Easy to Use
                    </h3>
                    <p
                      class="text-base font-normal leading-relaxed text-slate-600 dark:text-slate-400"
                    >
                      Our intuitive drag-and-drop editor makes formatting your resume a breeze. No design skills required—just add your information and go.
                    </p>
                  </div>
                </div>
                <div
                  class="group flex flex-col gap-6 rounded-2xl border border-slate-200/50 dark:border-slate-700/50 bg-white dark:bg-slate-900/50 p-8 shadow-lg hover:shadow-2xl hover:shadow-primary/10 transition-all duration-500 hover:-translate-y-2"
                >
                  <div
                    class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-primary/20 to-blue-400/20 text-primary group-hover:scale-110 transition-transform duration-300"
                  >
                    <span class="material-symbols-outlined text-4xl">layers</span>
                  </div>
                  <div class="flex flex-col gap-3">
                    <h3
                      class="text-2xl font-bold leading-tight text-[#0e141b] dark:text-slate-50"
                    >
                      Professional Templates
                    </h3>
                    <p
                      class="text-base font-normal leading-relaxed text-slate-600 dark:text-slate-400"
                    >
                      Choose from a library of 50+ professionally designed templates that are proven to impress recruiters and hiring managers.
                    </p>
                  </div>
                </div>
                <div
                  class="group flex flex-col gap-6 rounded-2xl border border-slate-200/50 dark:border-slate-700/50 bg-white dark:bg-slate-900/50 p-8 shadow-lg hover:shadow-2xl hover:shadow-primary/10 transition-all duration-500 hover:-translate-y-2"
                >
                  <div
                    class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-primary/20 to-blue-400/20 text-primary group-hover:scale-110 transition-transform duration-300"
                  >
                    <span class="material-symbols-outlined text-4xl">auto_awesome</span>
                  </div>
                  <div class="flex flex-col gap-3">
                    <h3
                      class="text-2xl font-bold leading-tight text-[#0e141b] dark:text-slate-50"
                    >
                      AI-Powered Suggestions
                    </h3>
                    <p
                      class="text-base font-normal leading-relaxed text-slate-600 dark:text-slate-400"
                    >
                      Get smart, data-driven tips powered by AI to optimize your resume content for any job application and beat ATS systems.
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
        class="bg-slate-50 dark:bg-slate-900/30 border-t border-slate-200/50 dark:border-slate-700/50"
      >
        <div class="container mx-auto px-4 lg:px-8 py-12">
          <div class="flex flex-col items-center gap-8 text-center">
            <div class="flex items-center gap-3">
              <div class="text-primary bg-primary/10 p-2 rounded-xl">
                <span class="material-symbols-outlined text-2xl">description</span>
              </div>
              <h2 class="text-[#0e141b] dark:text-slate-50 text-xl font-black">
                Resume<span class="gradient-text">Studio</span>
              </h2>
            </div>
            <div
              class="flex flex-wrap items-center justify-center gap-x-8 gap-y-3"
            >
              <a
                class="text-slate-600 dark:text-slate-400 hover:text-primary dark:hover:text-primary text-sm font-medium leading-normal transition-colors"
                href="#"
                >About</a
              >
              <a
                class="text-slate-600 dark:text-slate-400 hover:text-primary dark:hover:text-primary text-sm font-medium leading-normal transition-colors"
                href="#"
                >Contact</a
              >
              <a
                class="text-slate-600 dark:text-slate-400 hover:text-primary dark:hover:text-primary text-sm font-medium leading-normal transition-colors"
                href="#"
                >Privacy Policy</a
              >
              <a
                class="text-slate-600 dark:text-slate-400 hover:text-primary dark:hover:text-primary text-sm font-medium leading-normal transition-colors"
                href="#"
                >Terms of Service</a
              >
            </div>
            <div class="flex justify-center gap-6">
              <a
                class="text-slate-400 dark:text-slate-500 hover:text-primary dark:hover:text-primary transition-all duration-300 hover:scale-110"
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
                class="text-slate-400 dark:text-slate-500 hover:text-primary dark:hover:text-primary transition-all duration-300 hover:scale-110"
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
                class="text-slate-400 dark:text-slate-500 hover:text-primary dark:hover:text-primary transition-all duration-300 hover:scale-110"
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
      class="w-full h-full fixed top-0 left-0 bg-black/60 backdrop-blur-sm hidden justify-center items-center z-[1000] p-4"
      id="loginModal"
    >
      <div class="relative bg-white dark:bg-slate-900 w-full max-w-[480px] rounded-2xl p-8 shadow-2xl animate-fadeInUp border border-slate-200 dark:border-slate-700">
        <button
          class="absolute top-6 right-6 text-3xl cursor-pointer text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors hover:rotate-90 transition-transform duration-300"
          onclick="closeLoginModal()"
        >&times;</button>
        
        <div class="flex flex-col items-center gap-3 mb-8">
          <div class="text-primary bg-primary/10 p-3 rounded-2xl">
            <span class="material-symbols-outlined text-3xl">lock</span>
          </div>
          <h1 class="font-black text-3xl text-center text-[#0e141b] dark:text-slate-50">Welcome Back</h1>
          <p class="text-slate-500 dark:text-slate-400 text-center">Sign in to continue to your account</p>
        </div>
        
        <?php if (isset($_SESSION['login_errors'])): ?>
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 rounded-xl">
                <?php foreach ($_SESSION['login_errors'] as $error): ?>
                    <p class="text-sm"><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
                <?php unset($_SESSION['login_errors']); ?>
            </div>
        <?php endif; ?>
        
        <form action="process/login.php" method="POST" class="space-y-5">
            <div>
                <label for="login_email" class="block font-semibold mb-2 text-sm text-[#0e141b] dark:text-slate-50">Email Address</label>
                <input type="email" name="email" id="login_email" placeholder="john@example.com" 
                       value="<?= htmlspecialchars($_SESSION['old_login']['email'] ?? '') ?>" 
                       class="w-full border-2 border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all bg-white dark:bg-slate-800 text-[#0e141b] dark:text-slate-50"
                       required>
            </div>
            <div>
                <label for="login_password" class="block font-semibold mb-2 text-sm text-[#0e141b] dark:text-slate-50">Password</label>
                <input type="password" name="password" id="login_password" placeholder="••••••••" 
                       class="w-full border-2 border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all bg-white dark:bg-slate-800 text-[#0e141b] dark:text-slate-50"
                       required>
            </div>
            <button type="submit" class="w-full cursor-pointer mt-6 rounded-xl py-3.5 bg-gradient-to-r from-primary to-blue-500 text-white text-base font-bold leading-normal hover:shadow-xl hover:shadow-primary/30 transition-all duration-300 hover:scale-[1.02]">
                <span class="truncate">Sign In</span>
            </button>
            <div class="mt-6 text-center text-sm">
                <span class="text-slate-600 dark:text-slate-400">Don't have an account?</span>
                <button type="button" class="text-primary border-none font-semibold ml-1 hover:underline" onclick="switchToSignup()">
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
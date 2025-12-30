# 🎨  Resume Studio

## Overview

Welcome to ** Resume Studio**! This is a dynamic, web-based application designed to help users quickly and easily create professional, high-quality resumes. By leveraging a user-friendly interface and a selection of modern templates, job seekers can focus on their experience while the studio handles the formatting and structure. The "AI" element suggests potential features like content optimization, keyword suggestions, or automated section generation, streamlining the resume creation process.

---

## ✨ Features

Based on the file structure, the following features are likely included:

* **Template Selection:** Choose from multiple professional resume templates (inferred from the `/templates` directory).
* **User Dashboard:** A personalized dashboard (`dashboard.php`) for managing saved resume drafts and user profiles.
* **Guided Resume Creation:** Step-by-step forms to input personal, experience, education, and skills data (`create_resume.php`).
* **PDF Export:** Generate print-ready PDF files of the completed resumes (using the `dompdf` library).
* **Database Integration:** Store user and resume data securely (inferred from `resume_builder_db.sql`).

---

## 🛠️ Technology Stack

The project is primarily built using the following technologies:

* **Backend:** PHP
* **Database:** MySQL (using the included `resume_builder_db.sql` schema)
* **PDF Generation:** `dompdf`
* **Frontend:** HTML, CSS, JavaScript (inferred for web application interface)

---

## 🚀 Getting Started

Follow these steps to set up and run the **AI Resume Studio** locally.

### Prerequisites

You will need a local server environment (like XAMPP, WAMP, MAMP, or a standalone Apache/Nginx server) with **PHP** and **MySQL** installed.

### Installation

1.  **Clone the repository:**
    ```bash
    git clone [https://github.com/Atiqumer/AI-resume-studio.git](https://github.com/Atiqumer/AI-resume-studio.git)
    cd AI-resume-studio
    ```

2.  **Database Setup:**
    * Create a new database in your MySQL environment (e.g., using phpMyAdmin or a command-line client).
    * Import the database schema using the provided SQL file:
        ```bash
        # (Example Command - adjust based on your setup)
        mysql -u [your_username] -p [your_database_name] < resume_builder_db.sql
        ```

3.  **Configure Database Connection:**
    * Navigate to the `/includes` folder.
    * Find the database configuration file (e.g., `db_config.php` or similar—you may need to check the folder contents) and update the credentials (`DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME`) to match your local database setup.

4.  **Place in Web Root:**
    * Move the entire `AI-resume-studio` folder into your web server's document root (e.g., `htdocs` for XAMPP).

### Usage

1.  Open your web browser and navigate to the project's URL (e.g., `http://localhost/AI-resume-studio`).
2.  The main page (`index.php`) should load, allowing users to sign up or log in.
3.  Once logged in, navigate to the dashboard (`dashboard.php`) to begin creating a new resume using the guided steps.

---

## 🤝 Contributing

Contributions are welcome! If you would like to contribute, please follow these steps:

1.  Fork the repository.
2.  Create a new branch (`git checkout -b feature/your-feature-name`).
3.  Make your changes and commit them (`git commit -m 'Add new feature'`).
4.  Push to the branch (`git push origin feature/your-feature-name`).
5.  Open a Pull Request.

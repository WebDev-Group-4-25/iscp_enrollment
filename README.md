# 🎓 Student Enrollment System – ISCP Edition

A simple web-based **Student Enrollment System** for a small college, built with PHP and MySQL. This system allows an admin to manage students and courses with fun, meme-themed content inspired by the **International State College of the Philippines (ISCP)**.

---

## 📦 Features

- Add, view, update, and delete **students**
- Add and manage **courses**
- **Enroll students** in courses
- Display enrolled students per course
- Preloaded with:
  - 🧑‍🎓 Top 12 Senators (PH May 2025 Elections)
  - 🏫 Meme-tastic ISCP-style courses (e.g., _BS in Sabong Analytics_)

---

## 🧰 Tech Stack

- **PHP** (Vanilla, procedural style)
- **MySQL** (MariaDB compatible)
- **Bootstrap 5** (optional, for responsive UI)
- Modular file structure using `include/require`

---

## 🚀 Getting Started

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/student-enrollment-iscp.git
cd student-enrollment-iscp
```

> Replace `your-username` with your actual GitHub username if you forked the repo.

---

### 2. Setup Environment

Make sure you have the following installed:

- [XAMPP](https://www.apachefriends.org/) / [MAMP](https://www.mamp.info/en/) / LAMP
- PHP 7.x or higher
- MySQL server

---

### 3. Configure Database Credentials

To set up your database connection:

1. **Copy the example configuration file**  
   Create a working `db.php` file by copying the provided example:

   ```bash
   cp includes/db.php.example includes/db.php
   ```

2. **Edit `includes/db.php`**  
   Open the copied file and update the configuration constants with your local database settings:

   ```php
   define('DB_HOST', 'localhost');        // Database host
   define('DB_NAME', 'your_database');    // Database name
   define('DB_USER', 'your_username');    // Database username
   define('DB_PASS', 'your_password');    // Database password
   ```

3. **Optional: If using `artisan.php`**  
   If you're running scripts from `artisan.php`, ensure the following lines reflect the same credentials:

   ```php
   $host = 'localhost';
   $user = 'root';
   $pass = '';
   ```

---

### 4. Create the Database Automatically

Run the setup script to:

- Create the `student_enrollment` database
- Create `students` and `courses` tables
- Insert sample meme-style courses
- Insert 12 sample senators and assign them to courses

#### Run via browser:

Start Apache + MySQL in your local server (XAMPP or MAMP), then visit:

```
http://localhost/folder-name/artisan.php
```

#### Or run via terminal:

```bash
php artisan.php
```

You should see confirmation messages like:

```
Database 'student_enrollment' created or already exists.
Table 'courses' created.
Table 'students' created.
Sample courses inserted.
Sample students inserted and randomly enrolled in courses.
```

---

## 🗂 File Structure

```
/student-enrollment-iscp
│
├── /includes/                     # Shared components and configurations
│   ├── db.php                     # Handles database connection setup
│   ├── header.php                 # Contains the shared HTML header section
│   ├── footer.php                 # Contains the shared HTML footer section
│   └── session.php                # Starts and manages user sessions
│
├── /pages/                        # Core application pages
│   ├── students.php               # Displays a list of all students
│   ├── add_student.php            # Form to add a new student
│   ├── courses.php                # Page to manage courses
│   ├── enroll.php                 # Interface for enrolling students into courses
│   ├── login.php                  # Admin login page
│   └── logout.php                 # Handles admin logout process
│
├── /assets/                       # Static assets such as CSS, JS, and images
│   ├── /css/                      # Stylesheets for the application
│   ├── /images/                   # Image files used in the application
│   └── /js/                       # JavaScript files for interactive features
│
├── /mockup/                       # HTML mockups for prototyping and design
│   └── iscp_mockup.html           # Initial mockup for ISCP Student Enrollment
│
├── artisan.php                    # Script for initial database setup and sample data insertion
├── index.php                      # (Optional) Redirects to the main students page or dashboard
└── README.md                      # Documentation and project overview
```

---

## 🧪 Sample Data

### 🧑‍🎓 Students (Senators 2025)

- Bong Go
- Bam Aquino
- Ronald dela Rosa
- Erwin Tulfo
- Francis “Kiko” Pangilinan
- Rodante Marcoleta
- Panfilo “Ping” Lacson
- Vicente Sotto III
- Pia Cayetano
- Camille Villar
- Lito Lapid
- Imee Marcos

### 📚 Courses

- BS in Traffic Management and Advanced Chismis
- BS in Professional Line Sitting
- BS in Barangay Diplomacy
- BS in Advanced Tambay Studies
- BS in Sabong Analytics
- BS in Jeepney Ergonomics
- BS in Street Food Quality Assurance
- BS in Teleserye Theory and Application

---

## 📌 Notes

- Inputs are **validated and sanitized** to prevent SQL injection and bad data.
- Uses **foreign key constraints** for relational integrity.
- Responsive design using Bootstrap (if enabled).

---

## 🧼 To Reset the Database

You can re-run `artisan.php` safely — it will clear `students` and `courses` tables before re-inserting sample data.

> ⚠️ Be careful if you already added real data; this will delete them!

---

## 👨‍💻 Author

Made by your dev team with love (and memes) 🇵🇭  
Inspired by the **ISCP** meme.

- Migueh, Rica Joi C.
- Osana, Lester
- Pablo, Jeremias G.
- Sanchez, Ma. Paula S.
- Xavier, Mikhail Gabriel

---

## 📝 License

Open-source. Free to remix and meme responsibly.

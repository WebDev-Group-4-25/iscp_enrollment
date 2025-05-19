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

Open `artisan.php` and update these lines if needed:

```php
$host = 'localhost';
$user = 'root';      // your MySQL username
$pass = '';          // your MySQL password
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
├── /includes/                     # Shared components
│   ├── db.php                     # Database connection
│   ├── header.php                 # Shared page header
│   └── footer.php                 # Shared page footer
│   └── session.php                # Manage session
│
├── /pages/                        # Core application pages
│   ├── students.php               # List all students
│   ├── add_student.php            # Add new student
│   ├── courses.php                # Manage courses
│   └── enroll.php                 # Enroll students in courses
│   └── login.php                  # Manage admin log-in
│   └── logout.php                 # Manage admin log-out
│
├── /assets/                       # CSS, JS, images (optional)
│   ├── /css/
│   └── /images/
│   └── /js/
├── artisan.php                   # Run-once database setup script
├── index.php                     # Optional: redirect to students.php or dashboard
└── README.md
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

<?php
require_once '../includes/db.php';
require '../includes/session.php';
require_login();
include_once '../includes/header.php';

// Initialize variables
$page_title = "Add Student | ISCP Enrollment System";
$active_page = "add_student";
$errors = [];
$success = '';
$name = '';
$email = '';
$course_id = '';

// Fetch courses for the select dropdown
$courses = $pdo->query("SELECT * FROM courses ORDER BY course_name ASC")->fetchAll();

// Handle form submission for adding student
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $course_id = $_POST['course_id'] ?? '';

    if (!$name) {
        $errors[] = "Full name is required.";
    }
    if (!$email) {
        $errors[] = "Email address is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address format.";
    }
    if (!$course_id) {
        $errors[] = "Please select a course.";
    }

    if (empty($errors)) {
        // Add new student
        $stmt = $pdo->prepare("INSERT INTO students (name, email, course_id) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $course_id]);
        $success = "Student added successfully.";

        // Reset variables after success
        $name = '';
        $email = '';
        $course_id = '';
    }
}
?>

<head>
    <meta charset="UTF-8" />
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) : 'Default Title'; ?></title>
    <script>
        function resetForm() {
            document.getElementById('addStudentForm').reset();
            var errorAlert = document.getElementById('errorAlert');
            if (errorAlert) {
                errorAlert.style.display = 'none';
            }
        }
    </script>
</head>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h2>Add Student</h2>
            <div>
                <h5 class="bg-primary text-white px-4 py-2 rounded-top mb-0 border border-bottom-0 border-1 border-secondary-subtle">Student Information</h5>
                <div class="bg-white p-4 rounded-bottom border border-top-0 border-1 border-secondary-subtle">
                <?php if ($errors): ?>
                    <div id="errorAlert" class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $err): ?>
                                <li><?= htmlspecialchars($err) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                    <?php endif; ?>

                    <form method="POST" novalidate id="addStudentForm">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="<?= htmlspecialchars($name) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?= htmlspecialchars($email) ?>" required>
                            <div class="form-text">We'll never share your email with anyone else.</div>
                        </div>
                        <div class="mb-3">
                            <label for="course_id" class="form-label">Course</label>
                            <select class="form-select" id="course_id" name="course_id" required>
                                <option value="" disabled <?= $course_id ? '' : 'selected' ?>>-- Select Course --</option>
                                <?php foreach ($courses as $c): ?>
                                    <option value="<?= $c['id'] ?>" <?= $course_id == $c['id'] ? "selected" : "" ?>>
                                        <?= htmlspecialchars($c['course_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="resetForm();">
                                Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Add Student
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once '../includes/footer.php'; ?>
<?php
require_once '../includes/db.php';
require '../includes/session.php';
require_login();

// Initialize variables
$page_title = "Courses | ISCP Enrollment System";
$active_page = "courses";
$errors = [];
$success = '';
$course_name = '';
$edit_id = null;

// Handle form submission for adding or updating course
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_name = trim($_POST['course_name'] ?? '');
    $edit_id = isset($_POST['edit_id']) ? (int) $_POST['edit_id'] : null;

    if (!$course_name) {
        $errors[] = "Course name is required.";
    }

    if (empty($errors)) {
        if ($edit_id) {
            // Update existing course
            $stmt = $pdo->prepare("UPDATE courses SET course_name = ? WHERE id = ?");
            $stmt->execute([$course_name, $edit_id]);
            $success = "Course updated successfully.";
        } else {
            // Add new course
            $stmt = $pdo->prepare("INSERT INTO courses (course_name) VALUES (?)");
            $stmt->execute([$course_name]);
            $success = "Course added successfully.";
        }
        // Reset variables after success
        $course_name = '';
        $edit_id = null;
    }
}

// Handle delete action
if (isset($_GET['delete'])) {
    $delete_id = (int) $_GET['delete'];
    // Optional: check if course has students enrolled before deleting
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM students WHERE course_id = ?");
    $stmt->execute([$delete_id]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        $errors[] = "Cannot delete course: there are students enrolled in this course.";
    } else {
        $stmt = $pdo->prepare("DELETE FROM courses WHERE id = ?");
        $stmt->execute([$delete_id]);
        $success = "Course deleted successfully.";
    }
}

// Handle "edit" action to pre-fill form
if (isset($_GET['edit'])) {
    $edit_id = (int) $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM courses WHERE id = ?");
    $stmt->execute([$edit_id]);
    $course = $stmt->fetch();
    if ($course) {
        $course_name = $course['course_name'];
    } else {
        $errors[] = "Course not found.";
        $edit_id = null;
    }
}

// Fetch all courses
$courses = $pdo->query("SELECT * FROM courses ORDER BY id ASC")->fetchAll();
?>

<?php include '../includes/header.php'; ?>

<head>
    <meta charset="UTF-8" />
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) : 'Default Title'; ?></title>
</head>
<div class="container py-4">
    <div class="row">
        <div class="col-md-6">
            <h2><?= $edit_id ? "Edit Course" : "Add Course" ?></h2>

            <?php if ($errors): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $err): ?>
                            <li><?= htmlspecialchars($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <form method="POST" novalidate>
                <input type="hidden" name="edit_id" value="<?= $edit_id ?? '' ?>">
                <div class="mb-3">
                    <label for="course_name" class="form-label">Course Name</label>
                    <input type="text" class="form-control" id="course_name" name="course_name"
                        value="<?= htmlspecialchars($course_name) ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">
                    <?= $edit_id ? "Update Course" : "Add Course" ?>
                </button>
                <?php if ($edit_id): ?>
                    <a href="courses.php" class="btn btn-secondary ms-2">Cancel</a>
                <?php endif; ?>
            </form>
        </div>

        <div class="col-md-6">
            <h2>Existing Courses</h2>
            <?php if (count($courses) === 0): ?>
                <p>No courses found.</p>
            <?php else: ?>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Course Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($courses as $c): ?>
                            <tr>
                                <td><?= $c['id'] ?></td>
                                <td><?= htmlspecialchars($c['course_name']) ?></td>
                                <td>
                                    <a href="?edit=<?= $c['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="?delete=<?= $c['id'] ?>" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this course?');">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
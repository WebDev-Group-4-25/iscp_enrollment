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
$confirm_delete_id = null;

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_type = $_POST['form_type'] ?? '';

    // Handle Add/Edit Course Form
    if ($form_type === 'add_edit') {
        $course_name = trim($_POST['course_name'] ?? '');
        $edit_id = isset($_POST['edit_id']) ? (int) $_POST['edit_id'] : null;

        if (!$course_name) {
            $errors[] = "Course name is required.";
        }

        if (empty($errors)) {
            if ($edit_id) {
                $stmt = $pdo->prepare("UPDATE courses SET course_name = ? WHERE id = ?");
                $stmt->execute([$course_name, $edit_id]);
                $success = "Course updated successfully.";
            } else {
                $stmt = $pdo->prepare("INSERT INTO courses (course_name) VALUES (?)");
                $stmt->execute([$course_name]);
                $success = "Course added successfully.";
            }
            $course_name = '';
            $edit_id = null;
        }
    }

    // Handle delete confirmation form
    if ($form_type === 'delete_confirm' && isset($_POST['confirm_delete_id'])) {
        $delete_id = (int) $_POST['confirm_delete_id'];

        // Check if course has students enrolled before deleting
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

// Handle "confirm delete" action
if (isset($_GET['confirm_delete'])) {
    $confirm_delete_id = (int) $_GET['confirm_delete'];
}

// Fetch all courses
$courses = $pdo->query("SELECT * FROM courses ORDER BY id ASC")->fetchAll();
?>

<?php include '../includes/header.php'; ?>

<head>
    <meta charset="UTF-8" />
    <title><?= htmlspecialchars($page_title) ?></title>
</head>

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
            <input type="hidden" name="form_type" value="add_edit">
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
                                <a href="?confirm_delete=<?= $c['id'] ?>" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php if ($confirm_delete_id): ?>
                <div class="alert alert-warning mt-3">
                    <p>Are you sure you want to delete this course?</p>
                    <form method="POST">
                        <input type="hidden" name="form_type" value="delete_confirm">
                        <input type="hidden" name="confirm_delete_id" value="<?= $confirm_delete_id ?>">
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                        <a href="courses.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
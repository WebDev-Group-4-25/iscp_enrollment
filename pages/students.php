<?php
require_once '../includes/session.php';
require_login();
require_once __DIR__ . '/../includes/db.php';

$page_title = "Students | ISCP Enrollment System";
$active_page = "students";

$filter_course_id = $_GET['course_id'] ?? '';

// Handle POST actions: delete or update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['student_id'])) {
        $student_id = $_POST['student_id'];
        $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
        $stmt->execute([$student_id]);
        $_SESSION['flash'] = "Student deleted successfully.";
        header("Location: students.php");
        exit;
    }

    if (isset($_POST['action']) && $_POST['action'] === 'update' && isset($_POST['student_id'])) {
        // Input Validation
        $student_id = $_POST['student_id'];
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $course_id = $_POST['course_id'] ?? null;

        if ($name === '' || $email === '' || !$course_id) {
            $_SESSION['flash'] = "Please fill all fields.";
            header("Location: students.php?edit=$student_id");
            exit;
        }

        $stmt = $pdo->prepare("UPDATE students SET name = ?, email = ?, course_id = ? WHERE id = ?");
        $stmt->execute([$name, $email, $course_id, $student_id]);
        $_SESSION['flash'] = "Student updated successfully.";
        header("Location: students.php");
        exit;
    }
}

// If editing a student, show edit form and exit
if (isset($_GET['edit'])) {
    $student_id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->execute([$student_id]);
    $student = $stmt->fetch();

    if (!$student) {
        echo "Student not found.";
        exit;
    }

    $courses = $pdo->query("SELECT * FROM courses")->fetchAll();

    include '../includes/header.php';
    ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Edit Student</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_SESSION['flash'])): ?>
                            <div class="alert alert-success">
                                <?= htmlspecialchars($_SESSION['flash']) ?>
                            </div>
                            <?php unset($_SESSION['flash']); ?>
                        <?php endif; ?>

                        <form method="POST" action="students.php">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="student_id" value="<?= htmlspecialchars($student['id']) ?>">

                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="name" id="name" required
                                       value="<?= htmlspecialchars($student['name']) ?>">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email" required
                                       value="<?= htmlspecialchars($student['email']) ?>">
                            </div>

                            <div class="mb-3">
                                <label for="course_id" class="form-label">Course</label>
                                <select name="course_id" id="course_id" class="form-select" required>
                                    <?php foreach ($courses as $course): ?>
                                        <option value="<?= $course['id'] ?>" <?= $course['id'] == $student['course_id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($course['course_name']) ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-success">Update Student</button>
                                <a href="students.php" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include '../includes/footer.php';
    exit;
}

// Fetch students list, filtered or not
if ($filter_course_id) {
    $stmt = $pdo->prepare("
        SELECT students.id, students.name, students.email, courses.course_name
        FROM students
        LEFT JOIN courses ON students.course_id = courses.id
        WHERE students.course_id = ?
    ");
    $stmt->execute([$filter_course_id]);
} else {
    $stmt = $pdo->query("
        SELECT students.id, students.name, students.email, courses.course_name
        FROM students
        LEFT JOIN courses ON students.course_id = courses.id
    ");
}
$students = $stmt->fetchAll();

include '../includes/header.php';

// Fetch all courses for the filter dropdown
$all_courses = $pdo->query("SELECT * FROM courses")->fetchAll();
?>

<div class="container my-4">
    <div class="bg-white rounded shadow-sm p-4 mb-4">
        <h2 class="mb-4">Students List</h2>

        <?php if (isset($_SESSION['flash'])): ?>
            <div class="alert alert-success mb-4 mx-auto" style="max-width: 600px;">
                <?= htmlspecialchars($_SESSION['flash']) ?>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <div class="row align-items-center mb-3">
            <div class="col-md-6">
                <form method="GET" class="d-flex align-items-center gap-3">
                    <label for="courseFilter" class="mb-0 flex-shrink-0">Filter by Course:</label>
                    <select name="course_id" id="courseFilter" class="form-select" onchange="this.form.submit()">
                        <option value="">-- All Courses --</option>
                        <?php foreach ($all_courses as $course): ?>
                            <option value="<?= $course['id'] ?>" <?= $filter_course_id == $course['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($course['course_name']) ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                    <a href="students.php" class="btn btn-outline-secondary">Reset</a>
                </form>
            </div>

            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <a href="add_student.php" class="btn btn-primary">+ Add Student</a>
            </div>
        </div>

        <table class="table table-hover table-bordered align-middle mb-0">
            <thead class="table-light text-uppercase small text-secondary">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Course</th>
                    <th scope="col" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $index => $student): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($student['name']) ?></td>
                        <td><?= htmlspecialchars($student['email']) ?></td>
                        <td><?= htmlspecialchars($student['course_name']) ?></td>
                        <td class="text-center">
                            <a href="students.php?edit=<?= $student['id'] ?>" class="btn btn-sm btn-primary">Edit</a>

                            <form action="students.php" method="POST" class="d-inline"
                                  onsubmit="return confirm('Are you sure?');">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="student_id" value="<?= $student['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

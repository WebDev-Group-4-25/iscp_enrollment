<?php
require_once '../includes/db.php';
require_once '../includes/session.php';
require_login();

$page_title = "Enroll | ISCP Enrollment System";
$active_page = "enroll";

// Fetch all students
function getStudents($pdo)
{
    return $pdo->query("SELECT id, name, course_id FROM students ORDER BY name ASC")->fetchAll();
}

// Fetch all courses
function getCourses($pdo)
{
    return $pdo->query("SELECT id, course_name FROM courses ORDER BY course_name ASC")->fetchAll();
}

// Fetch students enrolled in a specific course
function getEnrolledStudents($pdo, $course_id)
{
    $stmt = $pdo->prepare("SELECT id, name FROM students WHERE course_id = ?");
    $stmt->execute([$course_id]);
    return $stmt->fetchAll();
}

// Enroll a student in a course
function enrollStudent($pdo, $student_id, $course_id)
{
    // Check if already enrolled
    $stmt = $pdo->prepare("SELECT course_id FROM students WHERE id = ?");
    $stmt->execute([$student_id]);
    $existing_course = $stmt->fetchColumn();
    if ($existing_course == $course_id) {
        return "Student is already enrolled in this course.";
    }
    // Update enrollment
    $stmt = $pdo->prepare("UPDATE students SET course_id = ? WHERE id = ?");
    $stmt->execute([$course_id, $student_id]);
    return true;
}

// Remove a student from a course
function removeEnrollment($pdo, $student_id)
{
    $stmt = $pdo->prepare("UPDATE students SET course_id = NULL WHERE id = ?");
    $stmt->execute([$student_id]);
}

// --- Handle form submissions ---
$enroll_message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['enroll_student'])) {
        $student_id = (int) $_POST['student_id'];
        $course_id = (int) $_POST['course_id'];
        $result = enrollStudent($pdo, $student_id, $course_id);
        if ($result === true) {
            $enroll_message = '<div class="alert alert-success">Student enrolled successfully!</div>';
        } else {
            $enroll_message = '<div class="alert alert-warning">' . $result . '</div>';
        }
    } elseif (isset($_POST['remove_enrollment'])) {
        $student_id = (int) $_POST['remove_student_id'];
        removeEnrollment($pdo, $student_id);
    }
}

// --- Get data for dropdowns ---
$students = getStudents($pdo);
$courses = getCourses($pdo);

// --- View students in course ---
$view_course_id = isset($_POST['view_course_id']) ? (int)$_POST['view_course_id'] : ($courses[0]['id'] ?? null);
$enrolled_students = $view_course_id ? getEnrolledStudents($pdo, $view_course_id) : [];
$selected_course_name = '';
foreach ($courses as $c) {
    if ($c['id'] == $view_course_id) {
        $selected_course_name = $c['course_name'];
        break;
    }
}
?>

<?php include '../includes/header.php'; ?>

<div class="container py-4">
    <h2 class="mb-4">Student Enrollment</h2>
    <div class="row">
        <!-- Enroll Student in Course -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Enroll Student in Course</h5>
                </div>
                <div class="card-body">
                    <?php echo $enroll_message; ?>
                    <form method="post">
                        <div class="mb-3">
                            <label for="student_id" class="form-label">Select Student</label>
                            <select class="form-select" id="student_id" name="student_id" required>
                                <option value="" selected disabled>-- Select Student --</option>
                                <?php foreach ($students as $student): ?>
                                    <option value="<?= $student['id'] ?>"><?= htmlspecialchars($student['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="enroll_course_id" class="form-label">Select Course</label>
                            <select class="form-select" id="enroll_course_id" name="course_id" required>
                                <option value="" selected disabled>-- Select Course --</option>
                                <?php foreach ($courses as $course): ?>
                                    <option value="<?= $course['id'] ?>"><?= htmlspecialchars($course['course_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="d-grid">
                            <button type="submit" name="enroll_student" class="btn btn-primary">Enroll Student</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- View Students by Course -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">View Students by Course</h5>
                </div>
                <div class="card-body">
                    <form method="post" class="mb-3">
                        <label for="view_course_id" class="form-label">Select Course</label>
                        <select class="form-select" id="view_course_id" name="view_course_id" onchange="this.form.submit()">
                            <option value="" disabled <?= !$view_course_id ? 'selected' : '' ?>>-- Select Course --</option>
                            <?php foreach ($courses as $course): ?>
                                <option value="<?= $course['id'] ?>" <?= ($course['id'] == $view_course_id) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($course['course_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                    <?php if ($view_course_id): ?>
                        <div class="card mb-0">
                            <div class="card-header bg-light text-dark">
                                <h6 class="mb-0"><?= htmlspecialchars($selected_course_name) ?></h6>
                            </div>
                            <ul class="list-group list-group-flush">
                                <?php if (count($enrolled_students) === 0): ?>
                                    <li class="list-group-item text-muted">No students enrolled.</li>
                                <?php else: ?>
                                    <?php foreach ($enrolled_students as $student): ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><?= htmlspecialchars($student['name']) ?></span>
                                            <form method="post" class="mb-0">
                                                <input type="hidden" name="remove_student_id" value="<?= $student['id'] ?>">
                                                <input type="hidden" name="view_course_id" value="<?= $view_course_id ?>">
                                                <button type="submit" name="remove_enrollment" class="btn btn-sm btn-outline-danger">Remove</button>
                                            </form>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
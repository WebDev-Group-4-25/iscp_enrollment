<?php
/**
 * Login Page for Student Enrollment System
 *
 * Handles admin authentication and redirects to students.php on success.
 */

// Start session only — don't force login redirect on this page
require_once '../includes/session.php';

// Skip require_login() here to allow access to the login form

// Set page context for the header
$page_title = "Admin Login";
$active_page = "login";

// Fixed admin credentials (in production, store securely)
$admin_email = "admin@iscp.edu";
$admin_password = "admin123";

$error_message = "";

// Process login form
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === $admin_email && $password === $admin_password) {
        $_SESSION['user_id'] = 1;
        $_SESSION['username'] = "Administrator";
        $_SESSION['email'] = $email;
        $_SESSION['is_admin'] = true;

        $_SESSION['flash'] = "You have successfully logged in.";

        header("Location: students.php");
        exit;
    } else {
        $error_message = "Invalid email or password. Please try again.";
    }
}

include '../includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm border-0 mt-4">
            <div class="card-header bg-primary text-white text-center py-3">
                <h2 class="card-title h4 mb-0">
                    <i class="bi bi-lock-fill me-2"></i>Administrator Login
                </h2>
            </div>

            <div class="card-body p-4">
                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($error_message); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Enter your email" required
                                value="<?php echo htmlspecialchars($email ?? ''); ?>">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-key"></i></span>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Enter your password" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword"
                                data-bs-toggle="tooltip" title="Show/Hide Password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Login
                        </button>
                    </div>
                </form>
            </div>

            <div class="card-footer bg-light text-center py-3">
                <div class="small text-muted">ISCP Student Enrollment System</div>
                <div class="small text-muted mt-1">
                    <strong>Demo credentials:</strong> admin@iscp.edu / admin123
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const icon = this.querySelector('i');
        const isHidden = passwordInput.type === 'password';
        passwordInput.type = isHidden ? 'text' : 'password';
        icon.classList.toggle('bi-eye');
        icon.classList.toggle('bi-eye-slash');
    });
</script>

<?php include '../includes/footer.php'; ?>
<?php
/**
 * Footer template for Student Enrollment System
 * 
 * This file provides the common footer elements for all pages including copyright information,
 * navigation links, scripts, and closing HTML tags.
 */

// Get current academic year (e.g., 2024-2025)
$current_year = date('Y');
$next_year = $current_year + 1;
$academic_year = "$current_year-$next_year";
?>

</div><!-- End of container from header -->
</main>

<!-- Footer -->
<footer class="bg-primary text-white py-4 mt-auto">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-3 mb-md-0">
                <h5 class="mb-3">ISCP Student Enrollment System</h5>
                <p class="small mb-0">Providing efficient student management and course enrollment solutions for the
                    <?php echo htmlspecialchars($academic_year); ?>.
                </p>
            </div>
            <div class="col-md-3 mb-3 mb-md-0">
                <h6 class="mb-3">Quick Links</h6>
                <ul class="list-unstyled small">
                    <li><a href="students.php" class="text-white text-decoration-none"><i
                                class="bi bi-chevron-right"></i> Students</a></li>
                    <li><a href="courses.php" class="text-white text-decoration-none"><i
                                class="bi bi-chevron-right"></i> Courses</a></li>
                    <li><a href="enroll.php" class="text-white text-decoration-none"><i class="bi bi-chevron-right"></i>
                            Enrollment</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h6 class="mb-3">Contact Support</h6>
                <ul class="list-unstyled small">
                    <li><i class="bi bi-envelope me-2"></i>support@iscp.edu</li>
                    <li><i class="bi bi-telephone me-2"></i>(123) 456-7890</li>
                </ul>
            </div>
        </div>

        <hr class="my-3 bg-light opacity-25">

        <div class="row align-items-center">
            <div class="col-md-6 small text-center text-md-start">
                &copy; <?php echo $current_year; ?> ISCP Student Enrollment System. All rights reserved.
            </div>
            <div class="col-md-6 small text-center text-md-end">
                <a href="#" class="text-white me-3"><i class="bi bi-shield-lock"></i> Privacy Policy</a>
                <a href="#" class="text-white"><i class="bi bi-file-earmark-text"></i> Terms of Use</a>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap Bundle JS (with Popper) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<script>
    // Initialize Bootstrap tooltips
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
</body>

</html>
<?php
global $user;
?>

<div class="login bg-dark vh-100 d-flex justify-content-center align-items-center">
    <div class="col-md-4 bg-dark border rounded p-4 shadow-sm">
        <form method="post" action="./assets/php/actions.php?verify_email" class="row g-3">    
            <div class="text-center">
                <h1 class="h5 mb-3 text-white fw-normal">Verify Your Email (<?= htmlspecialchars($user['email']) ?>)</h1>
                <p class="text-white">Enter the 6-digit code sent to you</p>
            </div>
            <div class="form-floating mt-1">
                <input type="text" name="code" class="form-control rounded-0" id="floatingPassword" placeholder="Enter your verification code" required>
                <label for="floatingPassword">######</label>
            </div>

            <?php if (isset($_GET['resended'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Verification code has been resent!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?= showError('email_verify') ?>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <button class="btn btn-primary" type="submit">Verify Email</button>
                <a href="assets/php/actions.php?resend_code" class="text-decoration-none text-white">Resend Code</a>
            </div>

            <div class="text-center mt-4">
                <a href="assets/php/actions.php?logout" class="text-decoration-none text-white">
                    <i class="bi bi-arrow-left-circle-fill"></i> Logout
                </a>
            </div>
        </form>
    </div>
</div>

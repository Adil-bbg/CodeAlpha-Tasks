<?php
global $user;
?>

<div class="container col-9 rounded-0 d-flex justify-content-between">
    <div class="col-12 bg-dark border rounded p-4 mt-4 shadow-sm">
        <form class="row g-3" method="post" action="./assets/php/actions.php?updateprofile" enctype="multipart/form-data">

            <h1 class="h5 mb-3 text-white fw-normal">Edit Profile</h1>
            <?php
                if (isset($_SESSION['success'])) {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">'
                        . $_SESSION['success'] .
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
                        . '</div>'; 
                    unset($_SESSION['success']);
                }
                if (isset($_SESSION['error'])) {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'
                        . $_SESSION['error']['msg'] .
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
                        . '</div>'; 
                    unset($_SESSION['error']);
                }
            ?>
            <div class="form-floating mt-1 col-6">
                <img src="./assets/images/profile/<?= $user['profile_pic']?>" class="img-thumbnail my-3"
                    style="height:150px;" alt="Profile Picture">
                <div class="mb-3">
                    <label for="formFile" class="form-label">Change Profile Picture</label>
                    <input class="form-control" type="file" name="profile_pic" id="formFile">
                </div>
            </div>
            <?=showError('profile_pic') ?>
        
            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" value="<?= htmlspecialchars($user['first_name'])?>" name="first_name" class="form-control"
                            id="floatingInputFirstName" placeholder="First Name">
                        <label for="floatingInputFirstName">First Name</label>
                    </div>
                    <?=showError('first_name') ?>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name'])?>" class="form-control"
                            id="floatingInputLastName" placeholder="Last Name">
                        <label for="floatingInputLastName">Last Name</label>
                    </div>
                    <?=showError('last_name') ?>
                </div>
                <div class="col-12 d-flex justify-content-start">
                    <!-- Gender radio buttons -->
                    <!-- These should be enabled for editing if needed -->
                    <div class="form-check mx-3">
                        <input class="form-check-input" type="radio" name="gender" id="flexRadioDefault1" value="1"
                            <?= $user['gender'] == 1 ? 'checked' : '' ?>>
                        <label class="form-check-label text-white" for="flexRadioDefault1">Male</label>
                    </div>
                    <div class="form-check mx-3">
                        <input class="form-check-input" type="radio" name="gender" id="flexRadioDefault2" value="2"
                            <?= $user['gender'] == 2 ? 'checked' : '' ?>>
                        <label class="form-check-label text-white" for="flexRadioDefault2">Female</label>
                    </div>
                    <div class="form-check mx-3">
                        <input class="form-check-input" type="radio" name="gender" id="flexRadioDefault3" value="0"
                            <?= $user['gender'] == 0 ? 'checked' : '' ?>>
                        <label class="form-check-label text-white" for="flexRadioDefault3">Other</label>
                    </div>
                </div>
                <div class="col-12">
                        <div class="form-floating my-3">
                            <input type="text" class="form-control" value="<?= htmlspecialchars($user['username'])?>" name="username"
                                id="floatingInputUsername" placeholder="Username">
                            <label for="floatingInputUsername">Username</label>
                        </div>
                    <?=showError('username') ?>
                </div>
                <div class="col-12">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" value="<?= htmlspecialchars($user['email'])?>" id="floatingInputEmail" name="email" placeholder="name@example.com">
                        <label for="floatingInputEmail">Email address</label>
                    </div>
                </div>
                <?=showError('email') ?>
                <div class="col-12">
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="floatingInputPassword" name="password"
                            placeholder="Must be 8 characters">
                        <label for="floatingInputPassword">Password</label>
                    </div>
                    <?=showError('password') ?>
                </div>
            </div>
            <div class="mt-3 d-flex justify-content-between align-items-center">
                <button class="btn btn-primary" type="submit">Update Profile</button>
            </div>
        </form>
    </div>
</div>

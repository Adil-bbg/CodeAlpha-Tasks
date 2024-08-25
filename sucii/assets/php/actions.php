<?php
require_once 'function.php';
require_once 'send_code.php';

// for mannging signup form
if(isset($_GET['signup'])){
    $response = ValidateSignupForm($_POST);
    if ($response['status']) {
        if(createUserAccount($_POST)){
            header('location:../../?login');
        }
        else{
            echo '<script>alert("something is wrong");</script>';
        }
    }
    else{
        $_SESSION['error'] = $response;
        $_SESSION['formdata'] = $_POST;
        header('location:../../?signup');
    }
}

// for mannging login form
if(isset($_GET['login'])){
    $response = ValidateLoginForm($_POST);
    if ($response['status']) {
        $_SESSION['Auth'] = true; // if user already signin
        $_SESSION['userdata'] = $response['user']; // it will check user data from signup/login page 
        if($response['user']['acc_status']==0){
            $_SESSION['code'] = $code = rand(111111,999999);
            sendCode($response['user']['email'],'Varify Your Email',$code);
        }
        header('location:../../');
    }
    else{
        $_SESSION['error'] = $response;
        $_SESSION['formdata'] = $_POST;
        header('location:../../?login');
    }
}

// for otp code  resend

if(isset($_GET['resend_code'])){
    $_SESSION['code'] = $code =rand(111111,999999);
    sendCode($_SESSION['userdata']['email'],'Varify Your email',$code);
    header('location:../../?resended');
}

// for email varification

if(isset($_GET['verify_email'])){
    $user_code  = $_POST['code'];
    $code = $_SESSION['code'];
    if($code==$user_code){
        if(VarifyEmail($_SESSION['userdata']['email'])){
            header('location:../../');
        }
        else {
            echo "something is wrong";
        }
    }
    else{
        $response['msg'] = 'incorrect varification code!';
        if(!$_POST['code']){
            $response['msg'] = 'Enter 6 digit code';
        }
        $response['field'] = 'email_verify';
        $_SESSION['error']= $response;
        header('location:../../');
    }
}

// for logout

if(isset($_GET['logout'])){
    // session_unset();
    session_destroy();
    header('location:../../');
}

// Forgot Password Action
if (isset($_GET['forgotPassword'])) {
    if (empty($_POST['email'])) {
        $response['msg'] = "Enter your valid email address"; 
        $response['field'] = 'email';
        $_SESSION['error'] = $response;
        header('Location: ../../?forgotPassword');
        exit();
    } elseif (!checkDuplicateEmail($_POST['email'])) {
        $response['msg'] = "Email is not registered"; 
        $response['field'] = 'email';
        $_SESSION['error'] = $response;
        header('Location: ../../?forgotPassword');
        exit();
    } else {
        // Store the email in the session
        $_SESSION['forgot_email'] = $_POST['email'];
        
        // Generate and send the verification code
        $_SESSION['forgot_code'] = $code = rand(111111, 999999);
        sendCode($_POST['email'], 'Forgot Your Password? Use This Code', $code);
        
        // Redirect to the verification page
        header('Location: ../../?verifycode');
        exit() ;
    }
}

// Email Verification Action
if (isset($_GET['verifycode'])) {
    if (empty($_POST['code'])) {
        $response['msg'] = 'Enter 6 digit code';
        $response['field'] = 'email_verify';
        $_SESSION['error'] = $response;
        header('Location: ../../?verifycode');
        exit();
    }

    $user_code = $_POST['code'];
    $code = $_SESSION['forgot_code'] ?? null;

    if ($code && $code == $user_code) {
        $_SESSION['auth_temp'] = true; // Temporary authentication
        header('Location: ../../?changepassword');
        exit();
    } else {
        $_SESSION['forgot_email'] = $_SESSION['forgot_email'] ?? $_POST['email'];
        $response['msg'] = 'Incorrect verification code!';
        $response['field'] = 'email_verify';
        $_SESSION['error'] = $response;
        header('Location: ../../?verifycode');
        exit();
    }
}

// Password Change Action
if (isset($_GET['changepassword'])) {
    // Check if the password is provided
    if (empty($_POST['password'])) {
        $response['msg'] = "Enter your new password"; 
        $response['field'] = 'password';
        $_SESSION['error'] = $response;
        header('Location: ../../?forgotpassword');
        exit();
    } else {
        // Check if forgot_email is set in session
        if (isset($_SESSION['forgot_email'])) {
            // Debugging: Check if email and password are set correctly
            echo "Email: " . $_SESSION['forgot_email'] . "<br>";
            echo "Password: " . $_POST['password'] . "<br>";

            // Attempt to change the password using the email stored in session
            if (change_resetPasword($_SESSION['forgot_email'], $_POST['password'])) {
                // Debugging: Success message
                echo "Password updated successfully.<br>";
                header('Location: ../../?reseted');
                exit();
            } else {
                // Debugging: Failure message
                echo "Failed to update password.<br>";
                // Optionally, you can log the error or handle it as needed
            }
        } else {
            // Handle the case where forgot_email is not set
            $response['msg'] = "Session expired or invalid request.";
            $_SESSION['error'] = $response;
            header('Location: ../../?forgotpassword');
            exit();
        }
    }
}

// For updating profile form
if (isset($_GET['updateprofile'])) {
    // Validate the form data
    $response = ValidateUpdateProfileForm($_POST, $_FILES['profile_pic']);
    if ($response['status']) {
        // Attempt to update the profile
        if (updateProfile($_POST, $_FILES['profile_pic'])) {
            // Profile updated successfully
            $_SESSION['success'] = "Profile updated successfully!";
            header('Location: ../../?editprofile');
            exit();
        } else {
            // Handle the case where the profile update failed
            echo '<script>alert("Something went wrong. Please try again.");</script>';
        }
    } else {
        // Validation failed, store errors in session and redirect
        $_SESSION['error'] = $response;
        header('Location: ../../?editprofile');
        exit();
    }
}

if(isset($_GET{'addpost'})) {
    // Validate the form data
    $response = validatePostForm($_FILES['Sucii_select_post']);
    if ($response['status']) {
        // Attempt to add a post
        if (addPost($_POST,$_FILES['Sucii_select_post'])) {
            // Post added successfully
            // $_SESSION['success'] = "Post added successfully!";
            header('Location:../../?new post is added');
            exit();
        } else {
            // Handle the case where the post addition failed
            echo '<script>alert("Something went wrong. Please try again.");</script>';
        }
    } else {
        // Validation failed, store errors in session and redirect
        $_SESSION['error'] = $response;
        header('Location:../../');
        exit();
    }
}

if (isset($_GET['addcomment'])) {
    // Get form data
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['userdata']['id']; // Assuming the user is logged in and their ID is stored in the session
    $comment_text = $_POST['comment_text'];

    // Validate the comment text (basic validation)
    if (!empty($comment_text)) {
        // Add the comment
        if (addComment($post_id, $user_id, $comment_text)) {
            // Redirect to the wall page with a success message
            header('Location:../../?comment=success');
            exit();
        } else {
            // Handle the case where the comment addition failed
            echo '<script>alert("Something went wrong. Please try again.");</script>';
        }
    } else {
        // Handle the case where comment text is empty
        echo '<script>alert("Comment cannot be empty.");</script>';
    }
}

?>
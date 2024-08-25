<?php
require_once 'config.php';
$db = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME) or die("connection feild");

//function for including/onnecting/linking files
function showpage($page,$data=""){
    include("./assets/pages/$page.php");
}

// function for checking duplicate emails are rgistor

function checkDuplicateEmail($email){
    global $db;
    $query = "SELECT COUNT(*) AS ROW FROM users WHERE email='$email'";
    $run = mysqli_query($db, $query);
    $return_data = mysqli_fetch_assoc($run);
    return $return_data['ROW'];
}

// function for checking duplicate username are rgistor

function checkDuplicateUsername($username){
    global $db;
    $query = "SELECT COUNT(*) AS ROW FROM users WHERE username='$username'";
    $run = mysqli_query($db, $query);
    $return_data = mysqli_fetch_assoc($run);
    return $return_data['ROW'];
}

// function for previous form data 

function getPreviousFormData($field){
    if (isset($_SESSION['formdata'])) {
        $formdata = $_SESSION['formdata'];
        return $formdata[$field];
    }
}

// function for showing errors in form

function showError($field){
    if (isset($_SESSION['error'])) {
        $error = $_SESSION['error'];
        if (isset($error['field']) && $field == $error['field']) {
            echo '<div class="alert alert-danger" role="alert">'.$error['msg'].'</div>';            
        }
    }
}

// function  for signup form validation 
function ValidateSignupForm($form_data){
    $response = array();
    $response['status'] = true;

    if (empty($form_data['password'])) {
        $response['msg'] = "Password is not given"; 
        $response['status'] = false;
        $response['field'] = 'password';
    }
    if (empty($form_data['email'])) {
        $response['msg'] = "Email is not given"; 
        $response['status'] = false;
        $response['field'] = 'email';
    }
    if (empty($form_data['username'])) {
        $response['msg'] = "Username is not given"; 
        $response['status'] = false;
        $response['field'] = 'username';
    }
    if (empty($form_data['last_name'])) {
        $response['msg'] = "Last name is not given"; 
        $response['status'] = false;
        $response['field'] = 'last_name';
    }
    if (empty($form_data['first_name'])) {
        $response['msg'] = "First name is not given"; 
        $response['status'] = false;
        $response['field'] = 'first_name';
    }
    if ($response['status'] && checkDuplicateEmail($form_data['email'])) {
        $response['msg'] = "Email is already registered"; 
        $response['status'] = false;
        $response['field'] = 'email';
    }
    if ($response['status'] && checkDuplicateUsername($form_data['username'])) {
        $response['msg'] = "Username is already registered"; 
        $response['status'] = false;
        $response['field'] = 'username';
    }

    return $response;
}

// function  for login form validation 

function ValidateLoginForm($form_data){
    $response = array();
    $response['status']=true;
    $blank = false;
    if (!$form_data['password']) {
        $response['msg'] = "password is not given"; 
        $response['status'] = false;
        $response['field'] = 'password';
        $blank = true;
    }
    if (!$form_data['username_email']) {
        $response['msg'] = "username/email is not given"; 
        $response['status'] = false;
        $response['field'] = 'username_email';
        $blank = true;
    }    
    if (!$blank && !checkUserLoginData($form_data)['status']) {
        $response['msg'] = "Something is wrong, or the user is not registered"; 
        $response['status'] = false;
        $response['field'] = 'checkUserLoginData';
    }else{
        $response['user'] = checkUserLoginData($form_data)['user'];
    }
    return $response;
}
  

// function for checking user login data 
// chatgpt
function checkUserLoginData($login_data) {
    global $db;
    $username_email = mysqli_real_escape_string($db, $login_data['username_email']);
    $password = $login_data['password'];

    $query = "SELECT * FROM users WHERE username='$username_email' OR email='$username_email'";
    $run = mysqli_query($db, $query);
    
    if (!$run) {
        die("Query failed: " . mysqli_error($db));
    }

    $user = mysqli_fetch_assoc($run);

    // Check if user exists and verify the password
    if ($user && password_verify($password, $user['password'])) {
        $data['status'] = true;
        $data['user'] = $user;
    } else {
        $data['status'] = false;
    }
    return $data;
}

// function for geting user data by id 
function getUserData($user_id) {
    global $db;
    $query = "SELECT * FROM users WHERE id='$user_id'";
    $run = mysqli_query($db, $query);
    if (!$run) {
        die("Query failed: " . mysqli_error($db));
    }
    return mysqli_fetch_assoc($run);
}


// function for sign up or creat user acc
// chatgpt

function createUserAccount($data) {
    global $db;
    $first_name = mysqli_real_escape_string($db, $data['first_name']);
    $last_name = mysqli_real_escape_string($db, $data['last_name']);
    $gender = mysqli_real_escape_string($db, $data['gender']);
    $username = mysqli_real_escape_string($db, $data['username']);
    $email = mysqli_real_escape_string($db, $data['email']);
    $password = password_hash($data['password'], PASSWORD_BCRYPT);
    $query = "INSERT INTO users (first_name, last_name, gender, username, email, password)";
    $query .= " VALUES ('$first_name', '$last_name', '$gender', '$username', '$email', '$password')";
    return mysqli_query($db, $query);
}

// function for email varification so account status update to active
function VarifyEmail($email){
    global $db;
    $query = "UPDATE users SET acc_status=1 WHERE email='$email';";
    return mysqli_query($db,$query);
}

// function for reset/change password
function change_resetPasword($email, $password) {
    global $db;
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $query = "UPDATE users SET password='$hashedPassword' WHERE email='$email';";
    return mysqli_query($db, $query);
}
// Function for checking duplicate username by others
function checkDuplicateUsernameByOthers($username) {
    global $db;
    $user_id = $_SESSION['userdata']['id'];
    $username = mysqli_real_escape_string($db, $username);
    $query = "SELECT COUNT(*) AS ROW FROM users WHERE username='$username' AND id != $user_id";
    $run = mysqli_query($db, $query);
    $return_data = mysqli_fetch_assoc($run);
    return $return_data['ROW'];
}

// Function for checking duplicate email by others
function checkDuplicateEmailByOthers($email) {
    global $db;
    $user_id = $_SESSION['userdata']['id'];
    $email = mysqli_real_escape_string($db, $email);
    $query = "SELECT COUNT(*) AS ROW FROM users WHERE email='$email' AND id != $user_id";
    $run = mysqli_query($db, $query);
    $return_data = mysqli_fetch_assoc($run);
    return $return_data['ROW'];
}

// Function for update profile form validation
function ValidateUpdateProfileForm($form_data, $image_data) {
    $response = array();
    $response['status'] = true;

    if (empty($form_data['email'])) {
        $response['msg'] = "Email is not given"; 
        $response['status'] = false;
        $response['field'] = 'email';
    }

    if (empty($form_data['username'])) {
        $response['msg'] = "Username is not given"; 
        $response['status'] = false;
        $response['field'] = 'username';
    }

    if (empty($form_data['last_name'])) {
        $response['msg'] = "Last name is not given"; 
        $response['status'] = false;
        $response['field'] = 'last_name';
    }

    if (empty($form_data['first_name'])) {
        $response['msg'] = "First name is not given"; 
        $response['status'] = false;
        $response['field'] = 'first_name';
    }

    // Check if the username is already taken by another user
    if ($response['status'] && checkDuplicateUsernameByOthers($form_data['username'])) {
        $response['msg'] = "Username is already registered"; 
        $response['status'] = false;
        $response['field'] = 'username';
    }

    // Check if the email is already taken by another user (excluding current user)
    if ($response['status'] && checkDuplicateEmailByOthers($form_data['email'])) {
        $response['msg'] = "Email is already registered"; 
        $response['status'] = false;
        $response['field'] = 'email';
    }

    if ($image_data['name']) {
        $image = basename($image_data['name']);
        $type = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $size = $image_data['size'] / 1000;

        if ($type != 'jpg' && $type != 'jpeg' && $type != 'png') {
            $response['msg'] = "File type is not supported! Use (png, jpg, or jpeg)"; 
            $response['status'] = false;
            $response['field'] = 'profile_pic';
        }

        if ($size > 1000) {
            $response['msg'] = "File size is too large! Max size is 1 MB"; 
            $response['status'] = false;
            $response['field'] = 'profile_pic';
        }
    }

    return $response;
}

// Function for updating the user profile
function updateProfile($data, $image_data) {
    global $db;
    
    $first_name = mysqli_real_escape_string($db, $data['first_name']);
    $last_name = mysqli_real_escape_string($db, $data['last_name']);
    $username = mysqli_real_escape_string($db, $data['username']);
    $password = mysqli_real_escape_string($db, $data['password']);

    // Handle password update
    if (empty($data['password'])) {
        $password = $_SESSION['userdata']['password'];
    } else {
        $password = password_hash($data['password'], PASSWORD_BCRYPT);
    }

    $profile_pic = "";
    if (!empty($image_data['name'])) {
        $image_name = time() . basename($image_data['name']);
        $image_directory = "../images/profile/$image_name";
        if (move_uploaded_file($image_data['tmp_name'], $image_directory)) {
            $profile_pic = ", profile_pic='$image_name'";
        }
    }

    // Update query
    $query = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', username = '$username', password = '$password' $profile_pic WHERE id=" . $_SESSION['userdata']['id'];

    return mysqli_query($db, $query);
}

 // to validate add/upload post
function validatePostForm($image_data){
    $response = array();
    $response['status'] = true;

    if (empty($image_data['name'])) {
        $response['msg'] = "image is not selected"; 
        $response['status'] = false;
        $response['field'] = 'post_image';
    }

    if ($image_data['name']) {
        $image = basename($image_data['name']);
        $type = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $size = $image_data['size'] / 1000;

        if ($type != 'jpg' && $type != 'jpeg' && $type != 'png') {
            $response['msg'] = "File type is not supported! Use (png, jpg, or jpeg)"; 
            $response['status'] = false;
            $response['field'] = 'post_image';
        }

        if ($size > 2500) {
            $response['msg'] = "File size is too large! Max size is 2.5 MB"; 
            $response['status'] = false;
            $response['field'] = 'post_image';
        }
    }

    return $response;

}

 // to add/upload post
 function addPost($text, $image) {
    global $db;
    $user_id = $_SESSION['userdata']['id'];
    
    // Generate a unique image name based on current timestamp
    $image_name = time() . basename($image['name']);
    
    // Set the directory where the image will be saved
    $image_directory = "../images/posts/$image_name";
    
    // Move the uploaded image to the desired directory
    if (move_uploaded_file($image['tmp_name'], $image_directory)) {
        $post_des = mysqli_real_escape_string($db, $text['post_des']);
        
        // Insert the post data into the database
        $query = "INSERT INTO posts (user_id, post_image, post_des, posted_at)";
        $query .= " VALUES ('$user_id', '$image_name', '$post_des', NOW())";
        
        return mysqli_query($db, $query);
    } else {
        // Handle the case where the image could not be uploaded
        return false;
    }
}

// to fetch posts on wall

function fetchPosts(){
    global $db;
    $query = "SELECT posts.id,posts.user_id,posts.post_image,posts.post_des,posts.posted_at,users.first_name,users.last_name,users.username,users.profile_pic FROM posts JOIN users ON users.id = posts.user_id ORDER BY id DESC";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_all($run,true);
}


// function for geting user data by $username 
function getUserDataByUsername($username) {
    global $db;
    $query = "SELECT * FROM users WHERE username='$username'";
    $run = mysqli_query($db, $query);
    if (!$run) {
        die("Query failed: " . mysqli_error($db));
    }
    return mysqli_fetch_assoc($run);
}


// to fetch postson user profile

function fetchPostsById($user_id){
    global $db;
    $query = "SELECT * FROM posts WHERE user_id=$user_id ORDER BY id DESC";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_all($run,true);
}

// For getting users to follow suggestions
function getFollowSuggestions() {
    global $db;
    $current_loggedin_user = $_SESSION['userdata']['id'];
    $query = "SELECT * FROM users WHERE id != $current_loggedin_user ORDER BY id DESC";
    $run = mysqli_query($db, $query);
    if ($run) {
        return mysqli_fetch_all($run, MYSQLI_ASSOC);
    } else {
        die("Database error: " . mysqli_error($db));
    }
}

// To check if the current user is following another user
function checkFollowStatus($user_id) {
    global $db;
    $current_loggedin_user = $_SESSION['userdata']['id'];
    $query = "SELECT COUNT(*) AS row_count FROM follow_list WHERE user_id = $current_loggedin_user AND follow_id = $user_id";
    $run = mysqli_query($db, $query);

    if (!$run) {
        die("Database error: " . mysqli_error($db)); // Add this line for debugging
    }

    return mysqli_fetch_assoc($run)['row_count'];
}

// To filter follow list for suggestions after applying the follow status check
function filterFollowSuggestions() {
    $suggestions = getFollowSuggestions();
    $filtered_list = array();
    foreach ($suggestions as $user) {
        if (checkFollowStatus($user['id']) == 0) { // Not followed yet
            $filtered_list[] = $user;
        }
    }
    return $filtered_list;
}

function followUser($user_id){
    global $db;
    $current_user = $_SESSION['userdata']['id'];
    $query = "INSERT INTO follow_list(user_id, follow_id) VALUES($current_user, $user_id)";
    $run = mysqli_query($db, $query);

    if (!$run) {
        die("Database error: " . mysqli_error($db)); // Add this line for debugging
    }
    
    return $run;
}

function unfollowUser($user_id){
    global $db;
    $current_user = $_SESSION['userdata']['id'];
    $query = "DELETE FROM follow_list WHERE user_id = $current_user AND follow_id = $user_id";
    $run = mysqli_query($db, $query);

    if (!$run) {
        die("Database error: " . mysqli_error($db)); // Add this line for debugging
    }
    
    return $run;
}


// To filter the post according to the accounts followed by user

function filterPostAccToFeed() {
    $post_list = fetchPosts();
    $filtered_list = array();
    foreach ($post_list as $post) {
        if (checkFollowStatus($post['user_id']) || $post['user_id']==$_SESSION['userdata']['id']) { // Not followed yet
            $filtered_list[] = $post;
        }
    }
    return $filtered_list;
}

// count followers and following on profile if a person follow me my id = is follow_id and if i follow someboy his id = user_id
function countFollowers($user_id){
    global $db;
    $query = "SELECT COUNT(*) as count FROM follow_list WHERE follow_id = $user_id";
    $result = mysqli_query($db, $query);
    $data = mysqli_fetch_assoc($result);
    return $data['count'];
}

function countFollowing($user_id){
    global $db;
    $query = "SELECT COUNT(*) as count FROM follow_list WHERE user_id = $user_id";
    $result = mysqli_query($db, $query);
    $data = mysqli_fetch_assoc($result);
    return $data['count'];
}
function getFollowers($user_id) {
    global $db;
    $query = "SELECT user_id FROM follow_list WHERE follow_id = $user_id";
    $result = mysqli_query($db, $query);
    $followers = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $followers[] = getUserData($row['user_id']);
    }
    return $followers;
}


// for getting  following Accounts
    // This function works similarly to your `getFollowers` function. It retrieves the `follow_id` for all users that the specified user is following, fetches their details using `getUserData`, and returns the list.
function getFollowing($user_id) {
    global $db;
    $query = "SELECT follow_id FROM follow_list WHERE user_id = $user_id";
    $result = mysqli_query($db, $query);
    $following = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $following[] = getUserData($row['follow_id']);
    }
    return $following;
}


function likePost($post_id){
    global $db;
    $current_user = $_SESSION['userdata']['id'];
    $query = "INSERT INTO likes(post_id,user_id) VALUES($post_id, $current_user)";
    $run = mysqli_query($db, $query);

    if (!$run) {
        die("Database error: " . mysqli_error($db)); // Add this line for debugging
    }
    
    return $run;
}



function unlikePost($post_id){
    global $db;
    $current_user = $_SESSION['userdata']['id'];
    $query = "DELETE FROM likes WHERE post_id=$post_id  && user_id= $current_user";
    $run = mysqli_query($db, $query);

    if (!$run) {
        die("Database error: " . mysqli_error($db)); // Add this line for debugging
    }
    
    return $run;
}


// To check if the current user is following another user
function checkLikeStatus($post_id) {
    global $db;
    $current_loggedin_user = $_SESSION['userdata']['id'];
    $query = "SELECT COUNT(*) AS row_count FROM likes WHERE user_id = $current_loggedin_user &&  post_id = $post_id";
    $run = mysqli_query($db, $query);

    if (!$run) {
        die("Database error: " . mysqli_error($db)); // Add this line for debugging
    }

    return mysqli_fetch_assoc($run)['row_count'];
}

// to count likes on post

    // return mysqli_fetch_all($run,true); we 88have to always give true fo associative value
    function countLikes($post_id){
        global $db;
        $query = "SELECT users.id, users.username, users.first_name, users.last_name, users.profile_pic 
                  FROM likes 
                  JOIN users ON likes.user_id = users.id 
                  WHERE post_id = $post_id";
        $run = mysqli_query($db, $query);
    
        if (!$run) {
            die("Database error: " . mysqli_error($db));
        }
    
        return mysqli_fetch_all($run, MYSQLI_ASSOC);
    }
    function addComment($post_id, $user_id, $comment_text, $parent_id = null) {
        global $db;
        $comment_text = mysqli_real_escape_string($db, $comment_text);
        $parent_id = $parent_id ? $parent_id : 'NULL'; // Handle null parent_id for top-level comments
        $query = "INSERT INTO comments (post_id, user_id, comment_text, parent_id) 
                  VALUES ($post_id, $user_id, '$comment_text', $parent_id)";
        $run = mysqli_query($db, $query);
    
        if (!$run) {
            die("Database error: " . mysqli_error($db));
        }
    
        return $run;
    }

    function deleteComment($comment_id, $user_id) {
        global $db;
        $query = "DELETE FROM comments WHERE id = $comment_id AND user_id = $user_id";
        $run = mysqli_query($db, $query);
    
        if (!$run) {
            die("Database error: " . mysqli_error($db));
        }
    
        return $run;
    }
    function getComments($post_id) {
        global $db;
        $query = "SELECT comments.*, users.username, users.first_name, users.last_name, users.profile_pic 
                  FROM comments 
                  JOIN users ON comments.user_id = users.id 
                  WHERE post_id = $post_id AND parent_id IS NULL 
                  ORDER BY created_at DESC";
        $run = mysqli_query($db, $query);
    
        if (!$run) {
            die("Database error: " . mysqli_error($db));
        }
    
        return mysqli_fetch_all($run, MYSQLI_ASSOC);
    }
    function getCommentReplies($comment_id) {
        global $db;
        $query = "SELECT comments.*, users.username, users.first_name, users.last_name, users.profile_pic 
                  FROM comments 
                  JOIN users ON comments.user_id = users.id 
                  WHERE parent_id = $comment_id 
                  ORDER BY created_at ASC";
        $run = mysqli_query($db, $query);
    
        if (!$run) {
            die("Database error: " . mysqli_error($db));
        }
    
        return mysqli_fetch_all($run, MYSQLI_ASSOC);
    }

    
    
?>
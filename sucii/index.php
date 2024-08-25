<?php
include('assets/php/function.php');
if(isset($_GET['newfp'])){
    unset($_SESSION['auth_temp']);
    unset($_SESSION['forgot_email']);
    unset($_SESSION['forgot_code']);
}
if(isset($_SESSION['Auth'])){
    $user = getUserData($_SESSION['userdata']['id']);
    $posts = filterPostAccToFeed();
    $follow_suggestion = filterFollowSuggestions();
}

// for manging pages

$pageCount = count($_GET);

if (isset($_SESSION['Auth']) && $user['acc_status']==1 && !$pageCount) {
    showpage('header',['page_title'=>"Sucii - Home"]);
    showpage('navbar');
    showpage('wall');
}
elseif (isset($_SESSION['Auth']) && $user['acc_status']==0  && !$pageCount) {
    showpage('header',['page_title'=>"Sucii -  Verify your email"]);
    showpage('verify_email');
}
elseif (isset($_SESSION['Auth']) && $user['acc_status']==2  && !$pageCount) {
    showpage('header',['page_title'=>"Sucii - Your account is blocked"]);
    showpage('blocked');
}

elseif (isset($_SESSION['Auth']) && isset($_GET['editprofile']) && $user['acc_status']==1) {
    showpage('header',['page_title'=>"Sucii - Edit Profile"]);
    showpage('navbar');
    showpage('edit_profile');
}

elseif (isset($_SESSION['Auth']) && isset($_GET['user']) && $user['acc_status']==1) {
    $profile = getUserDataByUsername($_GET['user']); 
    if(!$profile){
        showpage('header',['page_title'=>"Sucii - user_not_found"]);
        showpage('navbar');
        showpage('user_not_found');
    }
    else{
        $postOnProfile = fetchPostsById($profile['id']);
        $profile['followers'] = countFollowers($profile['id']);
        $profile['following'] = countFollowing($profile['id']);
        $profile['followers'] = getFollowers($profile['id']);
        $profile['following'] = getFollowing($profile['id']);
        showpage('header',['page_title'=> $profile['first_name'].' '.$profile['last_name'] ]);
        showpage('navbar');
        showpage('profile');    
    }
}
elseif(isset($_GET['signup'])){
    showpage('header',['page_title'=>"Sucii - Sign Up"]);
    showpage('signup');
}
elseif(isset($_GET['login'])){
    showpage('header',['page_title'=>"Sucii - Login"]);
    showpage('login');
}
elseif(isset($_GET['forgotPassword'])){
    showpage('header',['page_title'=>"Sucii - Forgot Password"]);
    showpage('forgot_password');
}
else{
    if (isset($_SESSION['Auth']) && $user['acc_status']==1) {
        showpage('header',['page_title'=>"Sucii - Home"]);
        showpage('navbar');
        showpage('wall');
    }
    elseif (isset($_SESSION['Auth']) && $user['acc_status']==0) {
        showpage('header',['page_title'=>"Sucii -  Verify your email"]);
        showpage('verify_email');
    }
    elseif (isset($_SESSION['Auth']) && $user['acc_status']==2) {
        showpage('header',['page_title'=>"Sucii - Your account is blocked"]);
        showpage('blocked');
    }
    else{
    showpage('header',['page_title'=>"Sucii - Login"]);
    showpage('login');
}
}

showpage('footer');

unset($_SESSION['error']);
unset($_SESSION['formdata']);

?>
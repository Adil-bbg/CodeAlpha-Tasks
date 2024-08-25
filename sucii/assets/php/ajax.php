
<?php
require_once 'function.php';

if (isset($_GET['follow'])) {
    $user_id = $_POST['user_id'];
    // $response = ['status' => false];

    if (followUser($user_id)) {
        $response['status'] = true;
    } else {
        $response['status'] = false;
    }

    echo json_encode($response);
}

if (isset($_GET['unfollow'])) {
    $user_id = $_POST['user_id'];
    // $response = ['status' => false];

    if (unfollowUser($user_id)) {
        $response['status'] = true;
    } else {
        $response['status'] = false;
        // $response['message'] = "Unable to follow user.";
    }

    echo json_encode($response);
}

// AJAX Code:

// The click event is handled for both like_btn and unlike_btn.
// Based on the button's current class, the script determines whether to like or unlike the post.
// The appropriate URL (like or unlike) is called.
// On success, the button's class and appearance are toggled to reflect the new state (liked or unliked).

if (isset($_GET['like'])) {
    $post_id = $_POST['post_id'];
    // $response = ['status' => false];
    if(!checkLikeStatus($post_id)){
        if (likePost($post_id)) {
            $response['status'] = true;
        } else {
            $response['status'] = false;
            // $response['message'] = "Unable to follow user.";
        }
    
        echo json_encode($response);        
    }    
    }

    
if (isset($_GET['unlike'])) {
    $post_id = $_POST['post_id'];
    // $response = ['status' => false];
    if(checkLikeStatus($post_id)){
        if (unlikePost($post_id)) {
            $response['status'] = true;
        } else {
            $response['status'] = false;
            // $response['message'] = "Unable to follow user.";
        }
    
        echo json_encode($response);        
    }    
    }


    if (isset($_GET['add_comment'])) {
        $post_id = $_POST['post_id'];
        $comment_text = $_POST['comment_text'];
        $user_id = $_SESSION['userdata']['id'];
    
        if (addComment($post_id, $user_id, $comment_text)) {
            $response['status'] = true;
        } else {
            $response['status'] = false;
        }
    
        echo json_encode($response);
    }
    
    if (isset($_GET['delete_comment'])) {
        $comment_id = $_POST['comment_id'];
        $user_id = $_SESSION['userdata']['id'];
    
        if (deleteComment($comment_id, $user_id)) {
            $response['status'] = true;
        } else {
            $response['status'] = false;
        }
    
        echo json_encode($response);
    }

    if (isset($_GET['getcomments']) && isset($_GET['post_id'])) {
        $post_id = $_GET['post_id'];
        $comments = getComments($post_id); // Assume this function fetches comments from the DB
        echo json_encode(['status' => true, 'comments' => $comments]);
        exit();
    }
    if (isset($_GET['getreplies']) && isset($_GET['comment_id'])) {
        $comment_id = $_GET['comment_id'];
        $replies = getCommentReplies($comment_id); // Assume this function fetches replies from the DB
        echo json_encode(['status' => true, 'replies' => $replies]);
        exit();
    }
        
?>
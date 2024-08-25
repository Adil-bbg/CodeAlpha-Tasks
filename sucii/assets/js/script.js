// For post image preview
let input = document.getElementById('Sucii_select_post');
input.addEventListener("change", preview);

function preview(){
    let fileobject = this.files[0];
    let filereader = new FileReader();
    filereader.readAsDataURL(fileobject);

    filereader.onload = function () {
        let image_src = filereader.result;
        let image = document.getElementById('preview_post_img');
        image.setAttribute('src', image_src);
        image.style.display = 'block'; // Ensure the image is displayed
    }
}


// for folllow user
$(".followbtn").click(function(){
    let user_id_v = $(this).data('userId');
    let button = this;
    $(button).attr('disabled', true);
    $.ajax({
        url: 'assets/php/ajax.php?follow',
        method: 'post',
        dataType: 'json',
        data: { user_id: user_id_v },
        success: function(response){
            if(response.status){
                $(button).attr('disabled', true);
                $(button).data('user-id', 0);
                $(button).html('Following <i class="bi bi-check-circle"></i>');
                location.reload();

            } else {
                $(button).attr('disabled', false);
                alert(response.message || 'An error occurred. Please try again.');
            }
        }
    });
});



// for unfolllow user
$(".unfollowbtn").click(function(){
    let user_id_v = $(this).data('userId');
    let button = this;
    $(button).attr('disabled', true);
    $.ajax({
        url: 'assets/php/ajax.php?unfollow',
        method: 'post',
        dataType: 'json',
        data: { user_id: user_id_v },
        success: function(response){
            if(response.status){
                $(button).data('user-id', 0);
                $(button).html('Unfolloed');
                location.reload();
            } else {
                $(button).attr('disabled', false);
                alert(response.message || 'An error occurred. Please try again.');
            }
        }
    });
});

$(document).on('click', '.like_btn, .unlike_btn', function(){
    let post_id_v = $(this).data('postId');
    let button = this;
    $(button).attr('disabled',true);

    // Determine the action (like or unlike) based on the current button class
    let action = $(button).hasClass('like_btn') ? 'like' : 'unlike';
    let toggleClass = action === 'like' ? 'bi-heart-fill text-danger unlike_btn' : 'bi-heart like_btn';
    let url = action === 'like' ? 'assets/php/ajax.php?like' : 'assets/php/ajax.php?unlike';

    $.ajax({
        url: url,
        method: 'post',
        dataType: 'json',
        data: { post_id: post_id_v },
        success: function(response){
            if(response.status){
                $(button).attr('disabled', false);
                // Toggle the button class and appearance
                $(button).toggleClass('bi-heart bi-heart-fill text-danger like_btn unlike_btn');
                location.reload();
            } else {
                $(button).attr('disabled', false);
                alert(response.message || 'An error occurred. Please try again.');
            }
        }
    });
});

$(document).on('click', '#addCommentBtn', function(){
    let post_id = $(this).data('postId');
    let comment_text = $('#commentInput').val();
    let button = this;

    if(comment_text.trim() === '') return;

    $.ajax({
        url: 'assets/php/ajax.php?add_comment',
        method: 'post',
        dataType: 'json',
        data: { post_id: post_id, comment_text: comment_text },
        success: function(response){
            if(response.status){
                location.reload(); // or dynamically append the new comment
            } else {
                alert(response.message || 'An error occurred. Please try again.');
            }
        }
    });
});


$(document).on('click', '.delete-comment-btn', function(){
    let comment_id = $(this).data('commentId');

    $.ajax({
        url: 'assets/php/ajax.php?delete_comment',
        method: 'post',
        dataType: 'json',
        data: { comment_id: comment_id },
        success: function(response){
            if(response.status){
                location.reload(); // or dynamically remove the comment
            } else {
                alert(response.message || 'An error occurred. Please try again.');
            }
        }
    });
});

document.querySelectorAll('.reply-btn').forEach(button => {
    button.addEventListener('click', function() {
        const commentId = this.getAttribute('data-comment-id');
        const replyInput = document.createElement('input');
        replyInput.setAttribute('type', 'text');
        replyInput.setAttribute('placeholder', 'Write a reply...');
        replyInput.classList.add('form-control', 'rounded-0', 'border-0', 'mt-2');
        
        this.parentElement.appendChild(replyInput);

        replyInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const replyText = this.value;

                // AJAX request to add reply
                fetch('./path/to/reply-handler.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        comment_id: commentId,
                        reply_text: replyText
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Append the reply to the UI or refresh the comment section
                    }
                });
            }
        });
    });
});


document.addEventListener("DOMContentLoaded", function() {
    const commentsModal = document.getElementById('commentsModal');
    const commentsContainer = document.getElementById('commentsContainer');
    const commentForm = document.getElementById('commentForm');
    const modalPostIdInput = document.getElementById('modalPostId');

    commentsModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const postId = button.getAttribute('data-post-id');

        modalPostIdInput.value = postId;

        // Clear previous comments
        commentsContainer.innerHTML = '';

        // Fetch comments using AJAX
        fetch(`./assets/php/actions.php?getcomments&post_id=${postId}`)
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    data.comments.forEach(comment => {
                        const commentElement = document.createElement('div');
                        commentElement.classList.add('p-2', 'border-bottom');
                        commentElement.innerHTML = `
                            <div class="d-flex align-items-center">
                                <img src="./assets/images/profile/${comment.profile_pic || 'default.png'}" alt="Profile Picture" style="height:30px;width:30px;object-fit:cover;" class="rounded-circle border">
                                <div class="ms-2">
                                    <strong>${comment.first_name} ${comment.last_name}</strong>
                                    <p class="mb-1">${comment.comment_text}</p>
                                    <button class="btn btn-link reply-btn" data-comment-id="${comment.id}">Reply</button>
                                    <div id="repliesContainer${comment.id}"></div>
                                </div>
                            </div>
                        `;
                        commentsContainer.appendChild(commentElement);

                        // Fetch replies for each comment
                        fetch(`./assets/php/actions.php?getreplies&comment_id=${comment.id}`)
                            .then(response => response.json())
                            .then(replyData => {
                                if (replyData.status) {
                                    const repliesContainer = document.getElementById(`repliesContainer${comment.id}`);
                                    replyData.replies.forEach(reply => {
                                        const replyElement = document.createElement('div');
                                        replyElement.classList.add('ms-4', 'border-bottom');
                                        replyElement.innerHTML = `
                                            <div class="d-flex align-items-center">
                                                <img src="./assets/images/profile/${reply.profile_pic || 'default.png'}" alt="Profile Picture" style="height:25px;width:25px;object-fit:cover;" class="rounded-circle border">
                                                <div class="ms-2">
                                                    <strong>${reply.first_name} ${reply.last_name}</strong>
                                                    <p class="mb-1">${reply.comment_text}</p>
                                                </div>
                                            </div>
                                        `;
                                        repliesContainer.appendChild(replyElement);
                                    });
                                }
                            });
                    });
                }
            });
    });

    commentForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(commentForm);
        fetch('./assets/php/actions.php?addcomment', {
            method: 'POST',
            body: formData
        }).then(response => response.json())
          .then(data => {
              if (data.status) {
                  // Reload comments
                  commentsModal.dispatchEvent(new Event('show.bs.modal', { relatedTarget: commentsModal }));
              } else {
                  alert('Failed to add comment.');
              }
          });
    });
});

<?php
global $user;
global $posts;
global $follow_suggestion;
?>
<div class="bg-dark container col-9 rounded-0 d-flex justify-content-between">
    <div class="col-8">
        <?php
        showError('post_image');
        if (count($posts) < 1) {
            echo '<p class="text-muted bg-white text-center rounded border p-2">Follow some people you know, watch their posts, or post something you like to share with <b>Sucii</b>. Explore <b>Sucii</b> & Enjoy!</p>';
        } else {
            foreach ($posts as $post) {
                $count_likes = countLikes($post['id']);
                ?>
                <div class="card mt-4 bg-dark border">
                    <div class="card-title d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center p-2">
                            <img src="./assets/images/profile/<?= $post['profile_pic'] ?>"
                                 style="height:30px;width:30px;aspect-ratio:1/1;object-fit:cover;" alt=""
                                 class="rounded-circle border">
                            <span class="ms-1">
                                <a href="?user=<?= $post['username'] ?>" class="text-decoration-none text-white">
                                    <?= $post['first_name'] ?> <?= $post['last_name'] ?>
                                </a>
                            </span>
                        </div>
                        <div class="p-2">
                            <i class="bi bi-three-dots-vertical text-white"></i>
                        </div>
                    </div>
                    <?php if ($post['post_des']) { ?>
                        <div class="card-body">
                            <?= $post['post_des'] ?>
                        </div>
                    <?php } ?>
                    <img src="./assets/images/posts/<?= $post['post_image'] ?>" class="" alt="...">
                    <h4 style="font-size: x-larger" class="p-2 border-bottom text-white">
                        <i class="bi <?= checkLikeStatus($post['id']) ? 'bi-heart-fill text-danger unlike_btn' : 'bi-heart like_btn' ?>"
                           data-post-id='<?= $post['id'] ?>'></i>
                        &nbsp;&nbsp;<i class="bi bi-chat-left" data-bs-toggle="modal" data-bs-target="#commentsModal<?= $post['id'] ?>"></i>
                    </h4>
                    <div class="p-2">
                        <span style="cursor:pointer; color:white;" data-bs-toggle="modal" data-bs-target="#likesModal<?= $post['id'] ?>">
                            <?= count($count_likes) ?>&nbsp; Likes
                        </span>
                    </div>

                    <!-- Comment Section -->
                    
<div class="input-group">
    <form method="post" action="./assets/php/actions.php?addcomment">
        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
        <input type="text" name="comment_text" class="form-control" placeholder="Add a comment..." aria-label="Comment" aria-describedby="button-addon2" id="commentInput">
        <button class="btn" type="submit" id="addCommentBtn">Comment</button>
    </form>
</div>

                    <!-- Likes Modal for each post -->
                    <div class="modal fade " id="likesModal<?= $post['id'] ?>" tabindex="-1"
                         aria-labelledby="likesModalLabel<?= $post['id'] ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered ">
                            <div class="modal-content">
                                <div class="modal-header bg-dark">
                                    <h1 class="modal-title text-white fs-5" id="likesModalLabel<?= $post['id'] ?>">Likes</h1>
                                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body bg-dark">
                                    <?php if (!empty($count_likes)): ?>
                                        <?php foreach ($count_likes as $fuser): ?>
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex align-items-center p-2">
                                                    <div>
                                                        <img src="./assets/images/profile/<?= htmlspecialchars($fuser['profile_pic'] ?? 'default.png') ?>"
                                                             alt="Profile Picture"
                                                             style="height:40px;width:40px;object-fit:cover;aspect-ratio:1/1;"
                                                             class="rounded-circle border">
                                                    </div>
                                                    <div>&nbsp;&nbsp;</div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 style="margin: 0px;font-size: small;">
                                                            <a href="?user=<?= htmlspecialchars($fuser['username'] ?? 'unknown') ?>"
                                                               class="text-decoration-none text-white">
                                                                <?= htmlspecialchars($fuser['first_name'] ?? 'Unknown') ?>
                                                                <?= htmlspecialchars($fuser['last_name'] ?? '') ?>
                                                            </a>
                                                        </h6>
                                                        <p style="margin:0px;font-size:small" class="text-muted">
                                                            <?= htmlspecialchars($fuser['username'] ?? 'unknown') ?>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <?php if ($_SESSION['userdata']['id'] !== $fuser['id']): ?>
                                                        <?php if (checkFollowStatus($fuser['id'])): ?>
                                                            <button class="btn btn-sm btn-danger unfollowbtn"
                                                                    data-user-id="<?= htmlspecialchars($fuser['id']) ?>">Unfollow</button>
                                                        <?php else: ?>
                                                            <button class="btn btn-sm btn-primary followbtn"
                                                                    data-user-id="<?= htmlspecialchars($fuser['id']) ?>">Follow</button>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p class="text-white">No likes to display.</p>
                                    <?php endif; ?>
                                </div>
                                <div class="modal-footer bg-dark">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Comments Modal for each post -->
                    <div class="modal fade" id="commentsModal<?= $post['id'] ?>" tabindex="-1"
                         aria-labelledby="commentsModalLabel<?= $post['id'] ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-dark">
                                    <h1 class="modal-title text-white fs-5" id="commentsModalLabel<?= $post['id'] ?>">Comments</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body bg-dark">
                                    <!-- Comments Section -->
                                    <?php
                                    $comments = getComments($post['id']);
                                    foreach ($comments as $comment):
                                        ?>
                                        <div class="p-2">
                                            <div class="d-flex align-items-center">
                                                <img src="./assets/images/profile/<?= htmlspecialchars($comment['profile_pic'] ?? 'default.png') ?>"
                                                     alt="Profile Picture" style="height:30px;width:30px;object-fit:cover;" class="rounded-circle border">
                                                <div class="ms-2">
                                                    <strong class="text-white"><?= htmlspecialchars($comment['first_name'] . ' ' . $comment['last_name']) ?></strong>
                                                    <p class="mb-1 text-white"><?= htmlspecialchars($comment['comment_text']) ?></p>
                                                    <button class="btn btn-link text-white reply-btn" data-comment-id="<?= $comment['id'] ?>">Reply</button>
                                                </div>
                                            </div>
                                            <?php
                                            $replies = getCommentReplies($comment['id']);
                                            foreach ($replies as $reply):
                                                ?>
                                                <div class="ms-4">
                                                    <div class="d-flex align-items-center">
                                                        <img src="./assets/images/profile/<?= htmlspecialchars($reply['profile_pic'] ?? 'default.png') ?>"
                                                             alt="Profile Picture" style="height:25px;width:25px;object-fit:cover;" class="rounded-circle border">
                                                        <div class="ms-2">
                                                            <strong><?= htmlspecialchars($reply['first_name'] . ' ' . $reply['last_name']) ?></strong>
                                                            <p class="mb-1"><?= htmlspecialchars($reply['comment_text']) ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="modal-footer bg-dark">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>

    <!-- Sidebar Section for Follow Suggestions -->
    <div class="col-4 mt-4 p-3">
        <div class="d-flex align-items-center p-2">
            <div>
                <img src="./assets/images/profile/<?= $user['profile_pic']?>" alt=""
                     style="width:60px;height:60px;aspect-ratio:1/1;object-fit:cover;" class="rounded-circle border">
            </div>
            <div>&nbsp;&nbsp;&nbsp;</div>
            <div class="d-flex flex-column justify-content-center align-items-center">
                <h6 class="m-0 p-0 text-white">
                    <a href="?user=<?= $user['username'] ?>" class="text-decoration-none text-white">
                        <?= $user['first_name'] . " " . $user['last_name'] ?>
                    </a>
                </h6>
                <p style="margin: 0px;font-size: small;color:white;" class="text-white"><?= $user['username'] ?></p>
            </div>
        </div>
        <div class="p-2">
            <h6 class="text-white">Follow Suggestions</h6>
            <?php if (count($follow_suggestion) < 1) {
                echo '<p class="text-white">No suggestions to show.</p>';
            } else {
                foreach ($follow_suggestion as $fuser) { ?>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center p-2">
                            <div>
                                <img src="./assets/images/profile/<?= htmlspecialchars($fuser['profile_pic'] ?? 'default.png') ?>"
                                     alt="Profile Picture" style="height:40px;width:40px;object-fit:cover;aspect-ratio:1/1;" class="rounded-circle border">
                            </div>
                            <div>&nbsp;&nbsp;&nbsp;</div>
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class="text-white" style="margin: 0px;font-size: small;">
                                    <a href="?user=<?= htmlspecialchars($fuser['username'] ?? 'unknown') ?>"
                                       class="text-decoration-none text-white">
                                        <?= htmlspecialchars($fuser['first_name'] ?? 'Unknown') ?>
                                        <?= htmlspecialchars($fuser['last_name'] ?? '') ?>
                                    </a>
                                </h6>
                                <p style="margin:0px;font-size:small;color:white;" class="text-white">
                                    <?= htmlspecialchars($fuser['username'] ?? 'unknown') ?>
                                </p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <?php if (checkFollowStatus($fuser['id'])) { ?>
                                <button class="btn btn-sm btn-danger unfollowbtn" data-user-id="<?= htmlspecialchars($fuser['id']) ?>">Unfollow</button>
                            <?php } else { ?>
                                <button class="btn btn-sm btn-primary followbtn" data-user-id="<?= htmlspecialchars($fuser['id']) ?>">Follow</button>
                            <?php } ?>
                        </div>
                    </div>
                <?php }
            } ?>
        </div>
    </div>
</div>

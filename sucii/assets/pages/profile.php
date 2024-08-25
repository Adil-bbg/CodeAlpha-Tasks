<?php
global $user;
global $postOnProfile;
global $profile;
?> 

<div class="container bg-dark col-9 rounded-0"> 
    <div class="col-12 rounded p-4 mt-4 d-flex gap-5"> 
        <div class="col-4 d-flex justify-content-end align-items-start"> 
            <img src="assets/images/profile/<?= htmlspecialchars($profile['profile_pic'] ?? 'default.jpg') ?>" class="img-thumbnail rounded-circle my-3" style="height:170px;width:170px;aspect-ratio:1/1;object-fit:cover;" alt="Profile Picture"> 
        </div> 
        <div class="col-8"> 
            <div class="d-flex flex-column"> 
                <div class="d-flex gap-5 align-items-center"> 
                    <span style="font-size: xx-large;color:white;">
                        <?= htmlspecialchars($profile['first_name'] ?? 'Unknown') ?> <?= htmlspecialchars($profile['last_name'] ?? 'User') ?>
                    </span> 
                    <?php if ($user['id'] != $profile['id']): ?> 
                        <div class="dropdown text-white"> 
                            <span class="dropdown-toggle" style="font-size:xx-large" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots"></i></span> 
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1"> 
                                <li><a class="dropdown-item" href="#"><i class="bi bi-chat-fill"></i> Message</a></li> 
                                <li><a class="dropdown-item" href="#"><i class="bi bi-x-circle-fill"></i> Block</a></li> 
                            </ul> 
                        </div> 
                    <?php endif; ?> 
                </div> 
                <span style="font-size: larger;" class="text-secondary"> <?= htmlspecialchars($profile['username'] ?? 'username') ?> </span> 
                <div class="d-flex gap-2 align-items-center my-3"> 
                    <button class="btn btn-sm btn-light"><i class="bi bi-file-post-fill"></i> <?= count($postOnProfile) ?> Posts </button> 
                    <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#followers_list_modal">
                        <i class="bi bi-people-fill"></i> <?= count($profile['followers'] ?? []) ?> Followers
                    </button>
                    <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#following_list_modal"> 
                        <i class="bi bi-person-fill"></i> <?= count($profile['following'] ?? []) ?> Following 
                    </button> 
                </div> 
                <?php if ($user['id'] != $profile['id']): ?> 
                    <div class="d-flex gap-2 align-items-center my-1"> 
                        <?php if (checkFollowStatus($profile['id'])): ?> 
                            <button class="btn btn-sm btn-danger unfollowbtn" data-user-id="<?= htmlspecialchars($profile['id']) ?>">Unfollow</button> 
                        <?php else: ?> 
                            <button class="btn btn-sm btn-primary followbtn" data-user-id="<?= htmlspecialchars($profile['id']) ?>">Follow</button> 
                        <?php endif; ?> 
                    </div> 
                <?php endif; ?> 
            </div> 
        </div> 
    </div> 
    <h3 class="border-bottom text-white">Posts</h3> 
    <div class="gallery d-flex flex-wrap gap-2 mb-4"> 
        <?php if (count($postOnProfile) < 1): ?> 
            <p class="text-white bg-dark text-center p-2">No Posts Found</p> 
        <?php else: ?>
            <?php foreach ($postOnProfile as $post): ?> 
                <img src="assets/images/posts/<?= htmlspecialchars($post['post_image'] ?? 'default.jpg') ?>" 
                     style="height:300px;width:300px;aspect-ratio:1/1;object-fit:contain" 
                     class="rounded img-fluid" 
                     data-bs-toggle="modal" 
                     data-bs-target="#postModal<?= htmlspecialchars($post['id']) ?>"
                     alt="Post Image">
                
                <!-- Modal for Post -->
                <div class="modal fade" id="postModal<?= htmlspecialchars($post['id']) ?>" tabindex="-1" aria-labelledby="postModalLabel<?= htmlspecialchars($post['id']) ?>" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body d-flex p-0">
                                <div class="col-8">
                                    <img src="assets/images/posts/<?= htmlspecialchars($post['post_image'] ?? 'default.jpg') ?>" class="w-100 rounded-start">
                                </div>
                                <div class="col-4 d-flex flex-column">
                                    <div class="d-flex align-items-center p-2 border-bottom">
                                        <div><img src="assets/images/profile/<?= htmlspecialchars($post['profile_pic'] ?? 'default.jpg')?>" alt="" height="50" class="rounded-circle border"></div>
                                        <div>&nbsp;&nbsp;&nbsp;</div>
                                        <div class="d-flex flex-column justify-content-start align-items-center">
                                            <h6 style="margin: 0px;"><?= htmlspecialchars($post['first_name'] ?? 'Unknown') ?> <?= htmlspecialchars($post['last_name'] ?? 'User') ?></h6>
                                            <p style="margin:0px;" class="text-muted"><?= htmlspecialchars($post['username'] ?? 'username') ?></p>
                                        </div>
                                    </div>
                                    <div class="flex-fill align-self-stretch overflow-auto" style="height: 100px;">
                                        <!-- Comments -->
                                        <?php if (isset($post['comments']) && is_array($post['comments'])): ?>
                                            <?php foreach($post['comments'] as $comment): ?>
                                                <div class="d-flex align-items-center p-2">
                                                    <div><img src="./assets/images/profile/<?= htmlspecialchars($comment['profile_pic'] ?? 'default.jpg') ?>" alt="" height="40" class="rounded-circle border"></div>
                                                    <div>&nbsp;&nbsp;&nbsp;</div>
                                                    <div class="d-flex flex-column justify-content-start align-items-start">
                                                        <h6 style="margin: 0px;"><?= htmlspecialchars($comment['username'] ?? 'Anonymous') ?></h6>
                                                        <p style="margin:0px;" class="text-muted"><?= htmlspecialchars($comment['comment_text'] ?? '') ?></p>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <p class="text-muted text-center">No Comments Yet</p>
                                        <?php endif; ?>
                                    </div>
                                    <div class="input-group p-2 border-top">
                                        <input type="text" class="form-control rounded-0 border-0" placeholder="Say something..." aria-label="Comment" aria-describedby="button-addon2">
                                        <button class="btn btn-outline-primary rounded-0 border-0" type="button" id="button-addon2">Post</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?> 
        <?php endif; ?> 
    </div> 
</div> 

<!-- Followers Modal -->
<div class="modal fade" id="followers_list_modal" tabindex="-1" aria-labelledby="followersListModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h1 class="modal-title text-light fs-5" id="followersListModalLabel">Followers</h1>
                <button type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php if (!empty($profile['followers'])): ?>
                    <?php foreach ($profile['followers'] as $fuser): ?>
                        <div class="d-flex justify-content-between">
                            <div class="d-flex align-items-center p-2">
                                <div>
                                    <img src="./assets/images/profile/<?= htmlspecialchars($fuser['profile_pic'] ?? 'default.jpg') ?>" alt="Profile Picture" style="height:40px;width:40px;object-fit:cover;aspect-ratio:1/1;" class="rounded-circle border">
                                </div>
                                <div>&nbsp;&nbsp;</div>
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 style="margin: 0px;font-size: small;color:white;">
                                        <a class="text-decoration-none text-white" href="?user=<?= htmlspecialchars($fuser['username'] ?? '#') ?>" class="text-decoration-none text-white">
                                            <?= htmlspecialchars($fuser['first_name'] ?? 'Unknown') ?> <?= htmlspecialchars($fuser['last_name'] ?? 'User') ?>
                                        </a>
                                    </h6>
                                    <p style="margin:0px;font-size:small" class="text-white">
                                        <?= htmlspecialchars($fuser['username'] ?? 'username') ?>
                                    </p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <?php if ($user['id'] !== $fuser['id']): ?>
                                    <?php if (checkFollowStatus($fuser['id'])): ?>
                                        <button class="btn btn-sm btn-danger unfollowbtn" data-user-id="<?= htmlspecialchars($fuser['id']) ?>">Unfollow</button>
                                    <?php else: ?>
                                        <button class="btn btn-sm btn-light followbtn" data-user-id="<?= htmlspecialchars($fuser['id']) ?>">Follow</button>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted text-center">No Followers Found</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Following Modal -->
<div class="modal fade" id="following_list_modal" tabindex="-1" aria-labelledby="followingListModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark" >
            <div class="modal-header">
                <h1 class="modal-title text-white fs-5" id="followingListModalLabel">Following</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php if (!empty($profile['following'])): ?>
                    <?php foreach ($profile['following'] as $fuser): ?>
                        <div class="d-flex justify-content-between">
                            <div class="d-flex align-items-center p-2">
                                <div>
                                    <img src="./assets/images/profile/<?= htmlspecialchars($fuser['profile_pic'] ?? 'default.jpg') ?>" alt="Profile Picture" style="height:40px;width:40px;object-fit:cover;aspect-ratio:1/1;" class="rounded-circle border">
                                </div>
                                <div>&nbsp;&nbsp;</div>
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 style="margin: 0px;font-size: small;">
                                        <a href="?user=<?= htmlspecialchars($fuser['username'] ?? '#') ?>" class="text-decoration-none text-white">
                                            <?= htmlspecialchars($fuser['first_name'] ?? 'Unknown') ?> <?= htmlspecialchars($fuser['last_name'] ?? 'User') ?>
                                        </a>
                                    </h6>
                                    <p style="margin:0px;font-size:small" class="text-white">
                                        <?= htmlspecialchars($fuser['username'] ?? 'username') ?>
                                    </p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <?php if ($user['id'] !== $fuser['id']): ?>
                                    <?php if (checkFollowStatus($fuser['id'])): ?>
                                        <button class="btn btn-sm btn-danger unfollowbtn" data-user-id="<?= htmlspecialchars($fuser['id']) ?>">Unfollow</button>
                                    <?php else: ?>
                                        <button class="btn btn-sm btn-light followbtn" data-user-id="<?= htmlspecialchars($fuser['id']) ?>">Follow</button>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-white text-center">Not Following Anyone</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

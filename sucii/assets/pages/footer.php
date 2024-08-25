
<!-- Modal -->
<div class="modal fade" id="addpost" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Post</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

          <form class="row g-3" method="post" action="./assets/php/actions.php?addpost" enctype="multipart/form-data">
              <img src="" id="preview_post_img" alt="Image Preview" style="display:none;" class="my-3 w-100 rounded border">
                    <div class="form-floating my-3">
                        <textarea class="form-control" name="post_des" placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                        <label for="floatingTextarea">What's on your mind</label>
                    </div>    
                <div class="my-3">
                        <input class="form-control" type="file" id="Sucii_select_post" accept="image/*" name="Sucii_select_post">
                    </div>
                    <div class="modal-footer">       
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Post</button>
                    </div>
                </form>
            </div>
    </div>
  </div>
</div>
<script src="assets/js/JQuery.js"></script>
<script src="assets/js/script.js?v=<?=time()?>"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>
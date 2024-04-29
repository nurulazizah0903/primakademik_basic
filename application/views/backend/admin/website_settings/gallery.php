<div class="card">
  <div class="card-body">
  <h4 class="header-title"><?php echo get_phrase('gallery') ;?></h4>
    <form method="POST" class="col-12 updateGallerySettings" action="<?php echo route('gallery') ;?>" enctype="multipart/form-data">
      <div class="row justify-content-left">
        <div class="col-12">

          <div class="form-group row mb-3">
            <label class="col-md-3 col-form-label" for="example-fileinput"><?php echo get_phrase('gallery_image'); ?></label>
            <div class="col-md-9 custom-file-upload">
              <div class="wrapper-image-preview" style="margin-left: -6px;"><font color="red">*</font> <?php echo get_phrase('ukuran_galeri'); ?></font>
                <div class="box" style="width: 250px;">
                  <div class="js--image-preview" style="background-image: url(<?php echo $this->frontend_model->get_gallery_image_one(); ?>); background-color: #F5F5F5;"></div>
                  <div class="upload-options">
                    <label for="gallery_image_one" class="btn"> <i class="mdi mdi-camera"></i> <?php echo get_phrase('upload_gallery_image'); ?> </label>
                    <input id="gallery_image_one" style="visibility:hidden;" type="file" class="image-upload" name="gallery_image_one" accept="image/*">
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="form-group row mb-3">
            <label class="col-md-3 col-form-label" for="example-fileinput"><?php echo get_phrase('gallery_image'); ?></label>
            <div class="col-md-9 custom-file-upload">
              <div class="wrapper-image-preview" style="margin-left: -6px;"><font color="red">*</font> <?php echo get_phrase('ukuran_galeri'); ?></font>
                <div class="box" style="width: 250px;">
                  <div class="js--image-preview" style="background-image: url(<?php echo $this->frontend_model->get_gallery_image_two(); ?>); background-color: #F5F5F5;"></div>
                  <div class="upload-options">
                    <label for="gallery_image_two" class="btn"> <i class="mdi mdi-camera"></i> <?php echo get_phrase('upload_gallery_image'); ?> </label>
                    <input id="gallery_image_two" style="visibility:hidden;" type="file" class="image-upload" name="gallery_image_two" accept="image/*">
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group row mb-3">
            <label class="col-md-3 col-form-label" for="example-fileinput"><?php echo get_phrase('gallery_image'); ?></label>
            <div class="col-md-9 custom-file-upload">
              <div class="wrapper-image-preview" style="margin-left: -6px;"><font color="red">*</font> <?php echo get_phrase('ukuran_galeri'); ?></font>
                <div class="box" style="width: 250px;">
                  <div class="js--image-preview" style="background-image: url(<?php echo $this->frontend_model->get_gallery_image_tree(); ?>); background-color: #F5F5F5;"></div>
                  <div class="upload-options">
                    <label for="gallery_image_tree" class="btn"> <i class="mdi mdi-camera"></i> <?php echo get_phrase('upload_gallery_image'); ?> </label>
                    <input id="gallery_image_tree" style="visibility:hidden;" type="file" class="image-upload" name="gallery_image_tree" accept="image/*">
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="text-center">
            <button type="submit" class="btn btn-secondary col-xl-4 col-lg-4 col-md-12 col-sm-12" onclick="updateGallerySettings()"><?php echo get_phrase('update_settings') ;?></button>
          </div>
        </div>
      </div>
    </form>

  </div> <!-- end card body-->
</div>
<script>
$(document).ready(function(){
    initCustomFileUploader();
});
</script>


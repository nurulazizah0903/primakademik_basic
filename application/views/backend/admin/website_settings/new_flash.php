<div class="card">
  <div class="card-body">
  <h4 class="header-title"><?php echo get_phrase('new_flash') ;?></h4>
    <form method="POST" class="col-12 updateNewFlashSettings" action="<?php echo route('new_flash') ;?>" enctype="multipart/form-data">
      <div class="row justify-content-left">
        <div class="col-12">
        <div class="form-group row mb-3">
            <label class="col-md-3 col-form-label" for="new_flash_title_one"> <?php echo get_phrase('title') ;?></label>
            <div class="col-md-9">
              <input type="text" id="new_flash_title_one" name="new_flash_title_one" class="form-control"  value="<?php echo get_frontend_settings('new_flash_title_one') ;?>" required>
            </div>
          </div>
          <div class="form-group row mb-3">
            <label class="col-md-3 col-form-label" for="new_flash_description_one"> <?php echo get_phrase('description') ;?></label>
            <div class="col-md-9">
                <textarea name="new_flash_description_one" id="new_flash_description_one" class="form-control" cols="5" rows="5" required><?php echo get_frontend_settings('new_flash_description_one') ;?></textarea>
            </div>
          </div>
          <div class="form-group row mb-3">
            <label class="col-md-3 col-form-label" for="example-fileinput"><?php echo get_phrase('new_flash_image'); ?></label>
            <div class="col-md-9 custom-file-upload">
              <div class="wrapper-image-preview" style="margin-left: -6px;"><font color="red">*</font> <?php echo get_phrase('ukuran'); ?></font>
                <div class="box" style="width: 250px;">
                  <div class="js--image-preview" style="background-image: url(<?php echo $this->frontend_model->get_new_flash_image_one(); ?>); background-color: #F5F5F5;"></div>
                  <div class="upload-options">
                    <label for="new_flash_image_one" class="btn"> <i class="mdi mdi-camera"></i> <?php echo get_phrase('upload_new_flash_image'); ?> </label>
                    <input id="new_flash_image_one" style="visibility:hidden;" type="file" class="image-upload" name="new_flash_image_one" accept="image/*">
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="form-group row mb-3">
            <label class="col-md-3 col-form-label" for="new_flash_title_two"> <?php echo get_phrase('title') ;?></label>
            <div class="col-md-9">
              <input type="text" id="new_flash_title_two" name="new_flash_title_two" class="form-control"  value="<?php echo get_frontend_settings('new_flash_title_two') ;?>" required>
            </div>
          </div>
          <div class="form-group row mb-3">
            <label class="col-md-3 col-form-label" for="new_flash_description_two"> <?php echo get_phrase('description') ;?></label>
            <div class="col-md-9">
            <textarea name="new_flash_description_two" id="new_flash_description_two" class="form-control" cols="5" rows="5" required><?php echo get_frontend_settings('new_flash_description_two') ;?></textarea>
            </div>
          </div>
          <div class="form-group row mb-3">
            <label class="col-md-3 col-form-label" for="example-fileinput"><?php echo get_phrase('new_flash_image'); ?></label>
            <div class="col-md-9 custom-file-upload">
              <div class="wrapper-image-preview" style="margin-left: -6px;"><font color="red">*</font> <?php echo get_phrase('ukuran'); ?></font>
                <div class="box" style="width: 250px;">
                  <div class="js--image-preview" style="background-image: url(<?php echo $this->frontend_model->get_new_flash_image_two(); ?>); background-color: #F5F5F5;"></div>
                  <div class="upload-options">
                    <label for="new_flash_image_two" class="btn"> <i class="mdi mdi-camera"></i> <?php echo get_phrase('upload_new_flash_image'); ?> </label>
                    <input id="new_flash_image_two" style="visibility:hidden;" type="file" class="image-upload" name="new_flash_image_two" accept="image/*">
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group row mb-3">
            <label class="col-md-3 col-form-label" for="new_flash_title_tree"> <?php echo get_phrase('title') ;?></label>
            <div class="col-md-9">
              <input type="text" id="new_flash_title_tree" name="new_flash_title_tree" class="form-control"  value="<?php echo get_frontend_settings('new_flash_title_tree') ;?>" required>
            </div>
          </div>
          <div class="form-group row mb-3">
            <label class="col-md-3 col-form-label" for="new_flash_description_tree"> <?php echo get_phrase('description') ;?></label>
            <div class="col-md-9">
            <textarea name="new_flash_description_tree" id="new_flash_description_tree" class="form-control" cols="5" rows="5" required><?php echo get_frontend_settings('new_flash_description_tree') ;?></textarea>
            </div>
          </div>
          <div class="form-group row mb-3">
            <label class="col-md-3 col-form-label" for="example-fileinput"><?php echo get_phrase('new_flash_image'); ?></label>
            <div class="col-md-9 custom-file-upload">
              <div class="wrapper-image-preview" style="margin-left: -6px;"><font color="red">*</font> <?php echo get_phrase('ukuran'); ?></font>
                <div class="box" style="width: 250px;">
                  <div class="js--image-preview" style="background-image: url(<?php echo $this->frontend_model->get_new_flash_image_tree(); ?>); background-color: #F5F5F5;"></div>
                  <div class="upload-options">
                    <label for="new_flash_image_tree" class="btn"> <i class="mdi mdi-camera"></i> <?php echo get_phrase('upload_new_flash_image'); ?> </label>
                    <input id="new_flash_image_tree" style="visibility:hidden;" type="file" class="image-upload" name="new_flash_image_tree" accept="image/*">
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="text-center">
            <button type="submit" class="btn btn-secondary col-xl-4 col-lg-4 col-md-12 col-sm-12" onclick="updateNewFlashSettings()"><?php echo get_phrase('update_settings') ;?></button>
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

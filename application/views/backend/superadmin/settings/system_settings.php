<div class="row">
  <div class="col-xl-7 col-lg-12 col-md-12 col-sm-12">
    <div class="card">
      <div class="card-body">
        <h4 class="header-title"><?php echo get_phrase('system_settings') ;?></h4>
        <form method="POST" class="col-12 systemAjaxForm" action="<?php echo route('system_settings/update') ;?>" id = "system_settings">
          <div class="col-12">
            <div class="mb-3 form-group row">
              <label class="col-md-3 col-form-label" for="system_name"> <?php echo get_phrase('system_name') ;?></label>
              <div class="col-md-9">
                <input type="text" id="system_name" name="system_name" class="form-control"  value="<?php echo get_settings('system_name') ;?>" required>
              </div>
            </div>

            <div class="mb-3 form-group row">
              <label class="col-md-3 col-form-label" for="system_title"><?php echo get_phrase('title') ;?></label>
              <div class="col-md-9">
                <input type="text" id="system_title" name="system_title" class="form-control"  value="<?php echo get_settings('system_title') ;?>" required>
              </div>
            </div>

            <div class="mb-3 form-group row">
              <label class="col-md-3 col-form-label" for="system_email"> <?php echo get_phrase('school_email') ;?></label>
              <div class="col-md-9">
                <input type="text" id="system_email" name="system_email" class="form-control"  value="<?php echo get_settings('system_email') ;?>" required>
              </div>
            </div>
            <div class="mb-3 form-group row">
              <label class="col-md-3 col-form-label" for="phone"> <?php echo get_phrase('phone') ;?></label>
              <div class="col-md-9">
                <input type="text" id="phone" name="phone" class="form-control"  value="<?php echo get_settings('phone') ;?>" required>
              </div>
            </div>
            <!-- <div class="mb-3 form-group row">
              <label class="col-md-3 col-form-label" for="email"> <?php echo get_phrase('email') ;?></label>
              <div class="col-md-9">
                <input type="text" id="study_time" name="study_time" class="form-control"  value="<?php echo get_settings('study_time') ;?>" required>
              </div>
            </div> -->
            <div class="mb-3 form-group row">
              <label class="col-md-3 col-form-label" for="fax"> <?php echo get_phrase('fax') ;?></label>
              <div class="col-md-9">
                <input type="text" id="fax" name="fax" class="form-control"  value="<?php echo get_settings('fax') ;?>" required>
              </div>
            </div>

            <div class="mb-3 form-group row">
              <label class="col-md-3 col-form-label" for="address"> <?php echo get_phrase('short_address') ;?></label>
              <div class="col-md-9">
                <textarea class="form-control" id="address" name = "address" rows="5" required><?php echo get_settings('address') ;?></textarea>
              </div>
            </div>

            <div class="mb-3 form-group row">
              <label class="col-md-3 col-form-label" for="complete_address"> <?php echo get_phrase('complete_address') ;?></label>
              <div class="col-md-9">
                <textarea class="form-control" id="complete_address" name = "complete_address" rows="5" required><?php echo get_settings('complete_address') ;?></textarea>
              </div>
            </div>

            <!-- <div class="mb-3 form-group row">
              <label class="col-md-3 col-form-label" for="purchase_code"> <?php echo get_phrase('purchase_code') ;?></label>
              <div class="col-md-9">
                <input type="text" id="purchase_code" name="purchase_code" class="form-control"  value="<?php echo get_settings('purchase_code') ;?>" required>
              </div>
            </div> -->
            <div class="mb-3 form-group row">
              <label class="col-md-3 col-form-label" for="timezone"> <?php echo get_phrase('timezone') ;?></label>

              <div class="col-md-9">
                <select class="form-control select2" data-toggle="select2" id="timezone" name="timezone">
                  <?php $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL); ?>
                  <?php foreach ($tzlist as $tz): ?>
                    <option value="<?php echo $tz ;?>" <?php if(get_settings('timezone') == $tz) echo 'selected'; ?>><?php echo $tz ;?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="mb-3 form-group row">
              <label class="col-md-3 col-form-label" for="footer_text"> <?php echo get_phrase('footer_text') ;?></label>
              <div class="col-md-9">
                <input type="text" id="footer_text" name="footer_text" class="form-control"  value="<?php echo get_settings('footer_text') ;?>" required>
              </div>
            </div>

            <div class="mb-3 form-group row">
              <label class="col-md-3 col-form-label" for="footer_link"><?php echo get_phrase('footer_link') ;?></label>
              <div class="col-md-9">
                <input type="text" id="footer_link" name="footer_link" class="form-control"  value="<?php echo get_settings('footer_link') ;?>" required>
              </div>
            </div>

            <?php if(addon_status('online_courses')): ?>
              <div class="mb-3 form-group row">
                <label class="col-md-3 col-form-label" for="youtube_api_key"><?php echo get_phrase('youtube_api_key') ;?></label>
                <div class="col-md-9">
                  <input type="text" id="youtube_api_key" placeholder="<?php echo get_phrase('youtube_api_key') ;?>" name="youtube_api_key" class="form-control"  value="<?php echo get_settings('youtube_api_key') ;?>">
                </div>
              </div>

              <div class="mb-3 form-group row">
                <label class="col-md-3 col-form-label" for="vimeo_api_key"><?php echo get_phrase('vimeo_api_key') ;?></label>
                <div class="col-md-9">
                  <input type="text" id="vimeo_api_key" placeholder="<?php echo get_phrase('vimeo_api_key') ;?>" name="vimeo_api_key" class="form-control"  value="<?php echo get_settings('vimeo_api_key') ;?>">
                </div>
              </div>
            <?php endif; ?>

            <div class="text-center">
              <button type="submit" class="btn btn-secondary col-xl-4 col-lg-4 col-md-12 col-sm-12" onclick="updateSystemInfo($('#system_name').val())"><?php echo get_phrase('update_settings') ;?></button>
            </div>
          </div>
        </form>

      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div>
  <div class="col-xl-5 col-lg-12 col-md-12 col-sm-12">
    <div class="card">
      <div class="card-body">
        <h4 class="header-title"><?php echo get_phrase('cover_photo') ;?></h4>
        <form method="POST" class="col-12 systemLogoAjaxForm" action="<?php echo route('system_settings/cover_update') ;?>" id = "system_settings" enctype="multipart/form-data">
          <div class="col-md-9 custom-file-upload">
            <div class="wrapper-image-preview" style="margin-left: -6px;">
              <div class="box" style="width: 250px;">
                <div class="js--image-preview" style="background-image: url(<?php echo $this->settings_model->get_cover_photo(); ?>); background-color: #F5F5F5;"></div>
                <div class="upload-options">
                  <label for="cover_photo" class="btn"> <i class="mdi mdi-camera"></i> <?php echo get_phrase('upload_cover'); ?> <small>(600 X 150)</small></label>
                  <input id="cover_photo" style="visibility:hidden;" type="file" class="image-upload" name="cover_photo" accept="image/*">
                </div>
              </div>
            </div>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-secondary col-xl-12 col-lg-6 col-md-12 col-sm-12" onclick="updateSystemLogo()"><?php echo get_phrase('update') ;?></button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php /*<div class="col-xl-5 col-lg-12 col-md-12 col-sm-12">
    <div class="card">
      <div class="card-body">
        <h4 class="header-title"><?php echo get_phrase('product_apk') ;?></h4>
        <?php 
        if (!empty(get_settings('apk'))) { ?>
          <a href="<?php echo base_url('uploads/'.get_settings('apk').''); ?>" class="btn btn-success btn-sm mb-1" download><?php echo get_phrase('download_apk'); ?><i class="mdi mdi-download"></i></a>
        <?php }else { ?>
        <?php } ?>
        <form method="POST" class="col-12 systemApkAjaxForm" action="<?php echo route('system_settings/update_apk') ;?>" id = "system_settings" enctype="multipart/form-data">
          <label for="file_name"><?php echo get_phrase('file'); ?></label>
          <input type="file" class="form-control" name="apk" id="apk">
          <button type="submit" class="float-right mt-3 btn btn-secondary" onclick="updateSystemApk()"><?php echo get_phrase('update') ;?></button>
        </form>
      </div>
    </div>
  </div> */?>
</div>
<div class="row">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="header-title"><?php echo get_phrase('system_logo') ;?></h4>
        <form method="POST" class="col-12 systemLogoAjaxForm" action="<?php echo route('system_settings/logo_update') ;?>" id = "system_settings" enctype="multipart/form-data">

          <div class="row justify-content-center">
            <div class="col-xl-6">
              <div class="mb-3 form-group row">
                <label class="col-md-3 col-form-label" for="example-fileinput"><?php echo get_phrase('regular_logo'); ?></label>
                <div class="col-md-9 custom-file-upload">
                  <div class="wrapper-image-preview" style="margin-left: -6px;">
                    <div class="box" style="width: 250px;">
                      <div class="js--image-preview" style="background-image: url(<?php echo $this->settings_model->get_logo_dark(); ?>); background-color: #F5F5F5;"></div>
                      <div class="upload-options">
                        <label for="dark_logo" class="btn"> <i class="mdi mdi-camera"></i> <?php echo get_phrase('upload_logo'); ?> <small>(600 X 150)</small></label>
                        <input id="dark_logo" style="visibility:hidden;" type="file" class="image-upload" name="dark_logo" accept="image/*">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-6">
              <div class="mb-3 form-group row">
                <label class="col-md-3 col-form-label" for="example-fileinput"><?php echo get_phrase('light_logo'); ?></label>
                <div class="col-md-9 custom-file-upload">
                  <div class="wrapper-image-preview" style="margin-left: -6px;">
                    <div class="box" style="width: 250px;">
                      <div class="js--image-preview" style="background-image: url(<?php echo $this->settings_model->get_logo_light(); ?>); background-color: #F5F5F5;"></div>
                      <div class="upload-options">
                        <label for="light_logo" class="btn"> <i class="mdi mdi-camera"></i> <?php echo get_phrase('upload_logo'); ?> <small>(600 X 150)</small></label>
                        <input id="light_logo" style="visibility:hidden;" type="file" class="image-upload" name="light_logo" accept="image/*">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-6">
              <div class="mb-3 form-group row">
                <label class="col-md-3 col-form-label" for="example-fileinput"><?php echo get_phrase('small_logo'); ?></label>
                <div class="col-md-9 custom-file-upload">
                  <div class="wrapper-image-preview" style="margin-left: -6px;">
                    <div class="box" style="width: 250px;">
                      <div class="js--image-preview" style="background-image: url(<?php echo $this->settings_model->get_logo_light('small'); ?>); background-color: #F5F5F5;"></div>
                      <div class="upload-options">
                        <label for="small_logo" class="btn"> <i class="mdi mdi-camera"></i> <?php echo get_phrase('upload_small_logo'); ?> <small>(80 X 80)</small></label>
                        <input id="small_logo" style="visibility:hidden;" type="file" class="image-upload" name="small_logo" accept="image/*">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-6">
              <div class="mb-3 form-group row">
                <label class="col-md-3 col-form-label" for="example-fileinput"><?php echo get_phrase('favicon'); ?></label>
                <div class="col-md-9 custom-file-upload">
                  <div class="wrapper-image-preview" style="margin-left: -6px;">
                    <div class="box" style="width: 250px;">
                      <div class="js--image-preview" style="background-image: url(<?php echo $this->settings_model->get_favicon(); ?>); background-color: #F5F5F5;"></div>
                      <div class="upload-options">
                        <label for="favicon" class="btn"> <i class="mdi mdi-camera"></i> <?php echo get_phrase('upload_favicon'); ?> <small>(80 X 80)</small></label>
                        <input id="favicon" style="visibility:hidden;" type="file" class="image-upload" name="favicon" accept="image/*">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-secondary col-xl-4 col-lg-6 col-md-12 col-sm-12" onclick="updateSystemLogo()"><?php echo get_phrase('update_logo') ;?></button>
          </div>
        </form>
      </div> <!-- end card body-->
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function () {
  initSelect2(['#timezone']);
});

$(document).ready(function(){
    initCustomFileUploader();
});
</script>

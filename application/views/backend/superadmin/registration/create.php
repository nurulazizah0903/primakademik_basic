<!--title-->
<div class="row ">
      <div class="col-xl-12">
          <div class="card">
              <div class="card-body">
                  <h4 class="page-title">
                      <i class="mdi mdi-account-multiple-plus title_icon"></i> <?php echo get_phrase('ppdb'); ?>
                      
                  </h4>
              </div> <!-- end card body-->
          </div> <!-- end card -->
      </div><!-- end col-->
  </div>
<div class="row">
    <div class="col-12">
        <div class="card pt-0">
            <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                <li class="nav-item">
                    <a href="<?php echo route('registration/create/processed'); ?>" class="nav-link rounded-0 <?php if($aria_expand == 'processed') echo 'active'; ?>">
                        <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                        <span class="d-none d-lg-block"><?php echo get_phrase('new_prospective_students'); ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo route('registration/create/installment'); ?>" class="nav-link rounded-0 <?php if($aria_expand == 'installment') echo 'active'; ?>">
                        <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                        <span class="d-none d-lg-block"><?php echo get_phrase('installment'); ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo route('registration/create/admitted'); ?>" class="nav-link rounded-0 <?php if($aria_expand == 'admitted') echo 'active'; ?>">
                        <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                        <span class="d-none d-lg-block"><?php echo get_phrase('ppdb_accepted'); ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo route('registration/create/installment_accepted'); ?>" class="nav-link rounded-0 <?php if($aria_expand == 'installment_accepted') echo 'active'; ?>">
                        <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                        <span class="d-none d-lg-block"><?php echo get_phrase('mengundurkan_diri'); ?> / <?php echo get_phrase('tidak_diterima'); ?></span>
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active">
                    <?php
                        if($aria_expand == 'registration'):
                            include 'registration_list.php';
                        elseif($aria_expand == 'admitted'):
                            include 'student_list.php';
                        elseif($aria_expand == 'installment'):
                            include 'installment.php';
                        elseif($aria_expand == 'installment_accepted'):
                            include 'installment_accepted.php';    
                        elseif($aria_expand == 'selection'):
                            include 'selection.php';
                        elseif($aria_expand == 'processed'):
                            include 'processed_list.php';
                        elseif($aria_expand == 'bulk'):
                            include 'bulk_student_admission.php';
                        endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

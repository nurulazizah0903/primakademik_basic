<!-- start page title -->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title"> <i class="mdi mdi-view-dashboard title_icon"></i> <?php echo get_phrase('dashboard'); ?> - <?= $this->db->get_where('schools', 'id = '.school_id())->first_row()->name ?> </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>
<!-- end page title -->

<!-- start page title -->
<div class="row ">
  <div class="col-xl-6">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title"><?php echo get_phrase('welcome'); ?> </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
  <div class="col-xl-6">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title"><a href="<?php echo site_url('apd/registration/create'); ?>" style="color: #6c757d;">Ke Halaman PPDB  <i class = "mdi mdi-export"></i></a> </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>
<!-- end page title -->
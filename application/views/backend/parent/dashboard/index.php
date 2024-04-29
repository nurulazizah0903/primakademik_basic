<?php 
$student_lists = $this->user_model->get_student_list_of_logged_in_parent();
$profile_data = $this->user_model->get_profile_data();
$achievement = $this->crud_model->get_achievements_point__by_student_id($student_lists[0]['id']);
$violations = $this->crud_model->get_violations_point__by_student_id($student_lists[0]['id']);
$routine_counseling = $this->db->get_where('routine_counseling', array('student_id' => $student_lists[0]['id']))->result_array();

$tgl = strtotime(date('m/d/Y'));
$this->db->where('school_id', school_id());
$this->db->where('section_id', $student_lists[0]['section_id']);
$this->db->where(''.$tgl.' BETWEEN start_date AND finish_date');
$announcements = $this->db->get('announcements')->result_array();
?>
<!-- start page title -->
<div class="row ">
  <div class="col-xl-12 d-print-none">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title"> <i class="mdi mdi-view-dashboard title_icon"></i> <?php echo get_phrase('dashboard'); ?> </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>
<!-- end page title -->

<!-- announcement -->
<?php if (count($announcements) > 0): ?>
<div class="card">
  <div class="card-body">
    <div class="alert alert-warning" role="alert">
      <h4 class="header-title"><?php echo get_phrase('announcement'); ?></h4>
    </div>
      <table width="100%">
          <thead>
              <tr>
              </tr>
          </thead>
          <tbody>
              <?php foreach ($announcements as $announcement): ?>
                  <tr>
                      <td>
                          <?php echo $announcement['name']; ?>
                      </td>
                  </tr>
              <?php endforeach; ?>
          </tbody>
      </table>
  </div>
</div>
<?php else: ?>
  
<?php endif; ?>
<!-- end announcement -->

<div class="row ">
    <div class="col-xl-12">
        <div class="row">
                  <div class="col-lg-4 d-print-none">
                      <div class="card widget-flat" id="profile">
                          <div class="card-body">
                              <div class="float-right">
                                  <i class="mdi mdi-account-multiple widget-icon"></i>
                              </div>
                              <h5 class="text-muted font-weight-normal mt-0" title="Profile Student"> <i class="mdi mdi-account title_icon"></i>  <?php  echo $profile_data ['name']; ?></h5>
                              <div class="box" style="width: 250px;">
                                <div class="js--image-preview" style="background-image: url(<?php echo $this->user_model->get_user_image($this->session->userdata('user_id')); ?>); background-color: #F5F5F5;"></div>
                              </div>
                              <h4><?php echo get_phrase('parent_of'); ?> <?= $student_lists[0]['name']; ?></h4>
                              <table>
                                <tr>
                                  <th><?php echo get_phrase('email'); ?></th>
                                  <th>:</th>
                                  <th><?php echo $student_lists[0]['email']; ?></th>
                                </tr>
                                <tr>
                                  <th><?php echo get_phrase('nisn'); ?></th>
                                  <th>:</th>
                                  <th><?php echo $student_lists[0]['nisn']; ?></th>
                                </tr>
                                <tr>
                                  <th><?php echo get_phrase('nik'); ?></th>
                                  <th>:</th>
                                  <th><?php echo $student_lists[0]['nik']; ?></th>
                                </tr>
                                <tr>
                                  <th><?php echo get_phrase('class'); ?></th>
                                  <th>:</th>
                                  <th><?php echo $student_lists[0]['class_name']; ?></th>
                                </tr>
                                <tr>
                                  <th><?php echo get_phrase('section'); ?></th>
                                  <th>:</th>
                                  <th><?php echo $student_lists[0]['section_name']; ?></th>
                                </tr>
                                <tr>
                                  <th><?php echo get_phrase('address'); ?></th>
                                  <th>:</th>
                                  <th><?php echo $student_lists[0]['address']; ?></th>
                                </tr>
                              </table>
                          </div> <!-- end card-body-->
                      </div> <!-- end card-->
                  </div> <!-- end col--> 
                  <div class="col-lg-4 d-print-none">
                      <div class="card">
                        <div class="card-body">
                          <h4 class="header-title"><?php echo get_phrase('event_calendar');?><a href="<?php echo route('event_calendar'); ?>" style="color: #6c757d;"><i class = "mdi mdi-export"></i></a></h4>
                          <?php include 'event.php'; ?>
                        </div>
                      </div>
                  </div>
                  <div class="col-lg-4 d-print-none">
                      <div class="card">
                        <div class="card-body">
                          <table>
                            <tr>
                              <th><?php echo get_phrase('achievement_points'); ?></th>
                              <th>:</th>
                              <th><?php echo $achievement[0]['point']; ?></th>
                            </tr>
                            <tr>
                              <th><?php echo get_phrase('foul_points'); ?></th>
                              <th>:</th>
                              <th><?php echo $violations[0]['point']; ?></th>
                            </tr>
                          </table>
                          <table border="1">
                            <tr>
                                <th><?php echo get_phrase('date_counseling'); ?></th>
                                <th><?php echo get_phrase('mentor'); ?></th>
                                </tr>
                          </table>
                        </div>
                      </div>
                  </div>
                </div>
            </div>
        </div>
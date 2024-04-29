<?php
    $profile_data = $this->user_model->get_profile_data();
    $student_data = $this->db->get_where('students', array('user_id' => $user_id))->row_array();
    $enroll = $this->db->get_where('enrols', array('student_id' => $student_data['id']))->row_array(); 
    $class = $this->crud_model->get_class_details_by_id($enroll['class_id'])->row_array();
    $section = $this->crud_model->get_section_details_by_id('section',$enroll['section_id'])->row_array();
    $parent_data = $this->db->get_where('parents', array('id' => $student_data['parent_id']))->row_array();
    $parent = $this->db->get_where('users', array('id' => $parent_data['user_id']))->row_array();
    $achievement = $this->crud_model->get_achievements_point__by_student_id($student_data['id']);
    $violations = $this->crud_model->get_violations_point__by_student_id($student_data['id']);
    $routine_counseling = $this->db->get_where('routine_counseling', array('student_id' => $student_data['id']))->result_array();
    $active_session = active_session();

    $tgl = strtotime(date('m/d/Y'));
    $this->db->where('school_id', school_id());
    $this->db->where('section_id', $section['id']);
    $this->db->where(''.$tgl.' BETWEEN start_date AND finish_date');
    $announcements = $this->db->get('announcements')->result_array();

    // $this->db->select('internship_student.id'); 
    $this->db->where('internship_student.student_id', $student_data['id']); 
    $this->db->where('internship_student.school_id', school_id()); 
    $this->db->where('internship.session_id', $active_session); 
    $this->db->join('internship', 'internship_student.internship_id = internship.id'); 
    $internship = $this->db->get('internship_student')->row_array();

    $start_date = date('Y-m-d', $internship['start_date']);
    $end_date = date('Y-m-d', $internship['end_date']);
    $today = date('Y-m-d');
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
                        <table>
                        <tr>
                            <th><?php echo get_phrase('email'); ?></th>
                            <th>:</th>
                            <th><?php echo $profile_data['email']; ?></th>
                        </tr>
                        <tr>
                            <th><?php echo get_phrase('nisn'); ?></th>
                            <th>:</th>
                            <th><?php echo $student_data['nisn']; ?></th>
                        </tr>
                        <tr>
                            <th><?php echo get_phrase('nis'); ?></th>
                            <th>:</th>
                            <th><?php echo $student_data['NIS']; ?></th>
                        </tr>
                        <tr>
                            <th><?php echo get_phrase('nik'); ?></th>
                            <th>:</th>
                            <th><?php echo $profile_data['nik']; ?></th>
                        </tr>
                        <tr>
                            <th><?php echo get_phrase('class'); ?></th>
                            <th>:</th>
                            <th><?php echo $class['name']; ?></th>
                        </tr>
                        <tr>
                            <th><?php echo get_phrase('section'); ?></th>
                            <th>:</th>
                            <th><?php echo $section['name']; ?></th>
                        </tr>
                        <tr>
                            <th><?php echo get_phrase('address'); ?></th>
                            <th>:</th>
                            <th><?php echo $profile_data['address']; ?></th>
                        </tr>
                        </table>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->
            <div class="col-lg-4 d-print-none">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title"><?php echo get_phrase('event_calendar'); ?><a href="<?php echo route('event_calendar'); ?>" style="color: #6c757d;"> <i class = "mdi mdi-export"></i></a></h4>
                        <?php include 'event.php'; ?>
                    </div>
                </div>
                <?php       
                    if($internship != '' OR $internship != FALSE){
                        if(($today >= $start_date) && ($today <= $end_date)){
                ?>
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title"><?php echo get_phrase('internship_attendance'); ?><a href="<?php echo route('internship_attendance'); ?>" style="color: #6c757d;"> <i class = "mdi mdi-export"></i></a></h4>
                        <table>
                            <tr>
                                <th><?php echo get_phrase('company'); ?></th>
                                <th>:</th>
                                <th>
                                    <?php
                                        echo $company = $this->db->get_where('industry_company', array('id' => $internship['company_id']))->row('company_name'); 
                                    ?>
                                </th>
                            </tr>
                            <tr>
                                <th><?php echo get_phrase('date'); ?></th>
                                <th>:</th>
                                <th>
                                    <?php 
                                        echo date('D').', '.date('d').' '.get_phrase(date('F')).' '.date('Y'); 
                                    ?>
                                </th>
                            </tr>
                        </table>
                        <?php
                            $timestamp = strtotime(date('Y-m-d'));

                            $this->db->where('student_id', $student_data['id']);
                            $this->db->where('timestamp', $timestamp);
                            $this->db->where('internship_id', $internship['internship_id']);
                            $attendances = $this->db->get('internship_attendances')->row_array();

                            if($attendances == '' OR $attendances == FALSE){
                        ?>
                            <button class="btn btn-block btn-primary mt-2" onclick="showAjaxModal('<?php echo site_url('modal/popup/dashboard/internship_attendance/'.$internship['student_id'])?>', '<?php echo get_phrase('attendance'); ?>');"><?php echo get_phrase('attendance'); ?></button>
                        <?php
                            } else {
                        ?>
                            <button class="btn btn-block btn-primary mt-2" disabled><?php echo get_phrase('already_attend'); ?></button>
                        <?php
                            }
                        ?>
                    </div>
                </div>
                <?php
                        } 
                    } 
                ?>
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
                                <th><?php echo get_phrase('status'); ?></th>
                            </tr>
                            <?php 
                            foreach ($routine_counseling as $counseling):
                                $teacher_detail = $this->user_model->get_user_details($counseling['teacher_id']);
                                ?>
                            <tr>
                                <td>
                                    <?php echo date('D, d/M/Y', $counseling['date']); ?>
                                </td>
                                <td><?= $teacher_detail['name'];?></td>
                                <td>
                                    <?php if ($counseling['status'] == 1): ?>
                                        <i class="mdi mdi-circle text-success"></i> <?php echo get_phrase('counseling_finish'); ?>
                                    <?php else: ?>
                                        <i class="mdi mdi-circle text-disable"></i> <?php echo get_phrase('not_yet_counseling'); ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="card widget-flat">
              <div class="card-body">
                <h4 class="header-title">
                    <div class="alert alert-danger" role="alert">
                    <?php echo get_phrase('books_to_be_returned'); ?>
                    </div>
                </h4>
                    <?php
                    $teacher_data = $this->user_model->get_profile_data();
                    $this->db->where('return_date <=', date('m/d/Y'));
                    $this->db->where('user_id', $teacher_data['id']);
                    $book_issues = $this->db->get('book_issues')->result_array();
                    ?>
                    <?php if (count($book_issues) > 0): ?>
                        <table class="table table-striped dt-responsive nowrap" width="100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th><?php echo get_phrase('book_name'); ?></th>
                                    <th><?php echo get_phrase('issue_date'); ?></th>
                                    <th><?php echo get_phrase('return_date'); ?></th>
                                    <th><?php echo get_phrase('status'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($book_issues as $book_issue):
                                    $book_details = $this->crud_model->get_book_by_id($book_issue['book_id']);
                                    ?>
                                    <tr>
                                    <td><a href="javascript:void(0);" onclick="largeModal('<?php echo site_url('modal/popup/book/detail/'.$book_issue['book_id'])?>', '<?php echo $this->db->get_where('schools', array('id' => $school_id))->row('name'); ?>')"><?php echo $book_details['name']; ?></a></td>
                                        <td>
                                            <?php echo date('D, d/M/Y', $book_issue['issue_date']); ?>
                                        </td>
                                        <td>
                                            <?php echo date('D, d/M/Y', strtotime($book_issue['return_date'])); ?>
                                        </td>
                                        <td>
                                            <i class="mdi mdi-circle text-danger"></i> <?php echo get_phrase('terlambat'); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                    <?php include APPPATH.'views/backend/empty.php'; ?>
                    <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    initDataTable("expense-datatable");
});
</script>
<?php
$teacher_id = $this->db->get_where('teachers', array('user_id' => $this->session->userdata('user_id')))->row_array()['id'];
$permission = $this->db->get_where('teacher_permissions', array('teacher_id' => $teacher_id, 'homeroom' => 1))->result_array();    
$profile_data = $this->user_model->get_profile_data();
$school_id = school_id();
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
<?php
  $announcements = $this->crud_model->get_announcements();
  ?>
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
              <div class="card widget-flat" id="class">
                <div class="card-body">
                  <div class="float-right">
                    <i class="mdi mdi-account-multiple widget-icon"></i>
                  </div>
                  <h5 class="text-muted font-weight-normal mt-0" title="Number of Class"> <i class="mdi mdi-account-group title_icon"></i>  <?php echo get_phrase('class'); ?> <a href="<?php echo route('class'); ?>" style="color: #6c757d; display: none;" id = "class_list"><i class = "mdi mdi-export"></i></a></h5>
                    <h3 class="mt-3 mb-3">
                        <?php
                        $current_session_students = $this->crud_model->get_classes();
                        echo $current_session_students->num_rows();
                      ?>
                    </h3>
                  <p class="mb-0 text-muted">
                    <span class="text-nowrap"><?php echo get_phrase('total_kelas'); ?></span>
                  </p>
                </div>
              </div>
              <?php
                $this->db->where('teacher_id', $profile_data['id']);
                $this->db->where('status', 0);
                $this->db->where('deadline >=', strtotime(date('m/d/Y')));
                $this->db->where('school_id', $school_id);
                $assignments = $this->db->get('assignments')->result_array();
                if (count($assignments) > 0) { ?>

                <div class="card widget-flat" id="class" >
                  <div class="card-body">
                    <div class="float-right">
                      <i class="mdi mdi-book widget-icon"></i>
                    </div>
                    <h5 class="text-muted font-weight-normal mt-0" title="Tugas"> <?php echo get_phrase('assignment'); ?> (<?php echo get_phrase('incomplete_mark_value'); ?>)</h5>
                        <table class="table table-striped dt-responsive nowrap py-0 my-0">
                          <tbody>
                            <?php foreach($assignments as $assignment): 
                                $assignment_type = $this->db->get_where('assignment_types', array('id' => $assignment['assignment_types_id']))->row_array();
                            ?>
                                <tr>
                                    <td><?php echo $assignment_type['name']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                          </tbody>
                        </table>
                  </div>
                </div>

              <?php } else { ?>

              <?php } ?>
              
            </div>
            <div class="col-lg-4 d-print-none">
              <div class="card widget-flat" id="student" >
                  <div class="card-body">
                    <div class="float-right">
                      <i class="mdi mdi-account-multiple widget-icon"></i>
                    </div>
                    <h5 class="text-muted font-weight-normal mt-0" title="Number of Student"> <i class="mdi mdi-account-group title_icon"></i>  <?php echo get_phrase('students'); ?> <a href="<?php echo route('student'); ?>" style="color: #6c757d; display: none;" id = "student_list"><i class = "mdi mdi-export"></i></a></h5>
                    <h3 class="mt-3 mb-3">
                    <?php
                    $current_session_students = $this->user_model->get_session_wise_student();
                    echo $current_session_students->num_rows();
                    ?>
                    </h3>
                    <p class="mb-0 text-muted">
                      <span class="text-nowrap"><?php echo get_phrase('total_number_of_student'); ?></span>
                    </p>
                  </div> <!-- end card-body-->
                </div> <!-- end card-->   
                <?php
                  $this->db->where('teacher_id', $profile_data['id']);
                  $this->db->where('status', 0);
                  $this->db->where('deadline >=', strtotime(date('m/d/Y')));
                  $this->db->where('school_id', $school_id);
                  $exams = $this->db->get('exam_students')->result_array();
                  if (count($exams) > 0) { ?> 

                  <div class="card widget-flat" id="class" >
                    <div class="card-body">
                      <div class="float-right">
                        <i class="mdi mdi-book widget-icon"></i>
                      </div>
                      <h5 class="text-muted font-weight-normal mt-0" title="Ujian"><?php echo get_phrase('exam_students'); ?> (<?php echo get_phrase('incomplete_mark_value'); ?>)</h5>
                          <?php
                            $this->db->where('teacher_id', $profile_data['id']);
                            $this->db->where('status', 0);
                            $this->db->where('deadline >=', strtotime(date('m/d/Y')));
                            $this->db->where('school_id', $school_id);
                            $exams = $this->db->get('exam_students')->result_array();
                          ?>
                          <table class="table table-striped dt-responsive nowrap py-0 my-0">
                            <tbody>
                              <?php foreach($exams as $exam): 
                                  $exam_type = $this->db->get_where('exam_types', array('id' => $exam['exam_types_id']))->row_array();
                              ?>
                                  <tr>
                                      <td><?php echo $exam_type['name']; ?></td>
                                  </tr>
                              <?php endforeach; ?>
                            </tbody>
                          </table>
                    </div>
                  </div>
                <?php } else { ?>

                <?php } ?>
            </div> <!-- end col-->
            <div class="col-lg-4 d-print-none">
                <div class="card widget-flat" id="profile" >
                    <div class="card-body">
                        <h5 class="text-muted font-weight-normal mt-0" title="Profile Student"> <i class="mdi mdi-account title_icon"></i>  <?php  echo $profile_data ['name']; ?></h5>
                        <div class="box" style="width: 250px;">
                          <div class="js--image-preview" style="background-image: url(<?php echo $this->user_model->get_user_image($this->session->userdata('user_id')); ?>); background-color: #F5F5F5;"></div>
                        </div>
                        <p class="mb-0 text-muted">
                          <?php
                          if (!empty($permission)) { ?>
                            <span class="text-nowrap"><?php echo get_phrase('homeroom'); ?>  <?php echo $this->db->get_where('classes', array('id' => $permission[0]['class_id']))->row('name'); ?>  <?php echo $this->db->get_where('sections', array('id' => $permission[0]['section_id']))->row('name'); ?></span><br>
                          <?php  
                          }
                          ?>
                            <span class="text-nowrap"><?php echo $profile_data['email']; ?></span><br>
                            <span class="text-nowrap"><?php echo $profile_data['phone']; ?></span>
                        </p>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div>
        <div class="row">
          <div class="col-lg-12">
            <?php
            $teacher_id = $this->db->get_where('teachers', array('user_id' => $this->session->userdata('user_id')))->row_array()['id'];
            ?>
            <div class="card widget-flat" >
              <div class="card-body">
                <h4 class="page-title"><i class="mdi mdi-calendar-today title_icon"></i> <?php echo get_phrase('teaching_schedule'); ?></h4>
                <div class="card-body class_routine_content">
                  <div class="table-responsive">
                  <?php $this->load->view('backend/teacher/schedule/list'); ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <div class="card widget-flat" >
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
                <div class="table-responsive">
                  <table class="table table-striped dt-responsive" width="100%">
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
                </div>
              <?php else: ?>
              <?php include APPPATH.'views/backend/empty.php'; ?>
              <?php endif; ?>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
<!-- schedule -->
<script>
$('document').ready(function(){
    getFilteredClassRoutine();
});

var getFilteredClassRoutine = function() {
	var teacher_id = "<?= $teacher_id; ?>";
	if (teacher_id != "") {
		$.ajax({
			url: '<?php echo route('schedule/filter/') ?>'+teacher_id,
			success: function(response){
				$('.class_routine_content').html(response);
			}
		});
	}
}
</script>
<!-- /schedule -->
<script>
$(document).ready(function() {
    initDataTable("expense-datatable");
});
</script>
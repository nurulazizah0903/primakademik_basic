<?php
$school_id = school_id();
$alumni = $this->alumni_model->get_alumni()->result_array();
if (count($alumni) > 0): ?>
<div class="table-responsive">
<table id="basic-datatable" class="table table-striped dt-responsive" width="100%">
  <thead>
    <tr style="background-color: #313a46; color: #ababab;">
      <th><?php echo get_phrase('image'); ?></th>
      <th><?php echo get_phrase('name'); ?></th>
      <th><?php echo get_phrase('class'); ?></th>
      <th><?php echo get_phrase('section'); ?></th>
      <th><?php echo get_phrase('enter_session'); ?></th>
      <th><?php echo get_phrase('passing_session'); ?></th>
      <th><?php echo get_phrase('options'); ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($alumni as $alumnus): 
      $enrolData = $this->db->get_where('enrols', array('student_id' => $alumnus['student_id']))->row_array();
      $studentData = $this->db->get_where('students', array('id' => $alumnus['student_id']))->row_array();
      $userData = $this->db->get_where('users', array('id' => $studentData['user_id']))->row_array();
      ?>
      <tr>
        <td>
          <img class="rounded-circle" width="50" height="50" src="<?php echo $this->alumni_model->get_alumni_image($alumnus['id']); ?>">
        </td>
        <td>
          <a href="javascript:void(0);" onclick="largeModal('<?php echo site_url('modal/popup/alumni/profile/'.$alumnus['id'])?>', '<?php echo get_phrase('alumni_profile'); ?>')"><?php echo $alumnus['name']; ?><br></a>
          <small> <strong><?php echo get_phrase('nis'); ?> : </strong> <?php echo null_checker($studentData['NIS']); ?> </small>
        </td>
        <td>
        <?php
          echo $this->db->get_where('classes', array('id' => $enrolData['class_id']))->row('name');
        ?>
        </td>
        <td>
        <?php
          echo $this->db->get_where('sections', array('id' => $enrolData['section_id']))->row('name');
        ?>
        <td>
          <?php
            $session_details = $this->crud_model->get_session($alumnus['session2'])->row_array();
            echo $session_details['name'];
          ?>
        </td>
        <td>
          <?php
            $session_details = $this->crud_model->get_session($alumnus['session1'])->row_array();
            echo $session_details['name'];
          ?>
        </td>
        <td>
          <div class="dropdown text-center">
            <button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
            <div class="dropdown-menu dropdown-menu-right">
              <!-- item-->
              <!-- <a href="<?php echo base_url('uploads/alumni_file/'.$alumnus['file']); ?>" class="dropdown-item" download><?php echo get_phrase('download_raport'); ?></a> -->
              <!-- item-->
              <a href="javascript:void(0);" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/alumni/edit/'.$alumnus['id'])?>', '<?php echo get_phrase('update_alumni'); ?>');"><?php echo get_phrase('edit'); ?></a>
              <!-- item-->
              <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo site_url('addons/alumni/delete/'.$alumnus['id']); ?>', showAllAlumni)"><?php echo get_phrase('delete'); ?></a>
            </div>
          </div>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>
<?php else: ?>
  <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>

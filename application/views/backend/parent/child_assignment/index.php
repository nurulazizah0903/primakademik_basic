<?php $student_lists = $this->user_model->get_student_list_of_logged_in_parent();?>
<!--title-->

<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-format-list-numbered title_icon"></i> <?php echo get_phrase('child_assignment'); ?>
        </h4>
      </div> <!-- end car~d body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="row mt-3">
        <div class="col-md-4 mb-1"></div>
        <div class="col-md-3 mb-1">
          <select name="student_id" id="student_id" name="student_id" class="form-control select2" data-toggle="select2" required>
            <option value=""><?php echo get_phrase('select_a_student'); ?></option>
            <?php foreach ($student_lists as $student_list): ?>
              <option value="<?php echo $student_list['id']; ?>"><?php echo $student_list['name']; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-2">
          <button class="btn btn-block btn-secondary" onclick="filter_raport()" ><?php echo get_phrase('filter'); ?></button>
        </div>
      </div>
      <div class="card-body child_assignment_content">
        <?php include 'list.php'; ?>
      </div>
    </div>
  </div>
</div>

<script>

$('document').ready(function(){
  initSelect2(['#student_id']);
});
function filter_raport(){
    var student_id = $('#student_id').val();
    if(student_id != ""){
        $.ajax({
            type: 'POST',
            url: '<?php echo route('child_assignment/filter/') ?>',
            data: {student_id : student_id},
            success: function(response){
                $('.child_assignment_content').html(response);
            }
        });
    }else{
        toastr.error('<?php echo get_phrase('please_select_in_all_fields !'); ?>');
    }
}
</script>
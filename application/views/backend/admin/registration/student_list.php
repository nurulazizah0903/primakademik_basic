<style>
    input[type=checkbox] {
    transform: scale(1.5);
}
</style>
<?php
$school_id = school_id();
$this->db->where('school_id', $school_id);
$this->db->where('status', 'Accepted');
$registrations = $this->db->get('registrations')->result_array();
if (count($registrations) > 0): ?>
<div class="card-body student_list">
<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
    <thead>
        <tr style="background-color: #313a46; color: #ababab;">
            
            <th><?php echo get_phrase('kode_registrasi'); ?></th>
            <th><?php echo get_phrase('name'); ?></th>
            <th><?php echo get_phrase('ket'); ?></th>
            <th><?php echo get_phrase('options'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach($registrations as $item){ ?>
            <tr>
                <td>
                    <a href="javascript:void(0);" onclick="largeModal('<?php echo site_url('modal/popup/registration/profile/'.$item['id'])?>')">
                        <?php echo $item['kode_registrasi']; ?>
                    </a>
                </td>
                <td>
                    <?php echo $item['nama_lengkap']; ?>
                </td>
                <td>
                    <?php echo $item['ket']; ?>
                </td>
                <td>
                    <div class="dropdown text-center">
                        <button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/registration/edit/'.$item['id'].'/'.'admitted'); ?>', '<?php echo get_phrase('update_registration'); ?>')"><?php echo get_phrase('edit'); ?></a>
                            <!-- item -->
                            <a href="javascript:void(0);" class="dropdown-item" onclick="largeModal('<?php echo site_url('modal/popup/registration/enroll/'.$item['id']); ?>', '<?php echo get_phrase('update_registration'); ?>')"><?php echo get_phrase('atur_kelas_siswa'); ?></a>
                        </div>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
</div>

<?php else: ?>
    <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>

<script type="text/javascript">

$(document).ready(function() {
    $("#checkedAll").change(function() {
        if (this.checked) {
            $(".checkSingle").each(function() {
                this.checked=true;
            });
        } else {
            $(".checkSingle").each(function() {
                this.checked=false;
            });
        }
    });
});


var validated = false;
var action = "";
function validation(id) {
  action = id;
  location.reload();
  if (action == "submit_move") {
    if ($('#move_session_id').val() == "" || $('#move_class_id').val() == "" || $('move_section_id').val() == "") {
      validated = false;
      toastr.error('<?php echo get_phrase('please_select_the_fields'); ?>');
    } else {
      validated = true;
      location.reload();
    }
  } else {
    validated = true;
    location.reload();
  }
  location.reload();
}

var form;
$(".ajaxForm").submit(function(e) {
  e.preventDefault();
  form = $(this);
  if(validated) {
    var add = {action:action};
    ajaxSubmit(e, form, refreshForm, add);
  }
});
var refreshForm = function () {
    showAllStudents();
}

</script>
<style>
    input[type=checkbox] {
    transform: scale(1.5);
}
</style>
<?php
$school_id = school_id();
$this->db->where('school_id', $school_id);
$this->db->where('status', 'Not Yet Paid');
$registrations = $this->db->get('registrations')->result_array();
// if($registrations->num_rows() > 0):
if (count($registrations) > 0): ?>
    <div class="card-body student_list">
        <div class="row justify-content-md-center" style="margin-bottom: 10px;">
            <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 mb-3 mb-lg-0">
                <a type="button" class="btn btn-icon btn-primary" href="<?php echo route('export_ppdb/'.'Not Yet Paid'); ?>"><?php echo get_phrase('export_semua_data'); ?></a>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 mb-3 mb-lg-0">
                <a type="button" class="btn btn-icon btn-primary" href="<?php echo route('export_multimedia/'.'Not Yet Paid'); ?>"><?php echo get_phrase('export_jurusan_Multimedia'); ?></a>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 mb-3 mb-lg-0">
                <a type="button" class="btn btn-icon btn-primary" href="<?php echo route('export_akuntansi/'.'Not Yet Paid'); ?>"><?php echo get_phrase('export_jurusan_Akuntansi'); ?></a>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 mb-3 mb-lg-0">
                <a type="button" class="btn btn-icon btn-primary" href="<?php echo route('export_ap/'.'Not Yet Paid'); ?>"><?php echo get_phrase('export_jurusan_Administrasi_Perkantoran'); ?></a>
            </div>
        </div>
        <form method="POST" action="<?= route('export_ppdb_by_id') ?>" class="ajaxForm" id="delete_student">
        <table id="basic-datatable" class="table table-striped dt-responsive" width="100%">
            <thead>
                <tr style="background-color: #313a46; color: #ababab;">
                    <!-- <th><input type="checkbox"  id="checkedAll"> <?php echo get_phrase('all'); ?></th> -->
                    <th><?php echo get_phrase('kode_registrasi'); ?></th>
                    <th><?php echo get_phrase('name'); ?></th>
                    <th><?php echo get_phrase('jurusan'); ?></th>
                    <th><?php echo get_phrase('ket'); ?></th>
                    <th><?php echo get_phrase('options'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($registrations as $item){ ?>
                    <tr>
                        <!-- <td><center><input type="checkbox" name="enrol_ids[]" class="checkSingle" value="<?= $item['id'];?>" data-size="xl"></center></td> -->
                        <td>
                            <a href="javascript:void(0);" onclick="largeModal('<?php echo site_url('modal/popup/registration/edit/'.$item['id'])?>')">
                                <?php echo $item['kode_registrasi']; ?>
                            </a>
                        </td>
                        <td>
                            <?php echo $item['nama_lengkap']; ?>
                        </td>
                        <td>
                            <?php echo $item['jurusan']; ?>
                        </td>
                        <td>
                            <?php echo $item['ket']; ?>
                        </td>
                        <td>
                            <a target="_blank" class="btn btn-info" href="<?php echo route('registration/print_ppdb/'.$item['id']); ?>"><?php echo get_phrase('print'); ?></a>
                            <a target="_blank" class="btn btn-warning mdi mdi-cash-multiple" href="<?php echo route('registration/print_finance/'.$item['id']); ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('kuitansi_ppdb'); ?>"></a>
                            <a href="javascript:void(0);" class="btn btn-success mdi mdi-square-inc-cash" onclick="largeModal('<?php echo site_url('modal/popup/registration/pay/'.$item['id']); ?>', '<?php echo get_phrase('pay'); ?>')" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('pay'); ?>"></a>
                            <a href="javascript:void(0);" class="btn btn-secondary mdi mdi-note-text" onclick="largeModal('<?php echo site_url('modal/popup/registration/history_payment/'.$item['id']); ?>', '<?php echo get_phrase('history_pembayaran'); ?>')" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('history_pembayaran'); ?>"></a>
                            <!-- <a href="javascript:void(0);" class="btn btn mdi mdi-pen" onclick="largeModal('<?php echo site_url('modal/popup/registration/edit/'.$item['id']); ?>', '<?php echo get_phrase('update_registration'); ?>')" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('edit'); ?>"></a> -->
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <!-- <input type="submit" id="delete_student" name="delete_student" onclick="validation(this.id)" class="btn btn-info" value="<?= get_phrase('export') ?>" /> -->
        </form>
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
  if (action == "submit_move") {
    if ($('#move_session_id').val() == "" || $('#move_class_id').val() == "" || $('move_section_id').val() == "") {
      validated = false;
      toastr.error('<?php echo get_phrase('please_select_the_fields'); ?>');
    } else {
      validated = true;
    }
  } else {
    validated = true;
  }
}

var form;
$(".ajaxForm").submit(function(e) {
  e.preventDefault();
  form = $(this);
  if(validated) {
    var add = {action:action};
    ajaxSubmit(e, form, refreshForm, add);
    // location.reload();
  }
});
var refreshForm = function () {
    showAllStudents();
}

</script>
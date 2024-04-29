<style>
    input[type=checkbox] {
    transform: scale(1.5);
}
</style>
<?php
$school_id = school_id();
$this->db->where('school_id', $school_id);
$this->db->where('status', 'Processed');
$registrations = $this->db->get('registrations')->result_array();
if (count($registrations) > 0): ?>
<div class="card-body student_list">
<table id="basic-datatable" class="table table-striped dt-responsive" width="100%">
    <thead>
        <tr style="background-color: #313a46; color: #ababab;">
            
            <th><?php echo get_phrase('kode_registrasi'); ?></th>
            <th><?php echo get_phrase('name'); ?></th>
            <th><?php echo get_phrase('status'); ?></th>
            <th><?php echo get_phrase('ket'); ?></th>
            <th><?php echo get_phrase('bukti_bayar'); ?></th>
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
                <?php echo get_phrase('Processed'); ?>
                </td>
                <td>
                    <?php echo $item['ket']; ?>
                </td>
                <td>
                <a href="<?= base_url();?>uploads/registrations/<?= $item['bukti_bayar']?>" target="_blank" class="btn btn-info"><?php echo get_phrase('see'); ?></a>        
                </td>
                <td>
                <a target="_blank" class="btn btn-info mdi mdi-file-document" href="<?php echo route('registration/print/'.$item['id']); ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('print'); ?>"></a>
                <a href="javascript:void(0);" class="btn btn-success mdi mdi-pen" onclick="showAjaxModal('<?php echo site_url('modal/popup/registration/edit/'.$item['id']); ?>', '<?php echo get_phrase('update_registration'); ?>')" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('edit'); ?>"></a>
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
    location.reload();
  }
});
var refreshForm = function () {
    showAllStudents();
}

</script>
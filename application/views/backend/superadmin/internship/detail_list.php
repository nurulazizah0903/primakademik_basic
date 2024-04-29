<?php
    $school_id = school_id();
    $this->db->select('users.name AS nama_student, internship_student.id AS internship_student_id');
    $this->db->where('internship_student.school_id', $school_id);
    $this->db->where('internship_student.internship_id', $param1);
    $this->db->join('students', 'internship_student.student_id = students.id');
    $this->db->join('users', 'students.user_id = users.id');
    $data = $this->db->get('internship_student')->result_array();
?>
<div class="h-100">
    <div class="row align-items-center h-100">
        <div class="col-md-12">
            <div class="table-responsive-sm">
                <form method="POST" class="d-block ajaxForm" action="<?php echo route('internship/add_student'); ?>">
                <table id="example" class="table table-striped dt-responsive nowrap" width="100%">
                <thead class="thead-dark">
                    <tr>
                        <th><?php echo get_phrase('student_name'); ?></th>
                        <th style="text-align:center;">
                            <a href="#" class="add-student btn-info" onclick="appendRow()"><i class="mdi mdi-plus-box-outline" style="font-size:23px;"></i></a>
                        </th>
                    </tr>
                </thead>
                <tbody class="students_list">

                    <?php
                        foreach ($data as $dt) {
                    ?>
                        <tr id="<?= $dt['internship_student_id'] ?>" class="first_row">
                            <td>
                                <?= $dt['nama_student'] ?>
                            </td>
                            <td style="text-align:center;">
                                <a href="#" class="delete-student"><i class="mdi mdi-delete-sweep-outline" style="font-size:23px;"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                            <tr class="blank_row" style="display:none;">
                                <!-- <input type="hidden" name="school_id" value="<?php echo school_id(); ?>"> -->
                                <input type="hidden" name="internship_id" value="<?php echo $param1; ?>">
                                <td>
                                    <select class="form-control select2 student" name="student_internship[]">
                                        <option value=""><?php echo get_phrase('select_student'); ?></option>>
                                        <?php $students = $this->db->get_where('students', array('school_id' => $school_id))->result_array(); ?>
                                        <?php foreach($students as $student){ ?>
                                            <option value="<?php echo $student['id']; ?>"><?php echo $this->db->get_where('users', array('id' => $student['user_id']))->row('name'); ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td style="text-align:center; color:red;">
                                    <a href="#" class="delete-listed" onclick="removeRow(this)"><i class="mdi mdi-playlist-remove" style="font-size:23px;"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>    
                </form>
            </div>            
        </div>
    </div>
</div>
<script>
    $(".ajaxForm").submit(function(e) {
        var form = $(this);
        ajaxSubmit2(e, form, showAllInternship);
        largeModal('<?php echo site_url('modal/popup/internship/detail_list/'.$param1)?>');
    });

    $(".delete-student").on("click", function(){
        var internship_id = $(this).closest('tr').attr('id');
        var url = '<?php echo route('internship/delete_student'); ?>';

        $.ajax({
            type : 'POST',
            url: url,
            data : {id: internship_id},
            success : function(response) {
                // console.log(response);
                largeModal('<?php echo site_url('modal/popup/internship/detail_list/'.$param1)?>');
                // window.location.href = newUrl;
                // location.reload();
            }
        });

        // console.log(trid);
    });

    var blank_field = $('.blank_row').html();
    var row = 1;
    function appendRow() {
        // console.log(row);
        $('tbody.students_list').append('<tr class="student_listed">'+blank_field+'</tr>');
        row++;
        $('.student').attr('id', 'student_id'+row);

        $('#student_id' + row, '.student_listed').select2();
        // $('#student_id').select2();
        if(row == '2'){
            $('.ajaxForm').append('<button class="btn btn-block btn-primary btn-submit" type="submit"><?php echo get_phrase("add_internship"); ?></button>');
        }
    }    

    $(document).ready(function () {
        initSelect2(['.student']);
        $('.student').select2();
    });

    function removeRow(elem) {
        if(row == '2'){
            $('.btn-submit').remove();
        }
        $(elem).closest('.student_listed').remove();
        row--;
    }

    if($('div').hasClass('modal-dialog') == true){
        $('div').attr('tabindex', "");
        // $(function(){$(".select2").select2()});
    }
</script>
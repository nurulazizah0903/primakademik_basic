<?php $school_id = school_id(); ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('book_issue/add'); ?>">
    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="issue_date"><?php echo get_phrase('issue_date'); ?></label>
        <div class="col-md-9">
            <input type="text" class="form-control date" id="issue_date" data-toggle="date-picker" data-single-date-picker="true" name = "issue_date" value="" required>
        </div>
    </div>

    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="return_date"><?php echo get_phrase('return_date'); ?></label>
        <div class="col-md-9">
            <input type="text" value="<?php echo date('m/d/Y'); ?>" class="form-control" id="return_date" name = "return_date" data-provide = "datepicker" required>
            </div>
    </div>

    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="role"><?php echo get_phrase('role'); ?></label>
        <div class="col-md-9">
            <select name="role" id="role" class="form-control select2"  required onchange="roleWiseOnCreate(this.value)">
                <option value=""><?php echo get_phrase('select_role'); ?></option>
                <option value="teacher" ><?php echo get_phrase('teacher'); ?></option>
                <option value="accountant"><?php echo get_phrase('accountant'); ?></option>
                <option value="other_employee"><?php echo get_phrase('other_employee'); ?></option>
                <option value="student"><?php echo get_phrase('student'); ?></option>
            </select>
        </div>
    </div>

    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="user_id"> <?php echo get_phrase('name'); ?></label>
        <div class="col-md-9">
        <select name="user_id" id="user_id" class="form-control select2" required >
            <option value=""><?php echo get_phrase('select_a_name'); ?></option>
        </select>
        </div>
    </div>

    <div id = "first-row">
        <div class="form-group row mb-3">
            <label class="col-md-3 col-form-label" for="book_id"> <?php echo get_phrase('book'); ?></label>
            <div class="col-md-6">
                <select name="book_id[]" id="book_on_create" class="form-control select2"  data-toggle = "select2" required>
                    <option value=""><?php echo get_phrase('select_book'); ?></option>
                    <?php
                    $books = $this->crud_model->get_books()->result_array();
                    foreach ($books as $book): 
                        $number_of_issued_book = $this->crud_model->get_number_of_issued_book_by_id($book['id']);
                        $total = $book['copies'] - $number_of_issued_book;
                        if ($total >= 1) { ?>
                            <option value="<?php echo $book['id']; ?>"><?php echo $book['book_code']; ?> - <?php echo $book['name'];?></option>
                    <?php } else {
                    }
                    ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-icon btn-success" onclick="appendRow()"> <i class="mdi mdi-plus"></i> </button>
            </div>
        </div>
    </div>

    <div class="form-group  col-md-12">
        <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('save_book_issue_info'); ?></button>
    </div>
</form>

<div id = "blank-row" style="display: none;">
        <div class="student-row">
            <div class="form-group row mb-3">
                <label class="col-md-3 col-form-label" for="book_id"> <?php echo get_phrase('book'); ?></label>
                <div class="col-md-6">
                    <input list="books"  class="form-control" name="book_id[]" placeholder="<?php echo get_phrase('select_book'); ?>" id="book_id">
                    <datalist id="books">
                        <?php
                        $books = $this->crud_model->get_books()->result_array();
                        foreach ($books as $book): 
                            $number_of_issued_book = $this->crud_model->get_number_of_issued_book_by_id($book['id']);
                            $total = $book['copies'] - $number_of_issued_book;
                            if ($total >= 1) { ?>
                                <option value="<?php echo $book['id']; ?>"><?php echo $book['book_code']; ?> - <?php echo $book['name'];?></option>
                        <?php } else {
                        }
                        ?>
                        <?php endforeach; ?>
                    </datalist>
                    <!-- <select name="book_id[]" class="form-control select2"  data-toggle = "select2" required>
                        <option value=""><?php echo get_phrase('select_book'); ?></option>
                        <?php
                        $books = $this->crud_model->get_books()->result_array();
                        foreach ($books as $book): 
                            $number_of_issued_book = $this->crud_model->get_number_of_issued_book_by_id($book['id']);
                            $total = $book['copies'] - $number_of_issued_book;
                            if ($total >= 1) { ?>
                                <option value="<?php echo $book['id']; ?>"><?php echo $book['book_code']; ?> - <?php echo $book['name'];?></option>
                        <?php } else {
                        }
                        ?>
                        <?php endforeach; ?>
                    </select> -->
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-icon btn-danger" onclick="removeRow(this)"> <i class="mdi mdi-window-close"></i> </button>
                </div>
            </div>
        </div>
    </div>

<script>
var blank_field = $('#blank-row').html();
var row = 1;

function appendRow() {
    $('#first-row').append(blank_field);
    row++;
}

function removeRow(elem) {
    $(elem).closest('.student-row').remove();
    row--;
}

$(document).ready(function() {
    $('#issue_date').daterangepicker();
});

$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
  var form = $(this);
  ajaxSubmit2(e, form, showAllBookIssues);
});

$(document).ready(function () {
  initSelect2(['#role', '#user_id', '#book_id_on_modal']);
});

function roleWiseOnCreate(role) {
    $.ajax({
        url: "<?php echo route('book_issue/role/'); ?>"+role,
        success: function(response){
            // console.log(response);
            $('#user_id').html(response);
            // classWiseStudent(role);
        }
    });
}

$(function(){
        $('.select2').select2();
    });

if($('select').hasClass('select2') == true){
    $('div').attr('tabindex', "");
    $(function(){$(".select2").select2()});
}

function classWiseStudentOnCreate(sectionId) {
  $.ajax({
    url: "<?php echo route('book_issue/student/'); ?>"+sectionId,
    success: function(response){
      $('#student_id_on_modal').html(response);
    }
  });
}
</script>
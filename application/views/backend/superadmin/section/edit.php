<?php $school_id = school_id(); ?>
<?php $sections = $this->db->get_where('sections', array('id' => $param1))->result_array(); ?>
<?php foreach($sections as $section){ ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('section/update/'.$param1); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="class"><?php echo get_phrase('class'); ?></label>
            <select name="class_id" id="class_id_on_create" class="form-control select2" data-toggle="select2" required>
                <option value=""><?php echo get_phrase('select_a_class'); ?></option>
                    <?php
                        $classes = $this->db->get_where('classes', array('school_id' => $school_id))->result_array();
                        foreach($classes as $class){
                    ?>
                        <option value="<?php echo $class['id']; ?>" <?php if($class['id'] == $section['class_id']){ echo 'selected'; } ?>><?php echo $class['name']; ?></option>
                    <?php } ?>
            </select>
        </div>

        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('section'); ?></label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $section['name']; ?>" required>
        </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('create_section'); ?></button>
        </div>
    </div>
</form>
<?php } ?>

<script>
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
  var form = $(this);
  ajaxSubmit(e, form, showAllSections);
});

$(document).ready(function() {
  initSelect2(['#class_id_on_create']);
});
</script>

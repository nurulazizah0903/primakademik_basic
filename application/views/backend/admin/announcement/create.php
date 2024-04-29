<form method="POST" class="d-block ajaxForm" action="<?php echo route('announcement/create'); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="announcement_name"><?php echo get_phrase('announcement_name'); ?></label>
            <textarea class="form-control" id="name" name = "name" placeholder="<?php echo get_phrase('announcement_name'); ?>" required cols="5" rows="5"></textarea>
        </div>

        <div class="form-group col-md-12">
            <label for="date"><?php echo get_phrase('date'); ?></label>
            <input type="text" value="<?php echo date('m/d/Y'); ?>" class="form-control" id="date" name = "date" data-provide = "datepicker" required>
        </div>

        <div class="form-group col-md-12">
            <label for="date"><?php echo get_phrase('section'); ?></label><br>
            <input type="checkbox"  id="checkedAll"> <?php echo get_phrase('select_all'); ?><br>
            <?php $classes = $this->db->get_where('classes', array('school_id' => school_id()))->result_array(); ?>
            <?php foreach($classes as $class){ 
                $sections = $this->db->get_where('sections', array('class_id' => $class['id']))->result_array();
            ?>
            <h6><?php echo $class['name']; ?></h6>
                <?php foreach($sections as $section){  ?>
                    <input type="checkbox" class="checkSingle" name="section_id[]" id="section_id" value="<?php echo $section['id']; ?>">
                    <label><?php echo $section['name']; ?></label><br>
                <?php } ?>
            <?php } ?>
        </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('create_announcement'); ?></button>
        </div>
    </div>
</form>

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

    $(".ajaxForm").validate({}); // Jquery form validation initialization
    $(".ajaxForm").submit(function(e) {
        var form = $(this);
        ajaxSubmit(e, form, showAllAnnouncements);
    });
</script>

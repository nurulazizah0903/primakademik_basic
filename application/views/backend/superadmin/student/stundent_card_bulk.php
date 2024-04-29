<form method="POST" class="d-block ajaxForm" action="<?php echo route('student/stundent_card_bulk'); ?>" target="_blank" id = "student_admission_form" enctype="multipart/form-data">
    <div class="row justify-content-md-center">
        <div class="col-md-12 mt-4">
            <div class="form-group">
                <h5 style="font-weight: bold;"> <?php echo get_phrase('class'); ?></h5>
                <select name="room_id" id="room_id" class="form-control select2" data-toggle = "select2" required>
                    <option value=""><?php echo get_phrase('select_class_room'); ?></option>
                    <?php
                    $class_rooms = $this->db->get_where('class_rooms', array('school_id' => school_id()))->result_array();
                    foreach($class_rooms as $class_room){
                        ?>
                        <option value="<?php echo $class_room['id']; ?>"><?php echo $class_room['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
    <table class="table table-centered mb-0">
        <tbody>
            <tr>
                <td style="font-weight: bold;">
                    <input type="radio" class="form-control" name="desain" value="1b.png">
                    <label for="html"><?php echo get_phrase('desain_1'); ?></label><br>
                </td>
                <td>
                    <img src="<?php echo base_url('assets/backend/images/card/1b.png') ?>" style="height: 150px; width: 300px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                    <img src="<?php echo base_url('assets/backend/images/card/1dpn.png') ?>" style="height: 150px; width: 300px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;">
                    <input type="radio" class="form-control" name="desain" value="2b.png">
                    <label for="html"><?php echo get_phrase('desain_2'); ?></label><br>
                </td>
                <td>
                    <img src="<?php echo base_url('assets/backend/images/card/2b.png') ?>" style="height: 150px; width: 300px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                    <img src="<?php echo base_url('assets/backend/images/card/2dpn.png') ?>" style="height: 150px; width: 300px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;">
                    <input type="radio" class="form-control" name="desain" value="3b.png">
                    <label for="html"><?php echo get_phrase('desain_3'); ?></label><br>
                </td>
                <td>
                    <img src="<?php echo base_url('assets/backend/images/card/3b.png') ?>" style="height: 150px; width: 300px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                    <img src="<?php echo base_url('assets/backend/images/card/3dpn.png') ?>" style="height: 150px; width: 300px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;">
                    <input type="radio" class="form-control" name="desain" value="4b.png">
                    <label for="html"><?php echo get_phrase('desain_4'); ?></label><br>
                </td>
                <td>
                    <img src="<?php echo base_url('assets/backend/images/card/4b.png') ?>" style="height: 150px; width: 300px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                    <img src="<?php echo base_url('assets/backend/images/card/4dpn.png') ?>" style="height: 150px; width: 300px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;">
                    <input type="radio" class="form-control" name="desain" value="5b.png">
                    <label for="html"><?php echo get_phrase('desain_5'); ?></label><br>
                </td>
                <td>
                    <img src="<?php echo base_url('assets/backend/images/card/5b.png') ?>" style="height: 150px; width: 300px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                    <img src="<?php echo base_url('assets/backend/images/card/5dpn.png') ?>" style="height: 150px; width: 300px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                </td>
            </tr>
        </tbody>
    </table>
    <div class="text-center">
        <button type="submit" class="btn btn-secondary col-md-12 col-sm-12 mb-4 mt-3"><?php echo get_phrase('stundent_card_bulk'); ?></button>
    </div>
</form>

<script>

$(function(){
        $('.select2').select2();
    });

if($('select').hasClass('select2') == true){
    $('div').attr('tabindex', "");
    $(function(){$(".select2").select2()});
}
</script>
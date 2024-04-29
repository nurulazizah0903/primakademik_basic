<form method="POST" class="d-block ajaxForm" action="<?php echo route('book/create'); ?>" enctype="multipart/form-data">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="book_code"><?php echo get_phrase('kode_buku'); ?></label>
            <input type="number" class="form-control" id="book_code" name = "book_code" required>
        </div>

        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('book_name'); ?></label>
            <input type="text" class="form-control" id="name" name = "name" required>
        </div>

        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('jenis_buku'); ?></label>
            <select name="book_type_id" id="book_id_on_modal" class="form-control select2" required onchange="show_book_type_form(this.value)">
                <option value=""><?php echo get_phrase('select_book_type'); ?></option>
                <?php
                $book_typeis = $this->crud_model->get_book_types()->result_array();
                foreach ($book_typeis as $book_type): ?>
                    <option value="<?php echo $book_type['id']; ?>"><?php echo $book_type['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('book_release'); ?></label>
            <input type="text" placeholder="<?php echo date('Y'); ?>" class="form-control" id="book_release" name = "book_release" required>
        </div>

        <div class="form-group col-md-12">
            <label for="author"><?php echo get_phrase('author'); ?></label>
            <input type="text" class="form-control" id="author" name = "author" required>
        </div>
        
        <div class="form-group col-md-12">
            <label for="publisher"><?php echo get_phrase('publisher'); ?></label>
            <input type="text" class="form-control" id="publisher" name = "publisher" required>
        </div>

        <div class="form-group col-md-12" id="number_of_copy">
            <label for="copies"><?php echo get_phrase('number_of_copy'); ?></label>
            <input type="number" class="form-control" id="copies" name = "copies" min="0" required>
        </div>

        <div class="form-group col-md-12">
            <label for="copies"><?php echo get_phrase('sinopsis'); ?></label>
            <textarea name="summary" class="form-control" id="summary" cols="5" rows="5" required></textarea>
        </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('save_book_info'); ?></button>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
    initSelect2(['#book_id_on_modal']);
    });

    $(function(){
        $('.select2').select2();
    });

if($('select').hasClass('select2') == true){
    $('div').attr('tabindex', "");
    $(function(){$(".select2").select2()});
}

    $(".ajaxForm").validate({});
    $(".ajaxForm").submit(function(e) {
        var form = $(this);
        ajaxSubmit(e, form, showAllBooks);
    });

</script>

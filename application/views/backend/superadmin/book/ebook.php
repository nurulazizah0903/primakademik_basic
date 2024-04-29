<?php $book_details = $this->crud_model->get_book_by_id($book_id); ?>
<p><iframe  width="1000" height="1000" frameBorder="0"
    scrolling="auto" 
    src="<?php echo base_url().'uploads/ebook/'.$book_details['ebook']; ?>">
</iframe></p>
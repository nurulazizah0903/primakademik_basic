<?php
$books = $this->crud_model->get_book_by_id($param1);
$book_types = $this->crud_model->get_book_types_by_id($books['book_type_id']);
?>

<div class="h-100">
    <div class="row align-items-center h-100">
        <div class="col-md-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><?php echo get_phrase('book_data'); ?></a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <table class="table table-centered mb-0">
                        <tbody>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('kode_buku'); ?>:</td>
                                <td><?= $books['book_code']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('book_name'); ?>:</td>
                                <td><?= $books['name']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('jenis_buku'); ?>:</td>
                                <td><?= $book_types['name']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('book_release'); ?>:</td>
                                <td><?= $books['book_release']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('author'); ?>:</td>
                                <td><?= $books['author'];?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('copies'); ?>:</td>
                                <td><?= $books['copies'];?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('sinopsis'); ?>:</td>
                                <td><?= $books['summary'];?></td>
                            </tr>
                            <!-- <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('available_copies'); ?>:</td>
                                <td><?php
                                $number_of_issued_book = $this->crud_model->get_number_of_issued_book_by_id($books['id']);
                                echo $books['copies'] - $number_of_issued_book;
                                ?></td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
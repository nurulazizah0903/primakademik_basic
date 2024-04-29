<?php
$question_banks = $this->db->get_where('question_bank', array('id' => $param1))->row_array();
?>

<div class="h-100">
    <div class="row align-items-center h-100">
        <div class="col-md-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><?php echo get_phrase('question_bank'); ?></a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <table class="table table-centered mb-0">
                        <tbody>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('question'); ?>:</td>
                                <td><?= $question_banks['question']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('level_of_difficulty'); ?>:</td>
                                <td>
                                <?php
                                if ($question_banks['level'] == "mudah") {
                                    echo get_phrase('mudah'); 
                                } elseif ($question_banks['level'] == "sedang") {
                                    echo get_phrase('sedang'); 
                                } elseif ($question_banks['level'] == "sulit") {
                                    echo get_phrase('sulit'); 
                                } 
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('question_type'); ?>:</td>
                                <td>
                                <?php
                                if ($question_banks['question_type'] == "text") {
                                    echo get_phrase('text'); 
                                } elseif ($question_banks['question_type'] == "file") {
                                    echo get_phrase('file'); 
                                } elseif ($question_banks['question_type'] == "choices") {
                                    echo get_phrase('choices'); 
                                } 
                                ?>    
                                </td>
                                <td>
                                <?php
                                if ($question_banks['question_type'] == "choices") {
                                    $choices_array = $question_banks['choices'];
                                    if(!is_null($choices_array)) {
                                        $choices = explode(";", $choices_array);
                                        foreach($choices as $choice){ ?>
                                        <ul>
                                              <li><?= $choice?></li>
                                        </ul>
                                        <?php
                                        }
                                        ?>
                                        <?= get_phrase('correct_choices');?>
                                        <br>
                                        <?= $question_banks['correct_choices'];?>
                                        <?php
                                } else{
                                
                                } 
                            }
                                ?>    
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
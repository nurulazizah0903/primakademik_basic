
<option value=''><?php echo get_phrase('select_a_month'); ?></option>

<?php if ($kategori != 0): ?>
    <?PHP  
    $start = strtotime($label);
    $end = strtotime("+1 year",$start);

    $start2 = strtotime("+".$kategori." month",$start);
    $currentdate = $start2;
    while($currentdate < $end)
    {
            $cur_date = date('F', $currentdate);
            $cur_date2 = date('m', strtotime($cur_date));
    ?> 
            <option value="<?php echo $cur_date; ?>"><?php echo $cur_date; ?></option>
    <?PHP  
            $currentdate = strtotime("+".$kategori." month", $currentdate);
    }
    ?>
<?php else: ?>
  <option value=""><?php echo "Data Tidak Ditemukan"; ?></option>
<?php endif; ?>
 

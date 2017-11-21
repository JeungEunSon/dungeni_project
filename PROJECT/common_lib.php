<?
function get_col_val($array, $table_name, $not_col = array(), $glue = ',') { // 쿼리스트링 가공
    global $con;

    $sql = "desc ".$table_name;
    $result = mysqli_query($con, $sql);
    $desc_col = array();
    while ($row = mysqli_fetch_array($result)) {
        $desc_col[] = $row[0];
    }

    $db_col = array();
    $db_val = array();
    $col_val = array();
    foreach($array as $col => $val) {
        if (in_array($col, $desc_col) && !in_array($col, $not_col)) {
            $db_col[] = $col;
            $db_val[] = $val;

            $col_val[] = addslashes($col).'="'.mysqli_real_escape_string($con,htmlentities(trim($val), ENT_QUOTES | ENT_IGNORE, "utf-8")).'"';
        }
    }
    $col_val = @implode($glue, $col_val);
    return $col_val;
}
?>

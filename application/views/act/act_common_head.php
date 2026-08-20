<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>INTERNAL GRUP</title>
    <link rel="icon" type="image/x-icon" href="<?php echo base_url() . 'assets/icons/favicon.ico'; ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets/css/style_report.css'; ?>" />
</head>

<body>
    <?php
    $lebarhead = isset($lebarhead) && $lebarhead != '' ? $lebarhead : 970;
    include "globalhead.php";

    $table = isset($table) ? $table : '';
    $title = isset($title) ? $title : '';
    ?>
    <div class="printjudul"><?php echo $title; ?></div>
    <?php
    echo $table;
    ?>
</body>

</html>
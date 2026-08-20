<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?php
    $ex = isset($ex) ? $ex : 0;
    if ($ex == 1) {
        $filename = isset($filename) || $filename == '' ? $filename : 'print';
        header("Content-type: application/x-msdownload");
        header("Content-Disposition: attachment; filename=$filename.xls");
    }
    ?>
    <title>INTERNAL GRUP</title>
    <link rel="icon" type="image/x-icon" href="<?php echo base_url() . 'assets/icons/favicon.ico'; ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets/css/style_report.css'; ?>" />
    <style>
        .text {
            mso-number-format: "\@";
            text-align: left !important;
        }
    </style>
</head>

<body>
    <?php
    if ($ex == 1) {
        ?>
        <div class="printjudul" style="padding-top: 200px;"><?php echo $title ?></div>
        <?php
    }
    echo $table;
    ?>
</body>

</html>
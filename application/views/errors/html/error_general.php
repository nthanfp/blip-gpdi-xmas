<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$CI =& get_instance();
if (!isset($CI)) {
    $CI = new CI_Controller();
}
$CI->load->helper('url');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Error</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/fontawesome-free/css/all.min.css'); ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/adminlte.min.css'); ?>">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper d-flex align-items-center justify-content-center" style="min-height: 100vh; background-color: #f4f6f9;">
    <!-- Main content -->
    <section class="content">
        <div class="error-page" style="margin: 0 auto; width: 600px;">
            <h2 class="headline text-danger"> 500</h2>

            <div class="error-content pt-3">
                <h3><i class="fas fa-exclamation-triangle text-danger"></i> Oops! Something went wrong.</h3>

                <p>
                    <strong><?php echo $heading; ?></strong><br>
                    <?php echo strip_tags($message); ?><br><br>
                    Meanwhile, you may <a href="<?php echo base_url(); ?>">return to dashboard</a> or contact support.
                </p>
            </div>
        </div>
        <!-- /.error-page -->
    </section>
    <!-- /.content -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo base_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/js/adminlte.min.js'); ?>"></script>
</body>
</html>
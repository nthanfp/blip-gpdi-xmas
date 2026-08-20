<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Head -->
    <?php $this->load->view('partial/activities/head.php') ?>

    <!-- Additional Style (Global) -->
    <style>
        .content-wrapper {
            position: relative;
            /* background: transparent !important; */
        }

        .content-wrapper::before {
            content: "";
            position: absolute;
            inset: 0;

            background: url('<?= base_url("assets/icons/logo.png") ?>') no-repeat center;
            background-size: 150px;

            opacity: 0.10;
            pointer-events: none;

            z-index: 0;
        }

        .dashboard-card {
            height: 100%;
        }

        .dashboard-card .card-body {
            padding: 0;
        }

        .dashboard-card .table th {
            border-top: 0;
            padding: 10px 12px;
            white-space: nowrap;
        }

        .dashboard-card .table td {
            padding: 8px 12px;
            vertical-align: middle;
            font-size: 13px;
            white-space: nowrap;
        }

        .dashboard-card .chart-wrap {
            padding: 16px;
            height: 310px;
        }

        .dashboard-card .chart-wrap canvas {
            width: 100% !important;
            height: 100% !important;
        }

        .info-box-wrap {
            display: block;
            cursor: pointer;
        }

        .info-box-wrap:hover .info-box {
            filter: brightness(1.08);
        }
    </style>
</head>

<body class="sidebar-mini layout-fixed sidebar-collapse">
    <div class="wrapper">

        <?php $this->load->view('partial/activities/sidebar.php') ?>

        <div class="content-wrapper py-4 px-4 text-sm">
            <div class="row">
            </div>
        </div>

        <!-- Footer -->
        <?php $this->load->view('partial/activities/footer.php') ?>
    </div>

    <!-- Foot (js/library) -->
    <?php $this->load->view('partial/activities/foot.php') ?>

    <script type="text/javascript">
    </script>

</body>

</html>
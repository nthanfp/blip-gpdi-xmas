<!DOCTYPE html>
<html lang="id">

<head>
    <?php $this->load->view('partial/landing/head.php')    ?>
    <style type="text/css">
        html,
        body {
            height: 100dvh;
            overflow: hidden;
        }
    </style>
</head>

<body class="bg-gray-50 flex justify-center">
    <div class="w-full relative flex flex-col justify-center items-center px-5" style="height:100dvh">

        <!-- Card -->
        <div class="w-full max-w-sm bg-white border border-gray-200 rounded-2xl p-8 text-center shadow-sm">
            <div class="w-14 h-14 mx-auto mb-4 rounded-xl bg-gray-100 flex items-center justify-center">
                <i class="fas fa-mobile-alt text-xl text-gray-600"></i>
            </div>

            <h1 class="text-2xl font-bold text-gray-900 mb-2">
                Mobile Only
            </h1>

            <p class="text-sm text-gray-600 leading-relaxed">
                This page can only be accessed from a mobile device. Please open this link from your smartphone.
            </p>
        </div>

    </div>

    <?php $this->load->view('partial/landing/foot.php') ?>
</body>

</html>
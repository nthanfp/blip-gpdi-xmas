<!DOCTYPE html>
<html lang="id">

<head>
    <?php $this->load->view('partial/activities/head.php') ?>
    <style>
        .guide-card {
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 1rem;
            overflow: hidden;
            background: linear-gradient(180deg, rgba(255, 255, 255, .03), rgba(255, 255, 255, .01));
        }

        .guide-hero {
            background: linear-gradient(135deg, #9f1d35 0%, #5f0a10 100%);
            color: #fff;
        }
    </style>
</head>

<body class="<?php $this->load->view('partial/activities/body-class'); ?>">
    <div class="wrapper">
        <?php $this->load->view('partial/activities/sidebar.php') ?>
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>User Guides</h1>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="guide-card guide-hero p-4 mb-4 shadow-sm">
                        <h4 class="mb-2">Panduan per Module</h4>
                        <p class="mb-0 text-white-50">Hanya module yang punya <b>permission</b> yang tampil.</p>
                    </div>

                    <div class="row">
                        <?php if (!empty($modules)): ?>
                            <?php foreach ($modules as $slug => $mod): ?>
                                <div class="col-12 col-md-6 col-lg-4 mb-4">
                                    <div class="card guide-card h-100 shadow-sm">
                                        <div class="card-body d-flex flex-column">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" style="width:48px;height:48px;background:#9f1d35;color:#fff;">
                                                    <i class="<?php echo htmlspecialchars($mod['icon'], ENT_QUOTES, 'UTF-8'); ?>"></i>
                                                </div>
                                                <div>
                                                    <h5 class="mb-0"><?php echo htmlspecialchars($mod['title'], ENT_QUOTES, 'UTF-8'); ?></h5>
                                                    <small class="text-muted">Module guide</small>
                                                </div>
                                            </div>
                                            <p class="text-muted flex-grow-1"><?php echo htmlspecialchars($mod['desc'], ENT_QUOTES, 'UTF-8'); ?></p>
                                            <a href="<?php echo site_url('activities/userguide/module/' . $slug); ?>" class="btn btn-primary btn-block">Buka Panduan</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12">
                                <div class="alert alert-info mb-0">Belum ada guide yang tersedia untuk role ini.</div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        </div>
        <?php $this->load->view('partial/activities/footer.php') ?>
    </div>
    <?php $this->load->view('partial/activities/foot.php') ?>
</body>

</html>
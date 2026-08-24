<!DOCTYPE html>
<html lang="id">

<head>
    <?php $this->load->view('partial/activities/head.php') ?>
    <style>
        .guide-section {
            border: 1px solid rgba(0, 0, 0, .085);
            border-radius: .75rem;
            margin-bottom: 1.5rem;
        }

        .guide-section .guide-section-header {
            background: #f8f9fa;
            border-bottom: 1px solid rgba(0, 0, 0, .085);
            padding: .75rem 1.25rem;
            font-weight: 600;
            border-radius: .75rem .75rem 0 0;
        }

        .guide-section .guide-section-body {
            padding: 1.25rem;
        }

        .guide-step {
            display: flex;
            gap: .75rem;
            margin-bottom: 1rem;
        }

        .guide-step:last-child {
            margin-bottom: 0;
        }

        .guide-step .step-num {
            flex-shrink: 0;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #9f1d35;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .8rem;
            font-weight: 700;
        }

        .guide-step .step-body {
            flex: 1;
        }

        .guide-step .step-body p {
            margin-bottom: 0;
        }

        .guide-tip {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: .75rem 1rem;
            border-radius: .5rem;
            font-size: .875rem;
        }

        .guide-img-placeholder {
            margin-top: .5rem;
            border: 2px dashed #dee2e6;
            border-radius: .5rem;
            padding: 1.25rem;
            background: #f8f9fa;
            text-align: center;
            font-size: .82rem;
            color: #6c757d;
        }

        .guide-img-placeholder i {
            font-size: 1.25rem;
            margin-bottom: .25rem;
            display: block;
        }

        .guide-img-placeholder code {
            font-size: .78rem;
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
                            <h3><i class="<?php echo htmlspecialchars($icon ?? '', ENT_QUOTES, 'UTF-8'); ?> mr-2"></i><?php echo htmlspecialchars($title ?? '', ENT_QUOTES, 'UTF-8'); ?></h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo site_url('activities/userguide'); ?>">User Guides</a></li>
                                <li class="breadcrumb-item active"><?php echo htmlspecialchars($title ?? '', ENT_QUOTES, 'UTF-8'); ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content pb-3">
                <div class="container-fluid">
                    <?php
                    $slug = $slug ?? '';
                    $module_file = APPPATH . 'views/user_guides/modules/' . $slug . '.php';
                    if (file_exists($module_file)) {
                        $this->load->view('user_guides/modules/' . $slug);
                    } else {
                        echo '<div class="alert alert-warning mb-0">Guide untuk module ini belum tersedia.</div>';
                    }
                    ?>

                    <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
                        <?php if (!empty($prev_slug)): ?>
                            <a href="<?php echo site_url('activities/userguide/module/' . $prev_slug); ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-chevron-left mr-1"></i> <?php echo htmlspecialchars($prev_title ?? '', ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                        <?php else: ?>
                            <button class="btn btn-outline-secondary" disabled>
                                <i class="fas fa-chevron-left mr-1"></i> Prev
                            </button>
                        <?php endif; ?>

                        <a href="<?php echo site_url('activities/userguide'); ?>" class="btn btn-secondary">
                            <i class="fas fa-list mr-1"></i> Daftar Guide
                        </a>

                        <?php if (!empty($next_slug)): ?>
                            <a href="<?php echo site_url('activities/userguide/module/' . $next_slug); ?>" class="btn btn-outline-secondary">
                                <?php echo htmlspecialchars($next_title ?? '', ENT_QUOTES, 'UTF-8'); ?> <i class="fas fa-chevron-right ml-1"></i>
                            </a>
                        <?php else: ?>
                            <button class="btn btn-outline-secondary" disabled>
                                Next <i class="fas fa-chevron-right ml-1"></i>
                            </button>
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
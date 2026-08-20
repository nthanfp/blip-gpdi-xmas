<!DOCTYPE html>
<html lang="id">

<head>
    <?php $this->load->view('partial/landing/head.php') ?>
</head>

<body class="bg-gray-50 text-gray-900">
    <!-- Navbar -->
    <?php $this->load->view('partial/landing/navbar.php') ?>

    <!-- Hero Section -->
    <section class="max-w-5xl mx-auto px-4 py-20 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-6">
            Internal Starter Template
        </h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
            A clean, minimal starting point for your next project. Built with CodeIgniter 3 and Tailwind CSS.
        </p>
    </section>

    <!-- Features Section -->
    <section id="features" class="max-w-5xl mx-auto px-4 py-16">
        <h2 class="text-2xl font-bold text-center mb-12">Features</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="text-center p-6">
                <div class="w-12 h-12 mx-auto mb-4 rounded-lg bg-gray-100 flex items-center justify-center">
                    <i class="fas fa-bolt text-gray-600"></i>
                </div>
                <h3 class="font-semibold mb-2">Fast Setup</h3>
                <p class="text-sm text-gray-600">Get started quickly with a pre-configured CodeIgniter 3 project structure.</p>
            </div>
            <!-- Feature 2 -->
            <div class="text-center p-6">
                <div class="w-12 h-12 mx-auto mb-4 rounded-lg bg-gray-100 flex items-center justify-center">
                    <i class="fas fa-palette text-gray-600"></i>
                </div>
                <h3 class="font-semibold mb-2">Tailwind CSS</h3>
                <p class="text-sm text-gray-600">Utility-first CSS framework for rapid UI development.</p>
            </div>
            <!-- Feature 3 -->
            <div class="text-center p-6">
                <div class="w-12 h-12 mx-auto mb-4 rounded-lg bg-gray-100 flex items-center justify-center">
                    <i class="fas fa-shield-alt text-gray-600"></i>
                </div>
                <h3 class="font-semibold mb-2">Secure</h3>
                <p class="text-sm text-gray-600">Built-in CSRF protection and security best practices.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php $this->load->view('partial/landing/footer.php') ?>

    <!-- Foot Js -->
    <?php $this->load->view('partial/landing/foot.php') ?>
</body>

</html>
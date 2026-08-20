<!DOCTYPE html>
<html lang="id">

<head>
    <?php $this->load->view('partial/landing/head.php') ?>

    <!-- Choices Style -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/choices/choices.min.css') ?>" />

    <!-- Choices Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/custom_choices.css') ?>" />
</head>

<body class="bg-light flex justify-center">
    <div class="w-full max-w-[430px] flex flex-col relative shadow-2xl" style="min-height: 100vh; min-height: 100dvh;">

        <!-- Gift Intro -->
        <div id="gift-scene"
            class="hidden fixed inset-0 z-[9999999] items-center justify-center bg-black/80 safari-blur-fix backdrop-blur-sm">
            <div id="gift-box" class="relative w-52" style="perspective: 600px;">

                <!-- Shadow -->
                <div class="absolute -bottom-6 left-1/2 -translate-x-1/2 w-40 h-4 rounded-full blur-2xl"
                    style="background: radial-gradient(ellipse, rgba(0,0,0,0.7) 0%, transparent 100%);">
                </div>

                <!-- ===== LID ===== -->
                <div id="gift-lid" class="relative z-20 h-14 rounded-t-2xl overflow-hidden border-b-0"
                    style="border: 1px solid #5c0b1c; box-shadow: inset 0 1px 0 rgba(255,255,255,0.25), 2px 2px 8px rgba(0,0,0,0.5);
                    background: linear-gradient(to right, #8a0d24 0%, #d01a3e 18%, #f52048 45%, #d01a3e 75%, #8a0d24 100%);">

                    <!-- Top gloss -->
                    <div class="absolute inset-x-0 top-0 h-5"
                        style="background: linear-gradient(to bottom, rgba(255,255,255,0.30), transparent);">
                    </div>

                    <!-- Vertical ribbon lid -->
                    <div class="absolute top-0 h-full" style="left: calc(40% - 10px); width: 20px; 
                        background: linear-gradient(to right, #c8860a, #fde87a 30%, #fff3a0 50%, #fde87a 70%, #c8860a);
                        box-shadow: inset 0 0 4px rgba(255,255,255,0.4);">
                    </div>

                    <!-- Shine streak -->
                    <div class="absolute top-2 right-5 h-10 w-[3px] rounded-full rotate-6"
                        style="background: linear-gradient(to bottom, rgba(255,255,255,0.50), transparent);">
                    </div>

                    <!-- 3D bottom edge illusion -->
                    <div class="absolute bottom-0 inset-x-0 h-2"
                        style="background: linear-gradient(to bottom, transparent, rgba(0,0,0,0.25));">
                    </div>
                </div>

                <!-- ===== BODY ===== -->
                <div class="relative rounded-b-[28px] overflow-hidden"
                    style="height: 148px;border: 1px solid #500818;border-top: none;box-shadow:
                    inset -6px 0 12px rgba(0,0,0,0.3), inset 0 -8px 16px rgba(0,0,0,0.2), 4px 6px 20px rgba(0,0,0,0.6);
                    background: linear-gradient(to right, #7a0a20 0%, #c01535 15%, #e8193f 45%, #c01535 75%, #7a0a20 100%);">

                    <!-- Top gloss -->
                    <div class="absolute inset-x-0 top-0 h-10"
                        style="background: linear-gradient(to bottom, rgba(255,255,255,0.18), transparent);">
                    </div>

                    <!-- Left dark edge (depth) -->
                    <div class="absolute left-0 top-0 h-full w-6"
                        style="background: linear-gradient(to right, rgba(0,0,0,0.35), transparent);">
                    </div>

                    <!-- Right dark edge (depth) -->
                    <div class="absolute right-0 top-0 h-full w-6"
                        style="background: linear-gradient(to left, rgba(0,0,0,0.35), transparent);">
                    </div>

                    <!-- Vertical ribbon body -->
                    <div class="absolute top-0 h-full"
                        style="left: calc(40% - 10px); width: 20px; background: linear-gradient(to right, #c8860a, #fde87a 30%, #fff3a0 50%, #fde87a 70%, #c8860a); box-shadow: inset 0 0 4px rgba(255,255,255,0.4);">
                    </div>

                    <!-- Horizontal ribbon -->
                    <div class="absolute left-0 w-full"
                        style="top: 38px; height: 20px; background: linear-gradient(to bottom, #c8860a, #fde87a 25%, #fff3a0 50%, #fde87a 75%, #c8860a); box-shadow: inset 0 0 4px rgba(255,255,255,0.4);">
                    </div>

                    <!-- Ribbon center square glint -->
                    <div class="absolute"
                        style="left: calc(40% - 10px); top: 38px; width: 20px; height: 20px; background: radial-gradient(ellipse at 40% 35%, #fffbe0, #e8a820 60%, #c8860a);">
                    </div>

                    <!-- Shine streak -->
                    <div class="absolute top-3 right-6 w-[3px] h-16 rounded-full rotate-6"
                        style="background: linear-gradient(to bottom, rgba(255,255,255,0.45), transparent);">
                    </div>

                    <!-- Bottom inner shadow -->
                    <div class="absolute bottom-0 inset-x-0 h-6"
                        style="background: linear-gradient(to bottom, transparent, rgba(0,0,0,0.20));">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex-shrink-0">
            <?php $this->load->view('partial/landing/navbar.php') ?>
        </div>

        <!-- Screen 1 - Form Step 1 -->
        <div class="flex-1 overflow-y-auto min-h-0 shadow-2xl relative flex flex-col justify-between" id="Screen-1">

            <!-- Gift Banner (E-Wallet) -->
            <div id="gift-banner-ewallet" class="hidden mx-5 mt-5 mb-4 bg-white/10 border border-white/20 rounded-2xl overflow-hidden shadow-xl backdrop-blur-sm safari-blur-fix">
                <!-- Header -->
                <div class="bg-gradient-to-r from-primary to-redlux-dark px-5 py-4 border-b border-white/10">
                    <p class="text-[16px] tracking-[1px] font-semibold text-rose-100 mb-1"> Selamat Kamu Mendapatkan </p>
                    <h2 class="text-2xl font-bold text-white" id="gift-title-ewallet"> E-Wallet </h2>
                </div>
                <!-- Content -->
                <div class="p-4">
                    <div class="bg-white/5 border border-white/10 rounded-2xl p-3.5 mb-3">
                        <p class="text-[10px] font-semibold tracking-[2px] text-white/80 mb-3"> BISA KE E-WALLET FAVORITMU </p>
                        <div class="grid grid-cols-4 gap-2.5 text-center">
                            <!-- OVO -->
                            <div class="bg-white/5 rounded-xl p-3 border border-white/10 safari-blur-fix backdrop-blur-sm transition-all hover:bg-white/10"> <img src="<?php echo base_url('assets/images/wallet/5.png'); ?>" class="h-8 mx-auto object-contain" alt="OVO">
                                <p class="text-[10px] mt-2 text-white/90 font-medium"> OVO </p>
                            </div>
                            <!-- DANA -->
                            <div class="bg-white/5 rounded-xl p-3 border border-white/10"> <img src="<?php echo base_url('assets/images/wallet/6.png'); ?>" class="h-8 mx-auto object-contain" alt="DANA">
                                <p class="text-[10px] mt-2 text-white/90 font-medium"> DANA </p>
                            </div>
                            <!-- GOPAY -->
                            <div class="bg-white/5 rounded-xl p-3 border border-white/10"> <img src="<?php echo base_url('assets/images/wallet/7.png'); ?>" class="h-8 mx-auto object-contain" alt="GoPay">
                                <p class="text-[10px] mt-2 text-white/90 font-medium"> Gopay </p>
                            </div>
                            <!-- Shopee -->
                            <div class="bg-white/5 rounded-xl p-3 border border-white/10"> <img src="<?php echo base_url('assets/images/wallet/8.png'); ?>" class="h-8 mx-auto object-contain" alt="Shopee Pay">
                                <p class="text-[10px] mt-2 text-white/90 font-medium"> SPay </p>
                            </div>
                        </div>
                    </div>
                    <!-- Benefit -->
                    <div class="space-y-3 mb-4">
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5"> <i class="fas fa-check-circle text-emerald-400"></i> </div>
                            <p class="text-sm text-white/90 leading-relaxed" id="ewallet-benefit-1"> Saldo hadiah akan dikirim ke akun E-Wallet yang Anda pilih setelah proses verifikasi selesai</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5"> <i class="fas fa-check-circle text-emerald-400"></i> </div>
                            <p class="text-sm text-white/90 leading-relaxed"> Klaim hadiah mudah dan aman melalui sistem resmi </span> </p>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5"> <i class="fas fa-check-circle text-emerald-400"></i> </div>
                            <p class="text-sm text-white/90 leading-relaxed"> Verifikasi dilakukan untuk memastikan hadiah diterima oleh penerima yang tepat </p>
                        </div>
                    </div>
                    <p class="text-[10px] text-white/50 text-center mt-3 leading-relaxed"> *Syarat & ketentuan berlaku. Hadiah akan dikirim maksimal 7x24 jam setelah verifikasi. </p>
                </div>
            </div>

            <!-- Gift Banner (Voucher Shopee) -->
            <div id="gift-banner-shopee" class="hidden mx-5 mt-5 mb-4 bg-white/10 border border-white/20 rounded-2xl overflow-hidden shadow-xl backdrop-blur-sm safari-blur-fix ">
                <!-- Header -->
                <div class="bg-gradient-to-r from-[#EE4D2D] to-[#C62E12] px-5 py-4 border-b border-white/10">
                    <p class="text-[16px] tracking-[1px] font-semibold text-rose-100 mb-1"> Selamat Kamu Mendapatkan </p>
                    <h2 class="text-xl font-bold text-white" id="gift-title-shopee"> Voucher Shopee </h2>
                </div>
                <!-- Content -->
                <div class="p-5">
                    <!-- Benefit -->
                    <div class="space-y-3 mb-4">
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5"> <i class="fas fa-check-circle text-emerald-400"></i> </div>
                            <p class="text-sm text-white/90 leading-relaxed" id="shopee-benefit-1"> Voucher belanja resmi untuk digunakan di Official Store Illusions </p>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5"> <i class="fas fa-check-circle text-emerald-400"></i> </div>
                            <p class="text-sm text-white/90 leading-relaxed"> Berlaku untuk berbagai pilihan sprei dan perlengkapan tidur berkualitas </p>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5"> <i class="fas fa-check-circle text-emerald-400"></i> </div>
                            <p class="text-sm text-white/90 leading-relaxed"> Pengiriman voucher dilakukan setelah proses verifikasi data selesai </p>
                        </div>
                    </div>
                    <p class="text-[10px] text-white/50 text-center mt-3 leading-relaxed"> *Syarat & ketentuan berlaku. Voucher dikirim maksimal 7x24 jam setelah verifikasi. </p>
                </div>
            </div>

            <!-- Divider -->
            <div class="flex items-center gap-2.5 mx-5 mb-4">
                <div class="flex-1 h-px bg-white/15"></div>
                <span class="text-[10px] tracking-[3px] text-white/80 font-semibold">
                    KONFIRMASI DATA
                </span>
                <div class="flex-1 h-px bg-white/15"></div>
            </div>

            <!-- Form  (Step 1. Nomor HP) -->
            <div class="mx-5">
                <div>
                    <div id="hp-msg" class="mb-2 hidden">
                        <div class="flex items-start gap-2 rounded-xl border border-white/10 bg-white/5 backdrop-blur-md safari-blur-fix p-3">
                            <i class="fas fa-info-circle text-amber-300 mt-0.5 text-xs"></i>
                            <p class="text-[11px] leading-relaxed text-white/70">
                                Pastikan nomor HP yang Anda gunakan sudah terdaftar pada layanan E-Wallet yang dipilih agar proses pengiriman hadiah dapat dilakukan dengan lancar.
                            </p>
                        </div>
                    </div>
                    <label class="block text-[12px] font-semibold tracking-[1px] text-white mb-2">
                        Nomor HP / Whatsapp
                    </label>
                    <div class="relative mb-4">
                        <div class="absolute left-0 top-0 bottom-0 w-14 flex items-center justify-center text-sm font-semibold text-white bg-[#8B102E] border-r border-white/10 rounded-l-xl z-10">
                            +62
                        </div>
                        <div class="absolute left-14 top-1/2 -translate-y-1/2 h-5 w-px bg-white/20 z-10"></div>
                        <input type="tel" id="hp-input" name="phone_number" autocomplete="off" inputmode="numeric"
                            maxlength="13" placeholder="8xx-xxxx-xxxx" class="w-full pl-16 pr-4 py-3.5 border border-white/10 rounded-xl text-sm text-white placeholder-white/55 bg-white/10 safari-blur-fix backdrop-blur-sm focus:outline-none focus:border-rose-200 focus:ring-2 focus:ring-rose-200/20 transition-all" />
                    </div>
                </div>
                <div id="wallet-field">
                    <label class="block text-[12px] font-semibold tracking-[1px] text-white mb-2">
                        E-Wallet
                    </label>
                    <div class="relative">
                        <div
                            class="absolute left-0 top-0 bottom-0 w-14 flex items-center justify-center text-white bg-[#8B102E] border-r border-white/10 rounded-l-xl z-10">
                            <i class="fas fa-wallet text-sm"></i>
                        </div>
                        <select id="wallet" name="wallet" autocomplete="off" class="w-full pl-16 pr-10 py-3.5
                                    border border-white/10 rounded-xl text-sm text-white bg-white/10 safari-blur-fix backdrop-blur-sm
                                    focus:outline-none focus:border-rose-200 focus:ring-2 focus:ring-rose-200/20 
                                    transition-all appearance-none">
                            <option value="" class="text-gray-900">
                                Pilih E-Wallet
                            </option>
                            <option value="OVO" class="text-gray-900">
                                OVO
                            </option>
                            <option value="DANA" class="text-gray-900">
                                DANA
                            </option>
                            <option value="GoPay" class="text-gray-900">
                                GoPay
                            </option>
                            <option value="ShopeePay" class="text-gray-900">
                                ShopeePay
                            </option>
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-white/80 z-10">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                    <div id="wallet-msg" class="mt-2"></div>
                </div>
                <button onclick="cekHP()"
                    class="block w-[calc(100%-0px)] mt-4 mb-5 py-3.5 bg-gradient-to-b from-primary to-redlux-dark hover:brightness-110 active:scale-[.98] text-white text-xs font-semibold tracking-[1px] rounded-xl ring-1 ring-white/10 shadow-xl shadow-red-900/30 transition-all duration-300">
                    CEK NOMOR HP
                    &nbsp;
                    <i class="fas fa-arrow-right"></i>

                </button>
            </div>
        </div>

        <!-- Screen 2 - Form Step 2 -->
        <div class="flex-1 overflow-y-auto min-h-0 shadow-2xl relative justify-between flex-col hidden" id="Screen-2">
            <!-- Form (Step 2. Purchase Proof) -->
            <div id="customer-form-purchase-proof" class="mx-5 mt-5 mb-4 hidden">
                <div class="bg-white/10 safari-blur-fix backdrop-blur-md border border-white/20 rounded-2xl overflow-hidden shadow-xl">
                    <div class="bg-gradient-to-r from-primary to-redlux-dark px-5 py-4 border-b border-white/10">
                        <p class="text-[10px] tracking-[2px] font-semibold text-rose-100 mb-1">
                            BUKTI PEMBELIAN
                        </p>
                        <h2 class="text-lg font-bold text-white">
                            Upload Bukti Pembelian
                        </h2>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="hidden bg-blue-500/10 border border-blue-300/10 rounded-xl p-3 items-start gap-2.5">
                            <i class="fas fa-info-circle text-blue-400 mt-0.5"></i>
                            <p class="text-xs text-white/100 leading-relaxed">
                                Silahkan upload bukti pembelian produk Sprei Illusions Anda. File harus berupa gambar (JPG, PNG, WEBP).
                            </p>
                        </div>
                        <div>
                            <label class="block text-[12px] font-semibold tracking-[1px] text-white mb-2">
                                Foto Bukti Pembelian <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <input type="file" id="purchase_proof" name="purchase_proof" accept="image/jpeg,image/png,image/gif,image/webp" capture="environment"
                                    class="hidden" onchange="handleProofPreview(this)" />
                                <label for="purchase_proof"
                                    class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-white/20 rounded-xl cursor-pointer bg-white/5 hover:bg-white/10 transition-all">
                                    <div id="proof-preview-placeholder" class="flex flex-col items-center justify-center">
                                        <i class="fas fa-cloud-upload-alt text-2xl text-white/50 mb-2"></i>
                                        <p class="text-xs text-white/60">Klik untuk upload gambar</p>
                                        <p class="text-[10px] text-white/40 mt-1">JPG, PNG, GIF, WEBP (Max 5MB)</p>
                                    </div>
                                    <img id="proof-preview-img" class="hidden max-h-full max-w-full object-contain rounded-lg" alt="Proof preview" />
                                </label>
                            </div>
                            <div id="proof-error" class="mt-2 hidden">
                                <p class="text-xs text-red-300"></p>
                            </div>
                        </div>
                        <button type="button" onclick="nextToCustomerForm()"
                            class="block w-full py-3.5 bg-gradient-to-b from-primary to-redlux-dark hover:brightness-110 active:scale-[.98] text-white text-xs font-semibold tracking-[1px] rounded-xl ring-1 ring-white/10 shadow-xl shadow-red-900/30 transition-all duration-300">
                            LANJUT &nbsp; <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Form (Step 3. Email & Domisili) -> Existing -> Capta Only -->
            <div id="customer-info-card" class="hidden mx-5 mt-5 mb-4">
                <div
                    class="bg-white/10 safari-blur-fix backdrop-blur-md border border-white/20 rounded-2xl overflow-hidden shadow-xl">
                    <div class="bg-gradient-to-r from-primary to-redlux-dark px-5 py-4 border-b border-white/10">
                        <p class="text-[10px] tracking-[2px] font-semibold text-rose-100 mb-1">
                            DATA DIRI ANDA
                        </p>
                        <h2 class="text-lg font-bold text-white">
                            Info Customer
                        </h2>
                    </div>
                    <div class="p-4 space-y-3">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-9 h-9 rounded-full bg-white/10 border border-white/10 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-user text-xs text-white/80"></i>
                            </div>
                            <div>
                                <p class="text-[10px] tracking-[1px] text-white/50 font-semibold">NAMA</p>
                                <p class="text-sm font-medium text-white" id="info-custname">-</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div
                                class="w-9 h-9 rounded-full bg-white/10 border border-white/10 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-envelope text-xs text-white/80"></i>
                            </div>
                            <div>
                                <p class="text-[10px] tracking-[1px] text-white/50 font-semibold">EMAIL</p>
                                <p class="text-sm font-medium text-white" id="info-email">-</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div
                                class="w-9 h-9 rounded-full bg-white/10 border border-white/10 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-xs text-white/80"></i>
                            </div>
                            <div>
                                <p class="text-[10px] tracking-[1px] text-white/50 font-semibold">DOMISILI</p>
                                <p class="text-sm font-medium text-white" id="info-domisili">-</p>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 pb-4">
                        <div
                            class="bg-yellow-500/10 border border-yellow-300/10 rounded-xl p-3 flex items-start gap-2.5 mb-4">
                            <i class="fas fa-check-circle text-yellow-400 mt-0.5"></i>
                            <p class="text-xs text-white/100 leading-relaxed">
                                Silahkan lakukan verifikasi captcha untuk melanjutkan proses pengiriman hadiah.
                            </p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-[12px] font-semibold tracking-[1px] text-white mb-2">Captcha</label>
                            <div class="flex items-start gap-3">
                                <div id="captcha-image-card"
                                    class="min-w-[180px] h-[50px] rounded-xl overflow-hidden bg-white flex items-center justify-center border border-white/10 shadow-inner">
                                    <span class="text-xs text-gray-500">Memuat captcha...</span>
                                </div>
                                <button type="button" onclick="loadCaptcha()"
                                    class="h-[50px] px-4 rounded-xl bg-white/10 border border-white/10 text-white text-xs font-semibold tracking-[1px]">
                                    Refresh
                                </button>
                            </div>
                            <div class="mt-3">
                                <div class="relative">
                                    <div class="absolute left-0 top-0 bottom-0 w-14 flex items-center justify-center text-white bg-[#8B102E] border-r border-white/10 rounded-l-xl z-10">
                                        <i class="fas fa-shield-alt text-sm"></i>
                                    </div>
                                    <input type="number" id="captcha_code_card" name="captcha_code" autocomplete="off"
                                        placeholder="Masukkan captcha"
                                        class="w-full pl-[72px] pr-4 py-3.5 border border-white/10 rounded-xl text-sm text-white placeholder-white/55 bg-white/10 safari-blur-fix backdrop-blur-sm focus:outline-none focus:border-rose-200 focus:ring-2 focus:ring-rose-200/20 transition-all" />
                                </div>
                            </div>
                        </div>

                        <button type="button" onclick="submitClaim()"
                            class="block w-full py-3.5 bg-gradient-to-b from-primary to-redlux-dark hover:brightness-110 active:scale-[.98] text-white text-xs font-semibold tracking-[1px] rounded-xl ring-1 ring-white/10 shadow-xl shadow-red-900/30 transition-all duration-300">
                            KLAIM HADIAH &nbsp; <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Form (Step 3. Email & Domisili) -->
            <div id="customer-form-wrapper" class="mx-5 mt-5 mb-4 hidden">
                <input type="hidden" id="idempotency_key" name="idempotency_key" autocomplete="off" />
                <input type="hidden" id="voucher_key" name="voucher_key" autocomplete="off" />
                <input type="hidden" id="mst_customerid" name="mst_customerid" autocomplete="off" />
                <input type="hidden" id="geo_lat" name="geo_lat" autocomplete="off" />
                <input type="hidden" id="geo_long" name="geo_long" autocomplete="off" />
                <!-- Nama -->
                <div class="mb-4">
                    <label class="block text-[12px] font-semibold tracking-[1px] text-white mb-2"> Nama Lengkap </label>
                    <div class="relative">
                        <div class="absolute left-0 top-0 bottom-0 w-14 flex items-center justify-center text-white bg-[#8B102E] border-r border-white/10 rounded-l-xl z-10">
                            <i class="fas fa-user text-sm"></i>
                        </div>
                        <input type="text" id="custname" name="custname" autocomplete="off" placeholder="Nama Sesuai Identitas" class="w-full pl-[72px] pr-4 py-3.5 border border-white/10 rounded-xl text-sm text-white placeholder-white/55 bg-white/10 safari-blur-fix backdrop-blur-sm focus:outline-none focus:border-rose-200 focus:ring-2 focus:ring-rose-200/20 transition-all" oninput="this.value = this.value.toUpperCase()" />
                    </div>
                </div>
                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-[12px] font-semibold tracking-[1px] text-white mb-2"> Email</label>
                    <div class="relative">
                        <div class="absolute left-0 top-0 bottom-0 w-14 flex items-center justify-center text-white bg-[#8B102E] border-r border-white/10 rounded-l-xl z-10">
                            <i class="fas fa-envelope text-sm"></i>
                        </div>
                        <input type="email" id="email" name="email" autocomplete="off" placeholder="johndoe@gmail.com" class="w-full pl-[72px] pr-4 py-3.5 border border-white/10 rounded-xl text-sm text-white placeholder-white/55 bg-white/10 safari-blur-fix backdrop-blur-sm focus:outline-none focus:border-rose-200 focus:ring-2 focus:ring-rose-200/20 transition-all" />
                    </div>
                </div>
                <!-- Provinsi -->
                <div class="mb-4">
                    <label class="block text-[12px] font-semibold tracking-[1px] text-white mb-2"> Provinsi</label>
                    <div class="relative glass-select">
                        <div class="absolute left-0 top-0 bottom-0 w-14 flex items-center justify-center text-white bg-[#8B102E] border-r border-white/10 rounded-l-xl z-10">
                            <i class="fas fa-map text-sm"></i>
                        </div>
                        <select id="provinsi" name="mst_reg_provinceid" autocomplete="off" class="w-full pl-[72px] pr-10 py-3.5 border border-white/10 rounded-xl text-sm text-white bg-white/10 safari-blur-fix backdrop-blur-sm focus:outline-none focus:border-rose-200 focus:ring-2 focus:ring-rose-200/20 transition-all appearance-none">
                            <option value="" class="text-gray-900"> Pilih Provinsi </option>
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-white/80 pointer-events-none z-10">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>
                <!-- Kota -->
                <div class="mb-4">
                    <label class="block text-[12px] font-semibold tracking-[1px] text-white mb-2"> Kota / Kabupaten </label>
                    <div class="relative glass-select">
                        <div class="absolute left-0 top-0 bottom-0 w-14 flex items-center justify-center text-white bg-[#8B102E] border-r border-white/10 rounded-l-xl z-20">
                            <i class="fas fa-city text-sm"></i>
                        </div>
                        <select id="kota" name="mst_reg_cityid" autocomplete="off" class="w-full pl-[72px] pr-10 py-3.5 border border-white/10 rounded-xl text-sm text-white bg-white/10 safari-blur-fix backdrop-blur-sm focus:outline-none focus:border-rose-200 focus:ring-2 focus:ring-rose-200/20 transition-all appearance-none z-10">
                            <option value="" class="text-gray-900"> Pilih Kota / Kabupaten </option>
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-white/80 pointer-events-none z-10">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>
                <!-- Kecamatan -->
                <div class="mb-4">
                    <label class="block text-[12px] font-semibold tracking-[1px] text-white mb-2"> Kecamatan</label>
                    <div class="relative glass-select">
                        <div class="absolute left-0 top-0 bottom-0 w-14 flex items-center justify-center text-white bg-[#8B102E] border-r border-white/10 rounded-l-xl z-10">
                            <i class="fas fa-map-marker-alt text-sm"></i>
                        </div>
                        <select id="kecamatan" name="mst_reg_districtid" autocomplete="off" class="w-full pl-[72px] pr-10 py-3.5 border border-white/10 rounded-xl text-sm text-white bg-white/10 safari-blur-fix backdrop-blur-sm focus:outline-none focus:border-rose-200 focus:ring-2 focus:ring-rose-200/20 transition-all appearance-none">
                            <option value="" class="text-gray-900"> Pilih Kecamatan </option>
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-white/80 pointer-events-none z-10">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>
                <!-- Captcha -->
                <div class="mb-4">
                    <label class="block text-[12px] font-semibold tracking-[1px] text-white mb-2"> Captcha</label>
                    <div class="flex items-start gap-3">
                        <div id="captcha-image" class="min-w-[180px] h-[50px] rounded-xl overflow-hidden bg-white flex items-center justify-center border border-white/10 shadow-inner">
                            <span class="text-xs text-gray-500"> Memuat captcha... </span>
                        </div>
                        <button type="button" onclick="loadCaptcha()" class="h-[50px] px-4 rounded-xl bg-white/10 border border-white/10 text-white text-xs font-semibold tracking-[1px]">
                            Refresh
                        </button>
                    </div>
                    <div class="mt-3">
                        <div class="relative">
                            <div class="absolute left-0 top-0 bottom-0 w-14 flex items-center justify-center text-white bg-[#8B102E] border-r border-white/10 rounded-l-xl z-10">
                                <i class="fas fa-shield-alt text-sm"></i>
                            </div>
                            <input type="number" id="captcha_code" name="captcha_code" autocomplete="off" placeholder="Masukkan captcha" class="w-full pl-[72px] pr-4 py-3.5 border border-white/10 rounded-xl text-sm text-white placeholder-white/55 bg-white/10 safari-blur-fix backdrop-blur-sm focus:outline-none focus:border-rose-200 focus:ring-2 focus:ring-rose-200/20 transition-all" />
                        </div>
                    </div>
                </div>
                <!-- Button -->
                <button type="button" onclick="submitClaim()" class="block w-full mt-4 mb-5 py-3.5 bg-gradient-to-b from-primary to-redlux-dark hover:brightness-110 active:scale-[.98] text-white text-xs font-semibold tracking-[1px] rounded-xl ring-1 ring-white/10 shadow-xl shadow-red-900/30 transition-all duration-300">
                    KLAIM HADIAH &nbsp; <i class="fas fa-arrow-right"></i>
                </button>
            </div>

        </div>

        <!-- Screen 3 - Invalid -->
        <div class="flex-1 overflow-y-auto min-h-0 shadow-2xl relative justify-center flex-col hidden" id="Screen-3">
            <!-- Section: Invalid -->
            <div id="Section-Invalid" class="px-5">
                <div class="bg-white/10 safari-blur-fix backdrop-blur-md border border-white/10 rounded-2xl p-5 shadow-xl">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-red-800/30 border 
                        border-red-400/10 flex items-center justify-center">
                        <i class="fas fa-times-circle text-2xl text-red-200"></i>
                    </div>
                    <h3 class="text-center text-xl font-bold text-white mb-2">
                        Voucher Tidak Tersedia
                    </h3>
                    <p class="text-sm text-center text-red-100/80 leading-relaxed mb-5">
                        Voucher yang Anda gunakan sudah pernah diklaim,
                        kedaluwarsa, atau tidak valid.
                    </p>
                    <div class="bg-white/5 border border-white/10 rounded-xl p-4 mb-4 hidden">
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5">
                                <i class="fas fa-info-circle text-amber-300"></i>
                            </div>
                            <p class="text-xs text-white/70 leading-relaxed">
                                Pastikan Anda menggunakan link voucher resmi
                                dari PRODUK ILLUSIONS dan belum pernah melakukan klaim sebelumnya.
                            </p>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <!-- Screen 4 - Success -->
        <div class="flex-1 overflow-y-auto min-h-0 shadow-2xl relative justify-center flex-col hidden" id="Screen-4">
            <div class="px-5">
                <div class="bg-white/10 safari-blur-fix backdrop-blur-md border border-white/20 rounded-2xl p-6 shadow-xl">

                    <!-- E-Wallet / Default Success -->
                    <div id="screen4-ewallet">
                        <div class="w-20 h-20 mx-auto mb-5 rounded-3xl bg-emerald-500/10 border border-emerald-300/10 flex items-center justify-center">
                            <i class="fas fa-check-circle text-4xl text-emerald-300"></i>
                        </div>
                        <h2 class="text-center text-2xl font-bold text-white mb-3">
                            Informasi Berhasil Dikirim
                        </h2>
                        <p class="text-sm text-center text-white/70 leading-relaxed mb-6">
                            Data Anda telah berhasil kami terima. Tim kami akan memproses hadiah dan melakukan verifikasi dalam maksimal <span class="text-rose-100 font-semibold">7x24 jam</span>.
                        </p>
                    </div>

                    <!-- Shopee Success — cek email -->
                    <div id="screen4-shopee" class="hidden">
                        <div class="w-20 h-20 mx-auto mb-5 rounded-3xl bg-emerald-500/10 border border-emerald-300/10 flex items-center justify-center">
                            <i class="fas fa-envelope text-4xl text-emerald-300"></i>
                        </div>
                        <h2 class="text-center text-2xl font-bold text-white mb-3">
                            Informasi Berhasil Dikirim
                        </h2>
                        <p class="text-sm text-center text-white/70 leading-relaxed mb-6">
                            Data Anda telah berhasil kami terima. Silakan periksa kotak masuk (inbox) atau folder spam email Anda untuk langkah selanjutnya.
                        </p>
                    </div>

                    <button onclick="window.location.reload()" class="w-full py-3.5 rounded-xl bg-primary hover:bg-redlux-dark active:scale-[.98] text-white text-xs font-semibold tracking-[1px] shadow-lg shadow-red-900/30 transition-all">
                        SELESAI
                    </button>
                </div>
            </div>
        </div>

        <!-- Screen 5 - Redeemed -->
        <div class="flex-1 overflow-y-auto min-h-0 shadow-2xl relative justify-center flex-col hidden" id="Screen-5">
            <div class="px-5">
                <div class="bg-white/10 safari-blur-fix backdrop-blur-md border border-white/20 rounded-2xl p-6 shadow-xl">
                    <div class="w-20 h-20 mx-auto mb-5 rounded-3xl bg-amber-500/10 border border-amber-300/10 flex items-center justify-center">
                        <i class="fas fa-clock text-4xl text-amber-300"></i>
                    </div>
                    <h2 class="text-center text-2xl font-bold text-white mb-3">
                        Hadiah Sudah Ditukarkan
                    </h2>
                    <p class="text-sm text-center text-white/70 leading-relaxed mb-6">
                        Voucher ini sudah pernah diklaim sebelumnya. Silahkan cek email Anda untuk informasi lebih lanjut mengenai pengiriman hadiah.
                    </p>
                    <div class="hidden bg-white/5 border border-white/10 rounded-xl p-4 mb-5">
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5">
                                <i class="fas fa-envelope text-amber-200"></i>
                            </div>
                            <p class="text-xs text-white/70 leading-relaxed">
                                Jika belum menerima email, hubungi customer service
                                untuk bantuan lebih lanjut.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php $this->load->view('partial/landing/footer.php') ?>
    </div>

    <!-- Anime Js -->
    <script type="text/javascript" src="<?php echo base_url('assets/js/anime.min.js'); ?>"></script>

    <!-- Confetti -->
    <script type="text/javascript" src="<?php echo base_url('assets/js/confetti.browser.min.js'); ?>"></script>

    <!-- Choices -->
    <script type="text/javascript" src="<?php echo base_url('assets/plugins/choices/choices.min.js') ?>"></script>

    <!-- GSAP -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/gsap@3.15/dist/gsap.min.js"></script>

    <!-- Library Foot -->
    <?php $this->load->view('partial/landing/foot.php') ?>

    <!-- Gift & Confetti -->
    <script type="text/javascript">
        function playConfetti() {
            var duration = 6 * 1000;
            var animationEnd = Date.now() + duration;

            var defaults = {
                startVelocity: 45,
                spread: 450,
                ticks: 100,
                zIndex: 99999999
            };

            function randomInRange(min, max) {
                return Math.random() * (max - min) + min;
            }

            var interval = setInterval(function() {

                var timeLeft = animationEnd - Date.now();

                if (timeLeft <= 0) {
                    clearInterval(interval);
                    return;
                }

                var particleCount = 50 * (timeLeft / duration);

                confetti({
                    ...defaults,
                    particleCount,
                    origin: {
                        x: randomInRange(0.1, 0.3),
                        y: Math.random() - 0.2
                    }
                });

                confetti({
                    ...defaults,
                    particleCount,
                    origin: {
                        x: randomInRange(0.7, 0.9),
                        y: Math.random() - 0.2
                    }
                });

            }, 250);
        }

        function startGiftAnimation() {
            anime.set('#gift-box', {
                translateY: -250,
                scale: 0.5,
                rotate: '-15deg',
                opacity: 1
            });

            anime({
                targets: '#gift-box',
                translateY: 0,
                scale: 1,
                rotate: 0,
                opacity: 1,
                duration: 1800,
                easing: 'easeOutBounce',

                begin: function() {
                    if (typeof confetti === 'function') {
                        playConfetti();
                    }
                },

                complete: function() {
                    anime({
                        targets: '#gift-box',
                        rotate: [{
                                value: -8
                            },
                            {
                                value: 8
                            },
                            {
                                value: -5
                            },
                            {
                                value: 5
                            },
                            {
                                value: 0
                            }
                        ],
                        duration: 500,
                        easing: 'easeInOutSine',

                        complete: function() {
                            anime({
                                targets: '#gift-lid',
                                rotate: -35,
                                translateX: -20,
                                translateY: -20,
                                duration: 700,
                                easing: 'easeOutExpo'
                            });

                            anime({
                                targets: '#gift-box',
                                translateY: [-8, 8],
                                duration: 2000,
                                direction: 'alternate',
                                loop: true,
                                easing: 'easeInOutSine'
                            });

                            setTimeout(() => {
                                anime({
                                    targets: '#gift-scene',
                                    opacity: 0,
                                    duration: 1000,
                                    easing: 'easeOutExpo',
                                    complete: function() {
                                        document.getElementById('gift-scene').remove();
                                    }
                                });
                            }, 2000);
                        }
                    });
                }
            });
        }

        $(document).ready(function() {

        });
    </script>

    <!-- Complete Js -->
    <script type="text/javascript">
        const BASE_URL = '<?php echo base_url(); ?>';
        var csrfName = $('meta[name="csrf-token-name"]').attr('content') || 'csrf_test_name';
        var csrfToken = $('meta[name="csrf-token-value"]').attr('content');
        let voucherMeta = {
            itemtype: null,
            itemname: '',
        };

        let provinceChoice;
        let cityChoice;
        let districtChoice;

        let phoneCheckResult = null;

        async function populateCustomerLocation(customer) {
            if (!customer || !customer.mst_reg_provinceid) {
                return;
            }

            await loadProvince(customer.mst_reg_provinceid);
            await loadCity(customer.mst_reg_provinceid, customer.mst_reg_cityid);
            await loadDistrict(customer.mst_reg_cityid, customer.mst_reg_districtid);
        }

        function getChoiceSelectedText(choiceInstance) {
            var values = choiceInstance.getValue(true);
            if (values && values.length > 0) {
                var first = values[0];
                if (first.label) return first.label;
                if (first.value) return first.value;
            }
            var sel = choiceInstance.passedElement.element;
            if (sel && sel.options && sel.selectedIndex >= 0) {
                return sel.options[sel.selectedIndex].text || '';
            }
            return '';
        }

        function initChoice(selector, placeholder) {
            return new Choices(selector, {
                searchEnabled: true,
                itemSelectText: '',
                shouldSort: false,
                searchPlaceholderValue: placeholder,
                placeholder: true,
                placeholderValue: placeholder
            });
        }

        function setChoiceLoading(choiceInstance, text) {
            choiceInstance.clearChoices();

            choiceInstance.setChoices([{
                value: '',
                label: text,
                selected: true,
                disabled: true
            }], 'value', 'label', true);
        }

        function setChoiceOptions(choiceInstance, placeholder, rows, valueKey, labelKey) {
            let data = [{
                value: '',
                label: placeholder,
                selected: true,
                disabled: true
            }];

            $.each(rows || [], function(i, row) {
                data.push({
                    value: String(row[valueKey]),
                    label: row[labelKey]
                });
            });

            choiceInstance.clearStore();
            choiceInstance.setChoices(data, 'value', 'label', true);
        }

        function loadProvince(selectedValue) {
            return new Promise(function(resolve) {
                setChoiceLoading(provinceChoice, 'Memuat provinsi...');

                $.ajax({
                    url: BASE_URL + 'activities/region/data_option_province',
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        let rows = res.success ? res.data : [];

                        setChoiceOptions(
                            provinceChoice,
                            'Pilih Provinsi',
                            rows,
                            'mst_reg_provinceid',
                            'display_name'
                        );

                        if (selectedValue) {
                            provinceChoice.setChoiceByValue(String(selectedValue));
                        }

                        resolve();
                    },
                    error: function() {
                        resolve();
                    }
                });
            });
        }

        function loadCity(provinceid, selectedValue) {
            return new Promise(function(resolve) {
                setChoiceLoading(cityChoice, 'Memuat kota...');
                setChoiceOptions(
                    districtChoice,
                    'Pilih Kecamatan',
                    [],
                    '',
                    ''
                );

                $.ajax({
                    url: BASE_URL + 'activities/region/data_option_city',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        mst_reg_provinceid: provinceid
                    },
                    success: function(res) {
                        let rows = res.success ? res.data : [];

                        setChoiceOptions(
                            cityChoice,
                            'Pilih Kota / Kabupaten',
                            rows,
                            'mst_reg_cityid',
                            'display_name'
                        );

                        if (selectedValue) {
                            cityChoice.setChoiceByValue(String(selectedValue));
                        }

                        resolve();
                    },
                    error: function() {
                        resolve();
                    }
                });
            });
        }

        function loadDistrict(cityid, selectedValue) {
            return new Promise(function(resolve) {
                setChoiceLoading(districtChoice, 'Memuat kecamatan...');

                $.ajax({
                    url: BASE_URL + 'activities/region/data_option_district',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        mst_reg_cityid: cityid
                    },
                    success: function(res) {
                        let rows = res.success ? res.data : [];

                        setChoiceOptions(
                            districtChoice,
                            'Pilih Kecamatan',
                            rows,
                            'mst_reg_districtid',
                            'display_name'
                        );

                        if (selectedValue) {
                            districtChoice.setChoiceByValue(String(selectedValue));
                        }

                        resolve();
                    },
                    error: function() {
                        resolve();
                    }
                });
            });
        }

        function handleProofPreview(input) {
            const errorEl = $('#proof-error');
            const placeholderEl = $('#proof-preview-placeholder');
            const previewImg = $('#proof-preview-img');

            errorEl.addClass('hidden');
            previewImg.addClass('hidden');
            placeholderEl.removeClass('hidden');

            if (!input.files || !input.files[0]) {
                return;
            }

            const file = input.files[0];
            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            const maxSize = 5 * 1024 * 1024;

            if (!allowedTypes.includes(file.type)) {
                errorEl.removeClass('hidden').find('p').text('File harus berupa gambar (JPG, PNG, GIF, WEBP).');
                input.value = '';
                return;
            }

            if (file.size > maxSize) {
                errorEl.removeClass('hidden').find('p').text('Ukuran file maksimal 5MB.');
                input.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.attr('src', e.target.result).removeClass('hidden');
                placeholderEl.addClass('hidden');
            };
            reader.readAsDataURL(file);
        }

        function validateProofFile() {
            const input = document.getElementById('purchase_proof');
            const errorEl = $('#proof-error');

            if (!input.files || !input.files[0]) {
                errorEl.removeClass('hidden').find('p').text('Bukti pembelian wajib diupload.');
                return false;
            }

            const file = input.files[0];
            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            const maxSize = 5 * 1024 * 1024;

            if (!allowedTypes.includes(file.type)) {
                errorEl.removeClass('hidden').find('p').text('File harus berupa gambar (JPG, PNG, GIF, WEBP).');
                return false;
            }

            if (file.size > maxSize) {
                errorEl.removeClass('hidden').find('p').text('Ukuran file maksimal 5MB.');
                return false;
            }

            errorEl.addClass('hidden');
            return true;
        }

        function nextToCustomerForm() {
            if (!validateProofFile()) {
                return;
            }

            gsap.to('#customer-form-purchase-proof', {
                opacity: 0, y: -20, duration: 0.2, ease: 'power2.in',
                onComplete: function() {
                    $('#customer-form-purchase-proof').addClass('hidden');
                    if (phoneCheckResult && phoneCheckResult.exists && phoneCheckResult.data) {
                        showCustomerForm(phoneCheckResult.data);
                    } else {
                        $('#customer-info-card').addClass('hidden');
                        $('#customer-form-wrapper').removeClass('hidden');
                        gsap.fromTo('#customer-form-wrapper', { opacity: 0, y: 20 }, { opacity: 1, y: 0, duration: 0.4, ease: 'power2.out' });
                        if (!$('#custname').val()) {
                            clearCustomerForm();
                            loadProvince();
                        }
                    }
                }
            });
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function isEwalletGift() {
            return String(voucherMeta.itemtype || '') === '1';
        }

        function escapeHtml(text) {
            return String(text || '').replace(/[&<>"']/g, function(m) {
                return ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#39;'
                })[m];
            });
        }

        function ensureToastContainer() {
            if (!document.getElementById('app-toast-container')) {
                document.body.insertAdjacentHTML('beforeend', '<div id="app-toast-container" class="fixed top-4 right-4 z-[9999] w-[calc(100vw-2rem)] max-w-sm pointer-events-none"></div>');
            }
        }

        function showToast(message, type) {
            ensureToastContainer();
            const container = document.getElementById('app-toast-container');
            container.innerHTML = '';
            const styles = {
                success: {
                    shell: 'bg-gradient-to-r from-emerald-600 to-emerald-500 border-emerald-300/40',
                    icon: 'fas fa-check-circle',
                    iconWrap: 'bg-white/10 border border-white/10 text-white',
                },
                error: {
                    shell: 'bg-gradient-to-r from-primary to-redlux-dark border-rose-200/10',
                    icon: 'fas fa-exclamation-circle',
                    iconWrap: 'bg-white/10 border border-white/10 text-white',
                },
                info: {
                    shell: 'bg-gradient-to-r from-slate-900 to-slate-800 border-white/10',
                    icon: 'fas fa-info-circle',
                    iconWrap: 'bg-white/10 text-white',
                }
            };
            const preset = styles[type] || styles.info;
            const toast = document.createElement('div');
            toast.className = 'pointer-events-auto overflow-hidden rounded-2xl border shadow-2xl safari-blur-fix backdrop-blur-xl transition-all duration-300 ease-out transform translate-y-[-8px] opacity-0';
            toast.innerHTML = [
                '<div class="' + preset.shell + '">',
                '<div class="flex items-center gap-3 px-4 py-3">',

                '<div class="h-7 w-7 rounded-full flex items-center justify-center flex-shrink-0 ' + preset.iconWrap + '">',
                '<i class="' + preset.icon + ' text-sm"></i>',
                '</div>',

                '<div class="flex-1 pr-1">',
                '<p class="text-xs leading-relaxed text-white">',
                escapeHtml(message),
                '</p>',
                '</div>',

                '<button type="button" class="text-white/60 hover:text-white transition-colors flex-shrink-0" aria-label="Close">',
                '<i class="fas fa-times text-xs"></i>',
                '</button>',

                '</div>',
                '</div>'
            ].join('');

            container.appendChild(toast);
            requestAnimationFrame(function() {
                toast.classList.remove('translate-y-[-8px]', 'opacity-0');
                toast.classList.add('translate-y-0', 'opacity-100');
            });
            const close = function() {
                toast.classList.add('translate-y-[-8px]', 'opacity-0');
                setTimeout(function() {
                    if (toast && toast.parentNode) toast.parentNode.removeChild(toast);
                }, 180);
            };
            toast.querySelector('button').addEventListener('click', close);
            setTimeout(close, 3500);
        }

        function titleCaseWithHyphen(text) {
            return String(text || '')
                .toLowerCase()
                .split(' ')
                .map(function(word) {
                    return word
                        .split('-')
                        .map(function(part) {
                            if (!part) return part;
                            return part.charAt(0).toUpperCase() + part.slice(1);
                        })
                        .join('-');
                })
                .join(' ')
                .trim();
        }

        function showGiftByType(itemtype, itemname) {
            const normalizedType = String(itemtype || '');
            const safeName = itemname || '';

            $('#gift-banner-ewallet').addClass('hidden');
            $('#gift-banner-shopee').addClass('hidden');
            $('#wallet-field').addClass('hidden');
            $('#hp-msg').addClass('hidden');
            $('#wallet').val('');
            $('#wallet-msg').html('');
            $('#wallet').prop('required', false).removeClass('ring-2 ring-red-300');

            if (normalizedType === '1') {
                const displayName = titleCaseWithHyphen(safeName);
                $('#gift-banner-ewallet').removeClass('hidden');
                gsap.fromTo('#gift-banner-ewallet', { opacity: 0, y: -15 }, { opacity: 1, y: 0, duration: 0.35, ease: 'power2.out' });
                $('#wallet-field').removeClass('hidden');
                gsap.fromTo('#wallet-field', { opacity: 0, y: -10 }, { opacity: 1, y: 0, duration: 0.3, ease: 'power2.out', delay: 0.1 });
                $('#hp-msg').removeClass('hidden');
                gsap.fromTo('#hp-msg', { opacity: 0, y: -10 }, { opacity: 1, y: 0, duration: 0.3, ease: 'power2.out', delay: 0.15 });
                $('#wallet').prop('required', true);
                $('#gift-title-ewallet').text(displayName || 'E-Wallet');
                $('#ewallet-benefit-1').html(
                    `Saldo <span class="font-bold text-rose-100">${escapeHtml(displayName || safeName)}</span> langsung masuk ke akun E-Wallet Anda`
                );
                $('#gift-title-shopee').text(displayName || 'Voucher Shopee');
                $('#shopee-benefit-1').html(
                    `Voucher Shopee senilai <span class="font-bold text-orange-100">${escapeHtml(displayName || safeName)}</span> untuk digunakan di Official Store Illusions`
                );
            } else if (normalizedType === '2') {
                const displayName = titleCaseWithHyphen(safeName);
                $('#gift-banner-shopee').removeClass('hidden');
                gsap.fromTo('#gift-banner-shopee', { opacity: 0, y: -15 }, { opacity: 1, y: 0, duration: 0.35, ease: 'power2.out' });
                $('#gift-title-shopee').text(displayName || 'Voucher Shopee');
                $('#shopee-benefit-1').html(
                    `<span class="font-bold text-orange-100">${escapeHtml(displayName || safeName)}</span> untuk digunakan di Official Store Illusions`
                );
            } else {
                $('#gift-banner-ewallet').removeClass('hidden');
                gsap.fromTo('#gift-banner-ewallet', { opacity: 0, y: -15 }, { opacity: 1, y: 0, duration: 0.35, ease: 'power2.out' });
                $('#wallet-field').removeClass('hidden');
                gsap.fromTo('#wallet-field', { opacity: 0, y: -10 }, { opacity: 1, y: 0, duration: 0.3, ease: 'power2.out', delay: 0.1 });
            }
        }

        function normalizePhoneInput(value) {
            let phone = String(value || '')
                .replace(/\D/g, '');

            if (phone.startsWith('0')) {
                phone = phone.substring(1);
            }

            if (phone.startsWith('62')) {
                phone = phone.substring(2);
            }

            return phone;
        }

        function isValidPhoneNumber(value) {
            const phone = normalizePhoneInput(value);

            if (!phone.startsWith('8')) {
                return false;
            }

            if (phone.length < 9 || phone.length > 13) {
                return false;
            }

            if (!/^\d+$/.test(phone)) {
                return false;
            }

            const validPrefixes = [
                // Telkomsel
                '811', '812', '813', '821', '822', '851', '852', '853',
                // Indosat
                '814', '815', '816', '855', '856', '857', '858',
                // XL
                '817', '818', '819', '859', '877', '878',
                // Axis
                '831', '832', '833', '838',
                // Tri
                '895', '896', '897', '898', '899',
                // Smartfren
                '881', '882', '883', '884', '885', '886', '887', '888', '889'
            ];

            return validPrefixes.some(prefix => phone.startsWith(prefix));
        }

        function generateIdempotencyKey() {
            return 'claim-' + Date.now() + '-' + Math.random().toString(36).slice(2, 10);
        }

        function captureGeoLocation() {
            if (!navigator.geolocation) {
                return;
            }

            navigator.geolocation.getCurrentPosition(function(position) {
                $('#geo_lat').val(position.coords.latitude);
                $('#geo_long').val(position.coords.longitude);
            }, function() {
                $('#geo_lat').val('');
                $('#geo_long').val('');
            }, {
                enableHighAccuracy: false,
                timeout: 5000,
                maximumAge: 300000
            });
        }

        function loadCaptcha() {
            $('#captcha-image, #captcha-image-card').html('<span class="text-xs text-gray-500">Memuat captcha...</span>');
            $.ajax({
                url: BASE_URL + 'api/voucher/captcha',
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    if (res && res.success === true && res.data && res.data.image) {
                        $('#captcha-image, #captcha-image-card').html(res.data.image);
                        return;
                    }
                    $('#captcha-image, #captcha-image-card').html('<span class="text-xs text-red-200">Gagal memuat captcha</span>');
                },
                error: function() {
                    $('#captcha-image, #captcha-image-card').html('<span class="text-xs text-red-200">Gagal memuat captcha</span>');
                }
            });
        }

        function setCustomerFormLocked(locked) {
            $('#email').prop('readonly', locked);

            if (locked) {
                provinceChoice.disable();
                cityChoice.disable();
                districtChoice.disable();
            } else {
                provinceChoice.enable();
                cityChoice.enable();
                districtChoice.enable();
            }
        }

        function clearCustomerForm() {
            $('#custname').val('');
            $('#email').val('');
            provinceChoice.clearStore();
            provinceChoice.setChoices([{
                value: '',
                label: 'Pilih Provinsi',
                selected: true,
                disabled: true
            }], 'value', 'label', true);
            cityChoice.clearStore();
            cityChoice.setChoices([{
                value: '',
                label: 'Pilih Kota / Kabupaten',
                selected: true,
                disabled: true
            }], 'value', 'label', true);
            districtChoice.clearStore();
            districtChoice.setChoices([{
                value: '',
                label: 'Pilih Kecamatan',
                selected: true,
                disabled: true
            }], 'value', 'label', true);
            $('#mst_customerid').val('');
            $('#info-custname').text('-');
            $('#info-email').text('-');
            $('#info-domisili').text('-');
            setCustomerFormLocked(false);
        }

        function showCustomerForm(customer) {
            $('#customer-info-card').removeClass('hidden');
            $('#customer-form-wrapper').addClass('hidden');
            gsap.fromTo('#customer-info-card', { opacity: 0, y: 20 }, { opacity: 1, y: 0, duration: 0.4, ease: 'power2.out' });

            $('#info-custname').text(customer.custname || '-');
            $('#info-email').text(customer.email || '-');
            $('#info-domisili').text('Memuat...');
            setCustomerFormLocked(false);
            $('#custname').val(customer.custname || '');
            $('#email').val(customer.email || '');
            $('#mst_customerid').val(customer.mst_customerid || '');
            populateCustomerLocation(customer).then(function() {
                setCustomerFormLocked(true);
                var prov = getChoiceSelectedText(provinceChoice);
                var kota = getChoiceSelectedText(cityChoice);
                var kec = getChoiceSelectedText(districtChoice);
                var parts = [];
                if (kec && kec !== 'Pilih Kecamatan') parts.push(String(kec).trim());
                if (kota && kota !== 'Pilih Kota / Kabupaten') parts.push(String(kota).trim());
                if (prov && prov !== 'Pilih Provinsi') parts.push(String(prov).trim());
                $('#info-domisili').text(parts.length ? parts.join(', ') : '-');
            });
        }

        function showManualForm() {
            $('#customer-info-card').addClass('hidden');
            $('#customer-form-wrapper').removeClass('hidden');
            gsap.fromTo('#customer-form-wrapper', { opacity: 0, y: 20 }, { opacity: 1, y: 0, duration: 0.4, ease: 'power2.out' });
            clearCustomerForm();
            loadProvince();
        }

        function collectClaimPayload() {
            const payload = {
                idempotency_key: String($('#idempotency_key').val() || '').trim(),
                voucher_key: String($('#voucher_key').val() || '').trim(),
                phone_number: normalizePhoneInput($('#hp-input').val()),
                captcha_code: String(
                    ($('#customer-info-card:visible').length ?
                        $('#captcha_code_card') :
                        $('#captcha_code')
                    ).val() || ''
                ).trim(),
                wallet: String($('#wallet').val() || '').trim()
            };

            payload.geo_lat = String($('#geo_lat').val() || '').trim();
            payload.geo_long = String($('#geo_long').val() || '').trim();

            const customerId = String($('#mst_customerid').val() || '').trim();
            if (customerId) {
                payload.mst_customerid = customerId;
                return payload;
            }

            payload.custname = String($('#custname').val() || '').trim();
            payload.email = String($('#email').val() || '').trim();
            payload.mst_reg_provinceid = String(provinceChoice.getValue(true) || '').trim();
            payload.mst_reg_cityid = String(cityChoice.getValue(true) || '').trim();
            payload.mst_reg_districtid = String(districtChoice.getValue(true) || '').trim();

            return payload;
        }

        function validateClaimPayload(payload) {
            if (!payload.voucher_key) return 'Voucher key tidak tersedia.';
            if (!payload.phone_number) return 'Nomor HP tidak boleh kosong.';
            if (!payload.captcha_code) return 'Captcha wajib diisi.';
            if (isEwalletGift() && !payload.wallet) return 'Silahkan pilih e-wallet terlebih dahulu.';
            if (payload.mst_customerid) return '';
            if (!payload.custname) return 'Nama customer wajib diisi.';
            if (!payload.email) return 'Email wajib diisi.';
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(payload.email)) return 'Format email tidak valid.';
            if (!payload.mst_reg_provinceid) return 'Provinsi wajib dipilih.';
            if (!payload.mst_reg_cityid) return 'Kota / Kabupaten wajib dipilih.';
            if (!payload.mst_reg_districtid) return 'Kecamatan wajib dipilih.';
            return '';
        }

        function submitClaim() {
            const payload = collectClaimPayload();
            const errorMessage = validateClaimPayload(payload);

            if (errorMessage) {
                if (isEwalletGift() && !payload.wallet) {
                    $('#wallet-msg').html('<div class="text-xs text-amber-200">Silahkan pilih e-wallet terlebih dahulu.</div>');
                    $('#wallet').addClass('ring-2 ring-red-300');
                    $('#wallet').focus();
                }
                showToast(errorMessage, 'error');
                return;
            }

            showToast('Memproses klaim hadiah...', 'info');

            const formData = new FormData();
            if (csrfToken) formData.append(csrfName, csrfToken);
            Object.keys(payload).forEach(function(key) {
                formData.append(key, payload[key]);
            });

            const proofInput = document.getElementById('purchase_proof');
            if (proofInput && proofInput.files && proofInput.files[0]) {
                formData.append('purchase_proof', proofInput.files[0]);
            }

            $.ajax({
                url: BASE_URL + 'api/voucher/claim_gift',
                type: 'POST',
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('input, select, textarea, button').prop('disabled', true);
                    $.LoadingOverlay('show', {
                        background: 'rgba(0, 0, 0, 0.25)'
                    });
                },
                success: function(res) {
                    if (res && res.success === true) {
                        showToast('Hadiah berhasil diklaim.', 'success');
                        showScreen4();
                        return;
                    }

                    if (res && res.error_type === 'purchase_proof') {
                        showScreen2();
                        $('#customer-form-purchase-proof').removeClass('hidden');
                        $('#customer-info-card').addClass('hidden');
                        $('#customer-form-wrapper').addClass('hidden');
                        gsap.fromTo('#customer-form-purchase-proof', { opacity: 0, y: 20 }, { opacity: 1, y: 0, duration: 0.4, ease: 'power2.out' });
                        showToast(res.message || 'Gagal mengupload bukti pembelian.', 'error');
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                        return;
                    }

                    if (res && res.error_type === 'customer') {
                        showScreen2();
                        $('#customer-form-purchase-proof').addClass('hidden');
                        if (phoneCheckResult && phoneCheckResult.exists) {
                            $('#customer-info-card').removeClass('hidden');
                            $('#customer-form-wrapper').addClass('hidden');
                            gsap.fromTo('#customer-info-card', { opacity: 0, y: 20 }, { opacity: 1, y: 0, duration: 0.4, ease: 'power2.out' });
                        } else {
                            $('#customer-info-card').addClass('hidden');
                            $('#customer-form-wrapper').removeClass('hidden');
                            gsap.fromTo('#customer-form-wrapper', { opacity: 0, y: 20 }, { opacity: 1, y: 0, duration: 0.4, ease: 'power2.out' });
                        }
                        showToast(res.message || 'Data customer tidak valid.', 'error');
                        loadCaptcha();
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                        return;
                    }

                    showToast((res && res.message) ? res.message : 'Gagal mengklaim hadiah.', 'error');
                    loadCaptcha();
                },
                error: function() {
                    showToast('Gagal mengklaim hadiah. Silahkan coba lagi.', 'error');
                    loadCaptcha();
                },
                complete: function() {
                    $('input, select, textarea, button').prop('disabled', false);
                    $.LoadingOverlay('hide');
                }
            });
        }

        function cekHP() {
            const rawHp = normalizePhoneInput($('#hp-input').val());
            const msgEl = $('#hp-msg');

            if (!isValidPhoneNumber(rawHp)) {
                showToast('Nomor HP tidak valid.', 'error');
                return;
            }

            if (!rawHp) {
                showToast('Nomor HP tidak boleh kosong.', 'error');
                return;
            }

            if (rawHp.length > 13) {
                showToast('Nomor HP/Whatsapp maksimal 13 digit angka.', 'error');
                return;
            }

            $('#hp-input').val(rawHp);

            if (isEwalletGift()) {
                if (!String($('#wallet').val() || '').trim()) {
                    showToast('Silahkan pilih e-wallet terlebih dahulu.', 'error');
                    return;
                }

                $('#wallet-msg').html('');
                $('#wallet').removeClass('ring-2 ring-red-300');
            }

            var phoneData = { phone_number: rawHp };
            if (csrfToken) phoneData[csrfName] = csrfToken;

            $.ajax({
                url: BASE_URL + 'api/customer/check_phone',
                type: 'POST',
                dataType: 'json',
                data: phoneData,
                beforeSend: function() {
                    $('input, select, textarea, button').prop('disabled', true);
                    $.LoadingOverlay('show', {
                        background: 'rgba(122, 16, 40, 0.45)',
                        imageColor: '#ffffff',
                        fade: [200, 120],
                        zIndex: 9999
                    });
                },
                success: function(res) {
                    if (res && res.success === true && res.exists === true && res.data) {
                        showToast('Nomor ditemukan. Silahkan upload bukti pembelian.', 'success');
                        phoneCheckResult = { exists: true, data: res.data };
                    } else {
                        showToast('Nomor belum terdaftar. Silahkan upload bukti pembelian.', 'info');
                        phoneCheckResult = { exists: false, data: null };
                    }

                    showScreen2();
                    $('#customer-form-purchase-proof').removeClass('hidden');
                    $('#customer-info-card').addClass('hidden');
                    $('#customer-form-wrapper').addClass('hidden');
                    gsap.fromTo('#customer-form-purchase-proof', { opacity: 0, y: 20 }, { opacity: 1, y: 0, duration: 0.4, ease: 'power2.out' });
                },
                error: function() {
                    showToast('Gagal memeriksa nomor HP. Silahkan coba lagi.', 'error');
                    phoneCheckResult = { exists: false, data: null };
                    showScreen2();
                    $('#customer-form-purchase-proof').removeClass('hidden');
                    $('#customer-info-card').addClass('hidden');
                    $('#customer-form-wrapper').addClass('hidden');
                    gsap.fromTo('#customer-form-purchase-proof', { opacity: 0, y: 20 }, { opacity: 1, y: 0, duration: 0.4, ease: 'power2.out' });
                },
                complete: function() {
                    $('input, select, textarea, button').prop('disabled', false);
                    $.LoadingOverlay('hide');
                }
            });
        }

        function hideAllScreens() {
            $('#Screen-1, #Screen-2, #Screen-3, #Screen-4, #Screen-5').addClass('hidden').removeClass('flex');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function showScreen1() {
            hideAllScreens();
            $('#Screen-1').removeClass('hidden').addClass('flex');
            gsap.fromTo('#Screen-1', { opacity: 0, y: 30 }, { opacity: 1, y: 0, duration: 0.4, ease: 'power2.out' });
        }

        function showScreen2() {
            hideAllScreens();
            $('#Screen-2').removeClass('hidden').addClass('flex');
            gsap.fromTo('#Screen-2', { opacity: 0, y: 30 }, { opacity: 1, y: 0, duration: 0.4, ease: 'power2.out' });
        }

        function showScreen3() {
            hideAllScreens();
            $('#Screen-3').removeClass('hidden').addClass('flex');
            gsap.fromTo('#Screen-3', { opacity: 0, y: 30 }, { opacity: 1, y: 0, duration: 0.4, ease: 'power2.out' });
        }

        function showScreen4() {
            hideAllScreens();
            $('#Screen-4').removeClass('hidden').addClass('flex');

            // Toggle konten berdasarkan tipe hadiah
            var isShopee = String(voucherMeta.itemtype || '') === '2';
            $('#screen4-ewallet').toggleClass('hidden', isShopee);
            $('#screen4-shopee').toggleClass('hidden', !isShopee);

            gsap.fromTo('#Screen-4', { opacity: 0, y: 30 }, { opacity: 1, y: 0, duration: 0.4, ease: 'power2.out' });
            var icon = isShopee ? '#Screen-4 .fa-envelope' : '#Screen-4 .fa-check-circle';
            gsap.fromTo(icon, { scale: 0 }, { scale: 1, duration: 0.5, ease: 'back.out(1.7)', delay: 0.2 });
        }

        function showScreen5() {
            hideAllScreens();
            $('#Screen-5').removeClass('hidden').addClass('flex');
            gsap.fromTo('#Screen-5', { opacity: 0, y: 30 }, { opacity: 1, y: 0, duration: 0.4, ease: 'power2.out' });
            gsap.fromTo('#Screen-5 .fa-clock', { scale: 0 }, { scale: 1, duration: 0.5, ease: 'back.out(1.7)', delay: 0.2 });
        }

        // Init Document 
        $(document).ready(function() {
            provinceChoice = initChoice('#provinsi', 'Cari provinsi');
            cityChoice = initChoice('#kota', 'Cari kota');
            districtChoice = initChoice('#kecamatan', 'Cari kecamatan');

            const segments = window.location.pathname.split('/').filter(Boolean);
            const voucherKey = segments[segments.length - 1];
            $('#voucher_key').val(voucherKey);
            $('#idempotency_key').val(generateIdempotencyKey());
            captureGeoLocation();
            loadCaptcha();

            var postData = { voucher_key: voucherKey };
            if (csrfToken) postData[csrfName] = csrfToken;

            $.ajax({
                url: BASE_URL + 'api/voucher/verification',
                type: 'POST',
                dataType: 'json',
                data: postData,
                beforeSend: function() {
                    $('input, select, textarea, button').prop('disabled', true);
                    $.LoadingOverlay('show', {
                        background: 'rgba(122, 16, 40, 0.45)',
                        imageColor: '#ffffff',
                        fade: [200, 120],
                        zIndex: 9999
                    });
                },
                success: function(result) {
                    if (
                        result.success === true &&
                        result.verified === true &&
                        result.can_claim === true &&
                        String(result.data.status) === '1'
                    ) {
                        voucherMeta.itemtype = result.data.itemtype;
                        voucherMeta.itemname = result.data.itemname;
                        showGiftByType(result.data.itemtype, result.data.itemname);
                        showScreen1();
                        if (typeof anime !== 'undefined') {
                            $('#gift-scene').removeClass('hidden').addClass('flex');
                            startGiftAnimation();
                        } else {
                            $('#gift-scene').remove();
                        }
                    } else if (
                        result?.success === true &&
                        result?.data &&
                        (String(result.data.status) === '3' || String(result.data.status) === '4')
                    ) {
                        showScreen5();
                    } else {
                        showScreen3();
                    }
                },
                error: function() {
                    showScreen3();
                },
                complete: function() {
                    $('input, select, textarea, button').prop('disabled', false);
                    $.LoadingOverlay('hide');
                }
            });

            $('#hp-input').on('input', function() {
                this.value = normalizePhoneInput(this.value);
            });
            setCustomerFormLocked(false);

            document.getElementById('provinsi').addEventListener('change', function(event) {
                const provinceid = event.detail?.value || this.value;

                if (provinceid) {
                    loadCity(provinceid);
                }
            });

            document.getElementById('kota').addEventListener('change', function(event) {
                const cityid = event.detail?.value || this.value;

                if (cityid) {
                    loadDistrict(cityid);
                }
            });

            showScreen1();
            loadProvince();
        });
    </script>

</body>

</html>
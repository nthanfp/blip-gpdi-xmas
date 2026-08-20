<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
</head>

<body style="font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #fff; border-radius: 8px; overflow: hidden;">
        <div style="text-align:center; background:#9F1D35;">
            <img src="https://qrtag.internalgroup.id/assets/images/header-illusions.png" alt="Illusions" style=" width:100%; max-width:600px; display:block; border:0; ">
            <div style="background:#ffffff; padding:24px 24px 12px 24px; text-align:center; ">
                <h2 style="margin:0; font-size:24px; line-height:25px; color:#7A1026; font-weight:700; letter-spacing:-0.8px; ">
                    Hadiah Telah Dikirimkan
                </h2>
                <p style=" margin:8px 0 0 0; color:#777; font-size:14px; ">
                    Terima kasih atas partisipasi Anda.
                </p>
            </div>
        </div>
        <div style="padding: 24px;">
            <p>Halo <strong><?php echo htmlspecialchars($custname ?? '-', ENT_QUOTES, 'UTF-8'); ?></strong>,</p>
            <p>Selamat! Hadiah Anda telah berhasil diproses sebagai bagian dari program <span style="font-style: italic;">Hoki Beli Illusions</span> by Internal Grup.</p>
            <table style="width: 100%; border-collapse: collapse; margin: 16px 0;">
                <tr>
                    <td style="padding: 8px; border-bottom: 1px solid #eee; color: #666;">Hadiah</td>
                    <td style="padding: 8px; border-bottom: 1px solid #eee; font-weight: bold;">
                        <?php echo htmlspecialchars($itemname ?? '-', ENT_QUOTES, 'UTF-8'); ?> (<?= htmlspecialchars($description ?? '', ENT_QUOTES, 'UTF-8') ?>)
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px; border-bottom: 1px solid #eee; color: #666;">No E-Wallet</td>
                    <td style="padding: 8px; border-bottom: 1px solid #eee; font-weight: bold;"><?= htmlspecialchars($customer_phone ?? '', ENT_QUOTES, 'UTF-8') ?> </td>
                </tr>
                <tr>
                    <td style="padding: 8px; color: #666;">Tanggal Proses</td>
                    <td style="padding: 8px; font-weight: bold;">
                        <?php echo htmlspecialchars($completed_date ?? '-', ENT_QUOTES, 'UTF-8'); ?> WIB
                    </td>
                </tr>
            </table>
            <p>Terima kasih telah berbelanja produk <strong>Illusions</strong> by <strong>Internal Grup</strong>.</p>
            <div style="margin-top:24px; padding:16px; background:#f8f9fa; border:1px solid #eee; border-radius:8px;">
                <p style="color: #999; font-size: 12px;">
                    Jika terdapat pertanyaan terkait hadiah atau proses redeem, silakan hubungi tim Internal Grup melalui
                    <a href="mailto:<?= htmlspecialchars($cs_email ?? 'support@internalgroup.id', ENT_QUOTES, 'UTF-8') ?>">
                        <?= htmlspecialchars($cs_email ?? 'support@internalgroup.id', ENT_QUOTES, 'UTF-8') ?>
                    </a> atau
                    <a href="https://wa.me/<?= htmlspecialchars($cs_phone ?? '6285646877046', ENT_QUOTES, 'UTF-8') ?>" target="_blank">
                        <?php $_p = $cs_phone ?? '6285646877046';
                        echo '+62 ' . substr($_p, 2, 3) . ' ' . substr($_p, 5, 4) . ' ' . substr($_p, 9, 4); ?>
                    </a>
                </p>
                <p style="color: #999; font-size: 12px;">
                    Email ini merupakan notifikasi otomatis dari sistem Internal Grup. Mohon tidak membalas email ini. Jika Anda bukan penerima yang dimaksud, harap abaikan email ini.
                </p>
            </div>
        </div>
    </div>
</body>

</html>
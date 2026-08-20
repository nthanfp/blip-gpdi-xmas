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
                    Klaim Hadiah Berhasil
                </h2>
                <!-- <p style=" margin:8px 0 0 0; color:#777; font-size:14px; ">
                    Terima kasih telah melakukan klaim hadiah.
                </p> -->
            </div>
        </div>
        <div style="padding: 24px;">
            <p>Halo <strong><?= htmlspecialchars($custname ?? '-', ENT_QUOTES, 'UTF-8') ?></strong>,</p>
            <p>Terima kasih! Hadiah Anda berhasil diklaim.</p>
            <table style="width: 100%; border-collapse: collapse; margin: 16px 0;">
                <tr>
                    <td style="padding: 8px; border-bottom: 1px solid #eee; color: #666;">Hadiah</td>
                    <td style="padding: 8px; border-bottom: 1px solid #eee; font-weight: bold;"> <?= htmlspecialchars($itemname ?? '-', ENT_QUOTES, 'UTF-8') ?> (<?= htmlspecialchars($description ?? '', ENT_QUOTES, 'UTF-8') ?>)</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border-bottom: 1px solid #eee; color: #666;">No E-Wallet</td>
                    <td style="padding: 8px; border-bottom: 1px solid #eee; font-weight: bold;"><?= htmlspecialchars($customer_phone ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px; color: #666;">Tanggal Klaim</td>
                    <td style="padding: 8px; font-weight: bold;"> <?= htmlspecialchars($redeemed_date ?? '-', ENT_QUOTES, 'UTF-8') ?> WIB</td>
                </tr>
            </table>
            <div style="background: #fff3cd; border: 1px solid #ffeeba; border-radius: 8px; padding: 14px; margin: 16px 0;">
                <p style="margin: 0; color: #856404; font-size: 14px;">
                    Hadiah akan diproses dalam maksimal <strong>7x24 jam</strong> setelah verifikasi data dan bukti pembelian.
                    <!-- Tim kami akan menghubungi Anda melalui WhatsApp untuk informasi lebih lanjut. -->
                </p>
            </div>
            <p style="color: #999; font-size: 12px;">
                Email ini merupakan notifikasi otomatis dari sistem Internal Grup. Mohon tidak membalas email ini. Jika Anda bukan penerima yang dimaksud, harap abaikan email ini.
            </p>
        </div>
    </div>
</body>

</html>
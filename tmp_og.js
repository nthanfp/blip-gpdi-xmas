const { webkit } = require('playwright');

(async () => {
    const browser = await webkit.launch();
    const ctx = await browser.newContext({
        viewport: { width: 960, height: 1280 },   // 3:4, masih <1024 (layout mobile hero aktif)
        deviceScaleFactor: 2,
        userAgent: 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.0 Mobile/15E148 Safari/604.1'
    });
    const page = await ctx.newPage();
    await page.goto('http://localhost/blip-gpdi-xmas/', { waitUntil: 'networkidle', timeout: 45000 });

    // sembunyikan tombol musik & elemen fixed lain di luar hero
    await page.addStyleTag({ content: `
        #xmas-music-btn, #xmas-audio, .notif-fab, #btn-top { display: none !important; }
    `});
    await page.waitForTimeout(1500); // tunggu animasi masuk selesai

    const hero = await page.$('section.lg\\:hidden');
    const box = await hero.boundingBox();
    console.log('hero box:', JSON.stringify(box));
    await hero.screenshot({ path: 'tmp_og_hero.png' });
    console.log('saved tmp_og_hero.png');
    await browser.close();
})();

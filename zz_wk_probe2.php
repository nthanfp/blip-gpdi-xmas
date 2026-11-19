<?php
// TEMPORARY probe2 — delete after use
$bin = getcwd() . '/wkhtmltopdf/wkhtmltopdf.linux';
$env = 'HOME=/tmp FONTCONFIG_CACHE=/tmp/fontconfig-cache ';
@mkdir('/tmp/fontconfig-cache', 0777, true);

$tests = [
    'https' => 'https://natal.gpdikopopermai.my.id/index.php/activities/authentication/login',
    'http-host' => 'http://natal.gpdikopopermai.my.id/index.php/activities/authentication/login',
    'http-127' => 'http://127.0.0.1/index.php/activities/authentication/login',
];

foreach ($tests as $name => $url) {
    $out = tempnam('/tmp', 'p_');
    $cmd = $env . '"' . $bin . '" --no-stop-slow-scripts --page-size A4 --quiet '
        . escapeshellarg($url) . ' ' . escapeshellarg($out) . ' 2>&1';
    $lines = [];
    $ret = 0;
    exec($cmd, $lines, $ret);
    $size = file_exists($out) ? filesize($out) : -1;
    $head = file_exists($out) ? substr(file_get_contents($out), 0, 5) : '';
    echo "[$name] ret=$ret size=$size head=$head\n";
    if ($lines) echo '  err: ' . implode(' | ', array_slice($lines, 0, 4)) . "\n";
    @unlink($out);
}

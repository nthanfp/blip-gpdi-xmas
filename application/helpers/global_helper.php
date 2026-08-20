<?php

function topdf($pages, $header = '', $top = 10, $ls = 0, $printA5 = 0, $report = 0, $username = 'Unknown')
{
    // Use local URL for wkhtmltopdf (not ngrok)
    $local_base = 'http://192.168.10.130:8080/itg-gift/';
    $ngrok_pattern = '/https?:\/\/[^\/]+\.ngrok[-\.]free\.app\/itg-gift\//';
    $pages = preg_replace($ngrok_pattern, $local_base, $pages);
    $header = preg_replace($ngrok_pattern, $local_base, $header);

    $db_aktif = isset($_SESSION['db_aktif']) ? $_SESSION['db_aktif'] : '';

    if (!empty($db_aktif)) {
        if (!strpos($pages, '?')) {
            $pages = $pages . '?dbnya=' . $db_aktif;
        } else {
            $pages = $pages . '&dbnya=' . $db_aktif;
        }
    }
    $printtoday = 'Printed by : ' . $username . ' ' . date("j F Y, H:i:s");

    if ($header != '') {
        if (!empty($db_aktif)) {
            if ($header != '' && !strpos($header, '?')) {
                $header = $header . '?dbnya=' . $db_aktif;
            } else {
                $header = $header . '&dbnya=' . $db_aktif;
            }
        }
    }

    $landscape = '';
    $zoom = '';
    if ($ls == 1) {
        $landscape = ' --orientation landscape';
        $zoom = '--zoom 0.98';
    }

    $papersize = ($printA5 == 1) ? 'A5' : 'A4';

    $sys = strtoupper(PHP_OS);
    $os = (substr($sys, 0, 3) == "WIN") ? "WIN" : strtoupper($sys);

    $output = '';
    if ($os == 'WIN') {
        $output = tempnam(ini_get('upload_tmp_dir'), mt_rand());
        $command = array();
        $cwd = getcwd();

        $session_cookie_name = getenv('SESSION_COOKIE_NAME') ?: 'itg_ci3_boiler_admin';
        $session_id = session_id();

        $command[] = '"' . $cwd . '/wkhtmltopdf/wkhtmltopdf' . '"';
        if (!empty($session_id)) {
            $command[] = '--cookie ' . $session_cookie_name . ' ' . $session_id;
        }
        $command[] = '--debug-javascript --no-stop-slow-scripts --page-size ' . $papersize;
        $command[] = '--header-html ' . escapeshellarg($header) . ' --margin-top ' . $top . 'mm  --margin-left 10mm  --margin-right 7mm ' . $zoom;
        $command[] = '--footer-right "[page]/[toPage]" --footer-line --footer-font-size 8 --footer-font-name Geneva ' . $landscape . ' --quiet --margin-bottom 13mm';
        $command[] = '--footer-left "' . $printtoday . '" --footer-line --footer-font-size 8 --footer-font-name Geneva ' . $landscape . ' --quiet --margin-bottom 13mm';
        $command[] = escapeshellarg($pages);
        $command[] = escapeshellarg($output);

        session_write_close();
        if (defined('STDOUT') && is_resource(STDOUT)) {
            fclose(STDOUT);
        }
        if (defined('STDIN') && is_resource(STDIN)) {
            fclose(STDIN);
        }
        if (defined('STDERR') && is_resource(STDERR)) {
            fclose(STDERR);
        }
        system(implode(' ', $command) . ' 2>&1', $return);

        if ($return !== 0 || !file_exists($output) || filesize($output) === 0) {
            header('Content-Type: text/plain');
            echo "PDF Generation Failed!\n";
            echo "Return code: " . (int) $return . "\n";
            echo "Session ID: " . htmlspecialchars($session_id ?: '(empty)', ENT_QUOTES, 'UTF-8') . "\n";
            echo "Command:\n" . htmlspecialchars(implode(" \\\n", $command), ENT_QUOTES, 'UTF-8') . "\n";
            echo "\nPages: " . htmlspecialchars($pages, ENT_QUOTES, 'UTF-8') . "\n";
            echo "Header: " . htmlspecialchars($header, ENT_QUOTES, 'UTF-8') . "\n";
            exit;
        }
    } else if ($os == 'LINUX') {
        $output = tempnam(sys_get_temp_dir(), 'pdf_');
        $cwd = getcwd();
        $wkhtmltopdf = $cwd . '/wkhtmltopdf/wkhtmltopdf';
        if (!file_exists($wkhtmltopdf)) {
            $wkhtmltopdf = 'wkhtmltopdf';
        }

        $session_cookie_name = getenv('SESSION_COOKIE_NAME') ?: 'itg_ci3_boiler_admin';
        $session_id = session_id();

        $command = '"' . $wkhtmltopdf . '"';
        if (!empty($session_id)) {
            $command .= ' --cookie ' . $session_cookie_name . ' ' . $session_id;
        }
        $command .= ' --no-stop-slow-scripts --page-size ' . $papersize;
        if (!empty($header)) {
            $command .= ' --header-html ' . escapeshellarg($header) . ' --margin-top ' . $top . 'mm';
        }
        $command .= ' --margin-left 10mm --margin-right 7mm ' . $zoom;
        $command .= ' --footer-right "[page]/[toPage]" --footer-line --footer-font-size 8 --footer-font-name Geneva ' . $landscape . ' --quiet --margin-bottom 13mm';
        $command .= ' --footer-left "' . $printtoday . '" --footer-line --footer-font-size 8 --footer-font-name Geneva ' . $landscape . ' --quiet --margin-bottom 13mm';
        $command .= ' ' . escapeshellarg($pages);
        $command .= ' ' . escapeshellarg($output);

        session_write_close();
        if (defined('STDOUT') && is_resource(STDOUT)) {
            fclose(STDOUT);
        }
        if (defined('STDIN') && is_resource(STDIN)) {
            fclose(STDIN);
        }
        if (defined('STDERR') && is_resource(STDERR)) {
            fclose(STDERR);
        }
        system($command . ' 2>&1', $return);

        if ($return !== 0 || !file_exists($output) || filesize($output) === 0) {
            header('Content-Type: text/plain');
            echo "PDF Generation Failed!\n";
            echo "Return code: " . (int) $return . "\n";
            echo "Session ID: " . htmlspecialchars($session_id ?: '(empty)', ENT_QUOTES, 'UTF-8') . "\n";
            echo "Command:\n" . htmlspecialchars($command, ENT_QUOTES, 'UTF-8') . "\n";
            echo "\nPages: " . htmlspecialchars($pages, ENT_QUOTES, 'UTF-8') . "\n";
            echo "Header: " . htmlspecialchars($header, ENT_QUOTES, 'UTF-8') . "\n";
            exit;
        }
    } else {
        $output = tempnam(ini_get('upload_tmp_dir'), mt_rand());
        $command = array();
        $cwd = getcwd();

        $session_cookie_name = getenv('SESSION_COOKIE_NAME') ?: 'itg_ci3_boiler_admin';
        $session_id = session_id();

        $command[] = "cd /Applications/wkhtmltopdf.app/Contents/MacOS/;";
        $command[] = 'DYLD_LIBRARY_PATH="";';
        $command[] = "./wkhtmltopdf ";
        if (!empty($session_id)) {
            $command[] = '--cookie ' . $session_cookie_name . ' ' . $session_id;
        }
        $command[] = '--page-size ' . $papersize;
        $command[] = '--header-html ' . escapeshellarg($header) . ' --margin-top ' . $top . 'mm ';
        $command[] = '--footer-right "[page]/[toPage]" --footer-line --footer-font-size 8 ' . $landscape . ' --quiet';
        $command[] = escapeshellarg($pages);
        $command[] = escapeshellarg($output);

        session_write_close();
        if (defined('STDOUT') && is_resource(STDOUT)) {
            fclose(STDOUT);
        }
        if (defined('STDIN') && is_resource(STDIN)) {
            fclose(STDIN);
        }
        if (defined('STDERR') && is_resource(STDERR)) {
            fclose(STDERR);
        }
        system(implode(' ', $command) . ' 2>&1', $return);
    }

    ini_set('output_buffering', 'on');
    $pdf = file_get_contents($output);
    header('Content-Type: application/pdf');
    header('Cache-Control: public, must-revalidate, max-age=0');
    header('Pragma: public');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Content-Length: ' . strlen($pdf));
    ob_clean();
    flush();

    echo $pdf;
}

// convert nilai uang minus jadi ada kurung
function money_to_view($amount, $simbol = '')
{

    if ($amount == '' || $amount == 'null') {
        $amount = 0;
    }
    $amount = round($amount, 2);
    if ($amount < 0) {
        $amount = $amount * -1;
        if ($simbol == '') {
            $amount = "(" . number_format($amount, 2, '.', ',') . ")";
        } else {
            $amount = "(" . $simbol . ' ' . number_format($amount, 2, '.', ',') . ")";
        }
    } else if ($amount > 0) {
        $amount = $simbol . ' ' . number_format($amount, 2, '.', ',');
    } else {
        $amount = '-';
    }
    return $amount;
}

// convert nilai minus jadi ada kurung
function value_to_view($amount, $des = 2)
{
    $amount = round($amount, $des);
    if ($amount < 0) {
        $amount = $amount * -1;
        $amount = number_format($amount, $des, '.', ',');
        $amount = "(" . $amount . ")";
    } else if ($amount == '' || $amount == 0) {
        //$amount = '&nbsp;';
        $amount = '-';
    } else {
        $amount = number_format($amount, $des, '.', ',');
    }
    return $amount;
}

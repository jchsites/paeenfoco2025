<?php
// ============================================================
// Moodle configuration file - Versão ajustada com Token Bypass
// Gerado: 2025
// ============================================================

unset($CFG);
global $CFG;
$CFG = new stdClass();

// ------------------------------------------------------------
// 🗄️ Configurações do Banco de Dados
// ------------------------------------------------------------
$CFG->dbtype    = 'mysqli';
$CFG->dblibrary = 'native';
$CFG->dbhost    = 'localhost';
$CFG->dbname    = 'paee_moodle';
$CFG->dbuser    = 'paee_moodle';
$CFG->dbpass    = 'Jch@909294';
$CFG->prefix    = 'mdl_';
$CFG->dboptions = array(
    'dbpersist'   => 0,
    'dbport'      => '',
    'dbsocket'    => '',
    'dbcollation' => 'utf8mb4_0900_ai_ci',
);

// ------------------------------------------------------------
// 🌐 Configurações do Site
// ------------------------------------------------------------
$CFG->wwwroot  = 'https://paeenfoco2025.org';
$CFG->dataroot = '/home/paee/moodledata';
$CFG->admin    = 'admin';
$CFG->directorypermissions = 0777;

// ------------------------------------------------------------
// 🧩 Modo de Depuração (desativado por padrão)
// ------------------------------------------------------------
// unset($CFG->alternateloginurl);
// @error_reporting(E_ALL | E_STRICT);
// @ini_set('display_errors', '1');
// $CFG->debug = (E_ALL | E_STRICT);
// $CFG->debugdisplay = 1;

// ============================================================
// 🔐 BYPASS POR TOKEN SECRETO (execução ANTES do bloqueio)
// ============================================================
//
// Como usar:
// 1) Defina SECRET_TOKEN abaixo (atualmente: '@2025').
// 2) Acesse: https://paeenfoco2025.org/?site_secret=@2025
//    - O script cria um cookie seguro por 1 hora para evitar repetir o token.
// 3) Enquanto o cookie existir ou o token for fornecido, o bloqueio não será aplicado.
// ============================================================

define('SECRET_TOKEN', '@2025'); // <-- altere para um token mais seguro se desejar
$token_param_name = 'site_secret';

// pega token via GET ou cookie
$provided_token = $_GET[$token_param_name] ?? $_COOKIE[$token_param_name] ?? '';

// comparação segura (hash_equals quando disponível)
$bypass_token_ok = false;
if (!empty($provided_token) && !empty(SECRET_TOKEN)) {
    if (function_exists('hash_equals')) {
        $bypass_token_ok = hash_equals(SECRET_TOKEN, $provided_token);
    } else {
        $bypass_token_ok = (SECRET_TOKEN === $provided_token);
    }
}

// se token veio por GET e válido, define cookie seguro por 1 hora
if ($bypass_token_ok && isset($_GET[$token_param_name])) {
    $cookie_lifetime = 3600; // segundos (1 hora) - ajuste se quiser outro tempo
    $cookie_name = $token_param_name;
    $cookie_value = SECRET_TOKEN;

    // configurações do cookie
    $cookie_opts = [
        'expires'  => time() + $cookie_lifetime,
        'path'     => '/',
        // 'domain' => $_SERVER['HTTP_HOST'] ?? '', // opcional: deixe vazio para host atual
        'secure'   => true,   // exige HTTPS
        'httponly' => true,
        'samesite' => 'Lax'
    ];

    // Ajuste domain somente se tiver um host sem porta
    $host = $_SERVER['HTTP_HOST'] ?? '';
    // remove porta caso exista
    $host_no_port = preg_replace('/:\d+$/', '', $host);
    if (!empty($host_no_port)) {
        $cookie_opts['domain'] = $host_no_port;
    }

    if (PHP_VERSION_ID >= 70300) {
        // PHP >= 7.3 aceita array de opções
        setcookie($cookie_name, $cookie_value, $cookie_opts);
    } else {
        // fallback simples para PHP < 7.3
        setcookie($cookie_name, $cookie_value, time() + $cookie_lifetime, '/');
    }
}

// ============================================================
// 🔒 BLOQUEIO AUTOMÁTICO DO SITE MOODLE (checa data/hora)
// ============================================================
// Data e hora do bloqueio: 16/10/2025 às 03:00 (horário de Brasília)
date_default_timezone_set('America/Sao_Paulo');
$bloqueio = strtotime('2025-10-16 03:00:00');
$agora = time();

if ($agora >= $bloqueio) {
    // se o token não for válido (cookie ou GET), aplicar bloqueio
    if (!$bypass_token_ok) {

        // Página de aviso (HTML)
        echo '<!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Plataforma no disponible</title>
            <meta name="viewport" content="width=device-width,initial-scale=1">
            <style>
                body {
                    font-family: Arial, sans-serif;
                    text-align: center;
                    background: #f5f5f5;
                    color: #333;
                    margin: 0;
                    padding: 0;
                }
                .container {
                    max-width: 900px;
                    margin: 60px auto;
                    background: #fff;
                    padding: 36px;
                    border-radius: 12px;
                    box-shadow: 0 0 18px rgba(0,0,0,0.08);
                }
                .logo-box img { max-width: 320px; margin-bottom: 18px; }
                h2 { color: #b00; margin: 10px 0 18px; }
                p { font-size: 18px; line-height: 1.6; margin: 12px 0; }
                .org-box { margin-top: 28px; padding-top: 18px; border-top: 1px solid #eee; }
                .org-box img { max-width: 800px; height: auto; display: block; margin: 12px auto 0; }
                @media (max-width:600px) {
                  .container { margin: 20px; padding: 20px; }
                  p { font-size: 16px; }
                }
            </style>
        </head>
        <body>
            <div class="container" role="main" aria-labelledby="main-title">
                <div class="logo-box" aria-hidden="true">
                    <img src="/img/logo-paeenfoco_.jpg" alt="Logo PAE en Foco 2025">
                </div>

                <h2 id="main-title">🚫 Plataforma no disponible</h2>

                <p>El ciclo de intercambio <strong>PAE en Foco 2025</strong> ha finalizado exitosamente. Agradecemos su participación, compromiso y entusiasmo a lo largo de todas las sesiones.</p>

                <p>La plataforma se encuentra cerrada y ya no está disponible para el acceso a los contenidos ni para la descarga de materiales o certificados.</p>

                <p><strong>¡Manténgase atento a futuras oportunidades de formación y nuevos ciclos de intercambio!</strong></p>

                <div class="org-box" aria-hidden="true">
                    <h3 style="margin:0 0 8px;color:#000">Organización:</h3>
                    <img src="/img/-_FNDE ESP .jpg" alt="Organizadores">
                </div>
            </div>
        </body>
        </html>';
        exit;
    }
    // se bypass_token_ok = true, o visitante continua (sem bloqueio)
}

// ------------------------------------------------------------
// ⚙️ Inicialização do Moodle (carrega o núcleo)
// ------------------------------------------------------------
require_once(__DIR__ . '/lib/setup.php');

// ------------------------------------------------------------
// Observação: não colocar tag de fechamento PHP para evitar
// problemas com espaços em branco no final do arquivo.
// ------------------------------------------------------------

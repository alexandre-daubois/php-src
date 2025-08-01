--TEST--
GH-19134: Stream context options override OpenSSL INI settings
--EXTENSIONS--
openssl
--SKIPIF--
<?php
if (!function_exists("proc_open")) die("skip no proc_open");
?>
--INI--
openssl.verify_peer=0
openssl.allow_self_signed=1
--FILE--
<?php
$certFile = __DIR__ . DIRECTORY_SEPARATOR . 'gh19134_priority_test.pem.tmp';

$serverCode = <<<'CODE'
    $serverUri = "ssl://127.0.0.1:0";
    $serverFlags = STREAM_SERVER_BIND | STREAM_SERVER_LISTEN;
    $serverCtx = stream_context_create(['ssl' => [
        'local_cert' => '%s'
    ]]);

    $server = stream_socket_server($serverUri, $errno, $errstr, $serverFlags, $serverCtx);
    phpt_notify_server_start($server);

    for ($i = 0; $i < 2; $i++) {
        @stream_socket_accept($server, 2);
    }
CODE;
$serverCode = sprintf($serverCode, $certFile);

$clientCode = <<<'CODE'
    $serverUri = "ssl://{{ ADDR }}";
    $clientFlags = STREAM_CLIENT_CONNECT;
    
    echo "openssl.verify_peer: " . ini_get('openssl.verify_peer') . "\n";
    echo "openssl.allow_self_signed: " . ini_get('openssl.allow_self_signed') . "\n";
    
    $result1 = @stream_socket_client($serverUri, $errno, $errstr, 1, $clientFlags);
    echo "Connection with INI defaults: " . ($result1 ? "SUCCESS" : "FAILED") . "\n";
    if ($result1) {
        fclose($result1);
    }
    
    // Enable verification in context despite INI having it disabled
    $clientCtx = stream_context_create(['ssl' => [
        'verify_peer' => true,
        'verify_peer_name' => true,
    ]]);
    $result2 = @stream_socket_client($serverUri, $errno, $errstr, 1, $clientFlags, $clientCtx);
    echo "Connection with context verify_peer=true: " . ($result2 ? "SUCCESS" : "FAILED") . "\n";
    if ($result2) {
        fclose($result2);
    }
CODE;

include 'CertificateGenerator.inc';

$certificateGenerator = new CertificateGenerator(true);
$certificateGenerator->saveNewCertAsFileWithKey('test.invalid', $certFile);

include 'ServerClientTestCase.inc';
ServerClientTestCase::getInstance()->run($clientCode, $serverCode);
?>
--CLEAN--
<?php
@unlink(__DIR__ . DIRECTORY_SEPARATOR . 'gh19134_priority_test.pem.tmp');
?>
--EXPECT--
openssl.verify_peer: 0
openssl.allow_self_signed: 1
Connection with INI defaults: SUCCESS
Connection with context verify_peer=true: FAILED
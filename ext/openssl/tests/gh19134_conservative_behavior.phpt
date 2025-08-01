--TEST--
GH-19134: OpenSSL INI options have conservative behavior
--EXTENSIONS--
openssl
--SKIPIF--
<?php
if (!function_exists("proc_open")) die("skip no proc_open");
?>
--INI--
openssl.allow_self_signed=1
--FILE--
<?php
$certFile = __DIR__ . DIRECTORY_SEPARATOR . 'gh19134_conservative.pem.tmp';

$serverCode = <<<'CODE'
    $serverUri = "ssl://127.0.0.1:0";
    $serverFlags = STREAM_SERVER_BIND | STREAM_SERVER_LISTEN;
    $serverCtx = stream_context_create(['ssl' => [
        'local_cert' => '%s'
    ]]);

    $server = stream_socket_server($serverUri, $errno, $errstr, $serverFlags, $serverCtx);
    phpt_notify_server_start($server);

    @stream_socket_accept($server, 1);
CODE;
$serverCode = sprintf($serverCode, $certFile);

$clientCode = <<<'CODE'
    $serverUri = "ssl://{{ ADDR }}";
    $clientFlags = STREAM_CLIENT_CONNECT;
    
    echo "INI values:\n";
    echo "openssl.allow_self_signed: \"" . ini_get('openssl.allow_self_signed') . "\"\n";
    echo "openssl.verify_peer: \"" . ini_get('openssl.verify_peer') . "\"\n";
    echo "openssl.verify_peer_name: \"" . ini_get('openssl.verify_peer_name') . "\"\n";
    
    // Test that allow_self_signed INI setting works when verification is active
    // This should succeed because we set allow_self_signed=1 in INI and the certificate is self-signed
    $result = @stream_socket_client($serverUri, $errno, $errstr, 1, $clientFlags);
    echo "Connection without context (should succeed with self-signed cert): " . ($result ? "SUCCESS" : "FAILED") . "\n";
    if ($result) {
        fclose($result);
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
@unlink(__DIR__ . DIRECTORY_SEPARATOR . 'gh19134_conservative.pem.tmp');
?>
--EXPECT--
INI values:
openssl.allow_self_signed: "1"
openssl.verify_peer: ""
openssl.verify_peer_name: ""
Connection without context (should succeed with self-signed cert): SUCCESS
#!/usr/bin/php -q
<?php
## 메인소켓 준비 ############################################################
$main_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_set_option($main_socket, SOL_SOCKET, SO_REUSEADDR, 1);
socket_bind($main_socket, '192.168.56.2', '5882');
socket_listen($main_socket);
#########################################################################

$socket_list = array('main' => $main_socket);
$handshake_check = array();

while (true) {
    ## 소켓 상태변경 감지 ####################################################
    $read_socket_list = $socket_list;
    $result = socket_select($read_socket_list, $write = NULL, $except = NULL, NULL);
    if ($result === false) {
        break;
    }
    #####################################################################

    foreach ($read_socket_list as $read_socket) {
        if ($read_socket == $main_socket) {
            ## 요청 수락 ##################################################
            $sub_socket = socket_accept($main_socket);

            socket_getpeername($sub_socket, $addr, $port);
            $addr_port = "{$addr}:{$port}";

            $socket_list[$addr_port] = $sub_socket;

            echo "<{$addr_port}>[Connect]\n";
            #############################################################
        } else {
            socket_getpeername($read_socket, $addr, $port);
            $addr_port = "{$addr}:{$port}";

            if (! isset($handshake_check[$addr_port])) {
                ## 핸드쉐이크 ##############################################
                handshake($read_socket);
                $handshake_check[$addr_port] = true;
                #########################################################
            } else {
                $bytes = socket_recv($read_socket, $buffer, 2048, 0);
                /* 바이트 값을 하나씩 출력
                for ($i = 0; $i < strlen($buffer); $i++) {
                    echo ord($buffer[$i]).',';
                }
                echo "\n";
                */

                if (
                    $bytes === false
                    || (ord($buffer[0]) & 15) == 8 // 종료 신호
                ) {
                    ## 연결종료 ###########################################
                    unset($socket_list[$addr_port]);
                    unset($handshake_check[$addr_port]);

                    socket_close($read_socket);

                    echo "<{$addr_port}>[Close]\n";
                    #####################################################
                } else {
                    ## 메시지전달 ##########################################
                    $msg = unmask($buffer);

                    $echo_msg = mask("ECHO: {$msg}");
                    socket_write($read_socket, $echo_msg);

                    echo "<{$addr_port}>: {$msg}\n";
                    #####################################################
                }
            } // end if
        } // end if
    } // end foreach
} // end while

function parse_header($str)
{
    $str = preg_replace('/\r/', '', $str);

    preg_match_all('/^([^:\n]+): (.*)$/m', $str, $matches);

    $header_list = array();
    foreach ($matches[1] as $i => $key) {
        $header_list[$key] = $matches[2][$i];
    }

    return $header_list;
}

function handshake($socket)
{
    $bytes = socket_recv($socket, $buffer, 2048, 0);

    $header_list = parse_header($buffer);

    $accept = $header_list['Sec-WebSocket-Key'] . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11';
    $accept = base64_encode(sha1($accept, true));

    $upgrade = array(
        'HTTP/1.1 101 Switching Protocols',
        'Upgrade: websocket',
        'Connection: Upgrade',
        "Sec-WebSocket-Accept: {$accept}",
        "WebSocket-Origin: {$header_list['Origin']}",
        "WebSocket-Location: ws://{$header_list['Host']}/ws/server.php",
        "\r\n",
    );

    $upgrade = implode("\r\n", $upgrade);

    socket_write($socket, $upgrade);
}

function unmask($payload)
{
    $length = ord($payload[1]) & 127;

    if ($length == 126) {
        $masks = substr($payload, 4, 4);
        $data = substr($payload, 8);
    } elseif ($length == 127) {
        $masks = substr($payload, 10, 4);
        $data = substr($payload, 14);
    } else {
        $masks = substr($payload, 2, 4);
        $data = substr($payload, 6);
    }

    $text = '';
    for ($i = 0; $i < strlen($data); ++$i) {
        $text .= $data[$i] ^ $masks[$i % 4];
    }

    return $text;
}

function mask($text)
{
    // 0x1 text frame (FIN + opcode)
    $b1 = 0x80 | (0x1 & 0x0f);
    $length = strlen($text);

    if ($length <= 125) {
        $header = pack('CC', $b1, $length);
    } elseif ($length > 125 && $length < 65536) {
        $header = pack('CCS', $b1, 126, $length);
    } elseif ($length >= 65536) {
        $header = pack('CCN', $b1, 127, $length);
    }

    return $header.$text;
}
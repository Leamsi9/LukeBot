<?php

/**
 *
 * LEGAL STUFF:
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, or sell
 * copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */


//  ========= user values =========
$host = "127.0.0.1";             // <<<<<<<<<<<<<<<<<< YOUR CHATSCRIPT SERVER IP ADDRESS OR HOST-NAME GOES HERE
//$host = "35.165.158.84";   // <<<<<<<<<<<<<<<<<< YOUR CHATSCRIPT SERVER IP ADDRESS OR HOST-NAME GOES HERE
$port = 1024;                    // <<<<<<<<<<<<<<<<<< your port number if different from 1024
$bot  = "";
//  ===============================

// Take POST requests and transmit them to CS server via TCP
$null = "\x00";
$postVars = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
extract($postVars);

if (isset($send)) {
    // open client connection to TCP server
    $userip = "Ismael"; //Local temp
//	$userip = $_SERVER['REMOTE_ADDR']; // get actual ip address of user as his id

    $msg = $userip . $null . $bot . $null . $message . $null;

    // fifth parameter in fsockopen is timeout in seconds
    if (!$fp = fsockopen($host, $port, $errstr, $errno, 300)) {
        trigger_error('Error opening socket', E_USER_ERROR);
    }

    // write message to socket server
    $ret = '';
    fputs($fp, $msg);
    while (!feof($fp)) {
        $ret .= fgets($fp, 2000);
    }

    // close socket connection
    fclose($fp);
    exit($ret);
}
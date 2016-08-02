<?php
/**
 * Framework Component
 * @name      ALEX_CMS
 * @author    Alex Jurii <jurii@mail.ru>
 *
 * The MIT License (MIT)
 *
 * Copyright (c) 2016
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

/**
 * This test script simulates a web browser to test session behavior.
 * Before run this script, you should activate an HTTP server
 * to listen to this folder under http://localhost:8000/
 * or your prefered configuration (bellow).
 * You can use PHP 5.4 native HTTP server by calling:
 * $ php -S localhost:8000
 */
$listen = 'http://localhost:9000';
$debug  = false;

$test = new SmartSessionTest($listen, $debug);
$test->run();
exit(0);


/**
 * @TODO доделать тесты SessionTest
 * Class SmartSessionTest
 */
final class SmartSessionTest {

    /**
     * Host that are listen to HTTP requests.
     * @var string
     */
    private $host;

    /**
     * Debug flag.
     * @var bool
     */
    private $debug;

    /**
     * Runtime sessid for tests
     * @var string
     */
    private $sessid;

    /**
     * Pass counter
     * @var int
     */
    private $totalPass = 0;

    /**
     * Fail counter
     * @var int
     */
    private $totalFail = 0;

    /**
     * Constructor
     */
    public function __construct($host, $debug = true) {
        $this->host  = (string)$host;
        $this->debug = (bool)$debug;
    }

    /**
     * Run tests
     * @return void
     */
    public function run() {
        $this->testStatus();
        $this->testGet();
        $this->testDel();
        $this->testSet();
        $this->testClear();

        $this->testStatusWithSessid();
        $this->testGetWithSessid();
        $this->testDelWithSessid();
        $this->testClearWithSessid();

        fprintf(STDOUT, "Total pass: %d\n", $this->totalPass);
        fprintf(STDOUT, "Total fail: %d\n", $this->totalFail);
    }

    /**
     * Test status without sending session ID
     */
    public function testStatus() {
        $result = file_get_contents($this->host . '/testStatus.php');
        $json = json_decode($result, true);
        $this->printDebug($json);

        $this->assertThat($json['open'] === false, __METHOD__, 'open must be false');
        $this->assertThat($json['exist'] === false, __METHOD__, 'exist must be false');
    }

    /**
     * Test to get a value without sending session ID
     */
    public function testGet() {
        $result = file_get_contents($this->host . '/testGet.php');
        $json = json_decode($result, true);
        $this->printDebug($json);

        $this->assertThat($json['open'] === false, __METHOD__, 'open must be false');
        $this->assertThat($json['exist'] === false, __METHOD__, 'open must be false');
        $this->assertThat($json['value'] === null, __METHOD__, 'value must be null');
    }

    /**
     * Test to delete a value without sending session ID
     */
    public function testDel() {
        $result = file_get_contents($this->host . '/testDel.php');
        $json = json_decode($result, true);
        $this->printDebug($json);

        $this->assertThat($json['hasBefore'] === false, __METHOD__, 'hasBefore must be false');
        $this->assertThat($json['hasAfter'] === false, __METHOD__, 'hasAfter must be false');
        $this->assertThat($json['open'] === false, __METHOD__, 'open must be false');
        $this->assertThat($json['exist'] === false, __METHOD__, 'exist must be false');
        $this->assertThat($json['value'] === null, __METHOD__, 'value must be null');
    }

    /**
     * Test to set a value without sending session ID
     */
    public function testSet() {
        $result = file_get_contents($this->host . '/testSet.php');
        $json = json_decode($result, true);
        $this->printDebug($json);

        $this->assertThat($json['open'] === true, __METHOD__, 'open must be false');
        $this->assertThat($json['exist'] === true, __METHOD__, 'exist must be false');
        $this->assertThat($json['value'] === 123, __METHOD__, 'value must be 123');

        $this->sessid = $json['sessid'];
    }

    /**
     * Test to clear session without sending session ID
     */
    public function testClear() {
        $result = file_get_contents($this->host . '/testClear.php');
        $json = json_decode($result, true);
        $this->printDebug($json);

        $this->assertThat($json['open'] === false, __METHOD__, 'open must be false');
        $this->assertThat($json['exist'] === false, __METHOD__, 'exist must be false');
    }

    /**
     * Test session status sending valid session ID
     */
    public function testStatusWithSessid() {
        $context = stream_context_create(
            [
                'http' => [
                    'method' => 'GET',
                    'header' => sprintf("Cookie: %s=%s\r\n", session_name(), urlencode($this->sessid))
                ]
            ]
        );

        $result = file_get_contents($this->host . '/testStatus.php', false, $context);
        $json = json_decode($result, true);
        $this->printDebug($json);

        $this->assertThat($json['open'] === false, __METHOD__, 'open must be false');
        $this->assertThat($json['exist'] === true, __METHOD__, 'exist must be true');
    }

    /**
     * Test to get a value sending session ID
     */
    public function testGetWithSessid() {
        $context = stream_context_create(
            [
                'http' => [
                    'method' => 'GET',
                    'header' => sprintf("Cookie: %s=%s\r\n", session_name(), urlencode($this->sessid))
                ]
            ]
        );

        $result = file_get_contents($this->host . '/testGet.php', false, $context);
        $json = json_decode($result, true);
        $this->printDebug($json);

        $this->assertThat($json['open'] === true, __METHOD__, 'open must be true');
        $this->assertThat($json['exist'] === true, __METHOD__, 'exist must be true');
        $this->assertThat($json['value'] === 123, __METHOD__, 'value must be 123');
    }

    /**
     * Test to delete a value sending session ID
     */
    public function testDelWithSessid() {
        $context = stream_context_create(
            [
                'http' => [
                    'method' => 'GET',
                    'header' => sprintf("Cookie: %s=%s\r\n", session_name(), urlencode($this->sessid))
                ]
            ]
        );

        $result = file_get_contents($this->host . '/testDel.php', false, $context);
        $json = json_decode($result, true);
        $this->printDebug($json);

        $this->assertThat($json['hasBefore'] === true, __METHOD__, 'hasBefore must be true');
        $this->assertThat($json['hasAfter'] === false, __METHOD__, 'hasAfter must be false');
        $this->assertThat($json['open'] === true, __METHOD__, 'open must be true');
        $this->assertThat($json['exist'] === true, __METHOD__, 'exist must be true');
        $this->assertThat($json['value'] === null, __METHOD__, 'value must be null');
    }

    /**
     * Test to clear session sending session ID
     */
    public function testClearWithSessid() {
        $context = stream_context_create(
            [
                'http' => [
                    'method' => 'GET',
                    'header' => sprintf("Cookie: %s=%s\r\n", session_name(), urlencode($this->sessid))
                ]
            ]
        );

        $result = file_get_contents($this->host . '/testClear.php', false, $context);
        $json = json_decode($result, true);
        $this->printDebug($json);

        $this->assertThat($json['open'] === false, __METHOD__, 'open must be false');
        $this->assertThat($json['exist'] === false, __METHOD__, 'exist must be false');
    }

    /**
     * Simple assertion method
     * @param bool $pass
     * @param string $method
     * @param string $description
     */
    private function assertThat($pass, $method, $description) {
        static $counter = 0;
        $counter += 1;

        if ($pass === true) {
            fprintf(STDOUT, "Test %03d - %s: pass\n", $counter, $method);
            $this->totalPass += 1;
        } else {
            fprintf(STDERR, "Test %03d - %s: fail (%s)\n", $counter, $method, $description);
            $this->totalFail += 1;
        }
    }

    /**
     * Print debug if enabled
     * @param mixed $value
     * @return void
     */
    private function printDebug($value) {
        if ($this->debug) {
            fprintf(STDOUT, "Debug: %s\n", var_export($value, true));
        }
    }
}
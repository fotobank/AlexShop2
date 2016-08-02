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

// creates tracy.phar
if (!class_exists('Phar') || ini_get('phar.readonly')) {
	echo "Enable Phar extension and set directive 'phar.readonly=off'.\n";
	die(1);
}

@unlink('tracy.phar'); // @ - file may not exist

$phar = new Phar('tracy.phar');
$phar->setStub("<?php
require 'phar://' . __FILE__ . '/tracy.php';
__HALT_COMPILER();
");

$phar->startBuffering();
foreach ($iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__ . '/../../src', RecursiveDirectoryIterator::SKIP_DOTS)) as $file) {
	echo "adding: {$iterator->getSubPathname()}\n";
	$s = php_strip_whitespace($file);

	if (in_array($file->getExtension(), array('js', 'css'))) {
		continue;

	} elseif ($file->getExtension() === 'phtml') {
		$s = preg_replace_callback('#<\?php (require |readfile\(|.*file_get_contents\().*?(/.+\.(js|css))\'\)* \?>#', function ($m) use ($file) {
			return file_get_contents($file->getPath() . $m[2]);
		}, $s);
		$s = preg_replace_callback('#(<(script|style).*>)(.*)(</)#Uis', function ($m) {
			list(, $begin, $type, $s, $end) = $m;

			if (strpos($s, '<?php') !== FALSE) {
				return $m[0];

			} elseif ($type === 'script' && function_exists('curl_init')) {
				$curl = curl_init('http://closure-compiler.appspot.com/compile');
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_POST, 1);
				curl_setopt($curl, CURLOPT_POSTFIELDS, 'output_info=compiled_code&js_code=' . urlencode($s));
				$s = curl_exec($curl) ?: $s;
				curl_close($curl);

			} elseif ($type === 'style') {
				$s = preg_replace('#/\*.*?\*/#s', '', $s); // remove comments
				$s = preg_replace('#[ \t\r\n]+#', ' ', $s); // compress space, ignore hard space
				$s = preg_replace('# ([^0-9a-z.\#*-])#i', '$1', $s);
				$s = preg_replace('#([^0-9a-z%)]) #i', '$1', $s);
				$s = str_replace(';}', '}', $s); // remove leading semicolon
				$s = trim($s);
			}

			return $begin . $s . $end;
		}, $s);
	}

	$phar[$iterator->getSubPathname()] = $s;
}

$phar->stopBuffering();
$phar->compressFiles(Phar::GZ);

echo "OK\n";
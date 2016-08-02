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

namespace Tracy;


/**
 * Debugger for outputs.
 */
class OutputDebugger
{
	const BOM = "\xEF\xBB\xBF";

	/** @var array of [file, line, output, stack] */
	private $list = array();


	public static function enable()
	{
		$me = new static;
		$me->start();
	}


	public function start()
	{
		foreach (get_included_files() as $file) {
			if (fread(fopen($file, 'r'), 3) === self::BOM) {
				$this->list[] = array($file, 1, self::BOM);
			}
		}
		ob_start(array($this, 'handler'), PHP_VERSION_ID >= 50400 ? 1 : 2);
	}


	/** @internal */
	public function handler($s, $phase)
	{
		$trace = debug_backtrace(PHP_VERSION_ID >= 50306 ? DEBUG_BACKTRACE_IGNORE_ARGS : FALSE);
		if (isset($trace[0]['file'], $trace[0]['line'])) {
			$stack = $trace;
			unset($stack[0]['line'], $stack[0]['args']);
			$i = count($this->list);
			if ($i && $this->list[$i - 1][3] === $stack) {
				$this->list[$i - 1][2] .= $s;
			} else {
				$this->list[] = array($trace[0]['file'], $trace[0]['line'], $s, $stack);
			}
		}
		if ($phase === PHP_OUTPUT_HANDLER_FINAL) {
			return $this->renderHtml();
		}
	}


	private function renderHtml()
	{
		$res = '<style>code, pre {white-space:nowrap} a {text-decoration:none} pre {color:gray;display:inline} big {color:red}</style><code>';
		foreach ($this->list as $item) {
			$stack = array();
			foreach (array_slice($item[3], 1) as $t) {
				$t += array('class' => '', 'type' => '', 'function' => '');
				$stack[] = "$t[class]$t[type]$t[function]()"
					. (isset($t['file'], $t['line']) ? ' in ' . basename($t['file']) . ":$t[line]" : '');
			}

			$res .= Helpers::editorLink($item[0], $item[1]) . ' '
				. '<span title="' . htmlspecialchars(implode("\n", $stack), ENT_IGNORE | ENT_QUOTES, 'UTF-8') . '">'
				. str_replace(self::BOM, '<big>BOM</big>', Dumper::toHtml($item[2]))
				. "</span><br>\n";
		}
		return $res . '</code>';
	}

}

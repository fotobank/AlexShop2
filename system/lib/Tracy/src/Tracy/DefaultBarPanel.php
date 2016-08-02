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
 * IBarPanel implementation helper.
 * @internal
 */
class DefaultBarPanel implements IBarPanel
{
	private $id;

	public $data;


	public function __construct($id)
	{
		$this->id = $id;
	}


	/**
	 * Renders HTML code for custom tab.
	 * @return string
	 */
	public function getTab()
	{
		ob_start(function () {});
		$data = $this->data;
		require __DIR__ . "/assets/Bar/{$this->id}.tab.phtml";
		return ob_get_clean();
	}


	/**
	 * Renders HTML code for custom panel.
	 * @return string
	 */
	public function getPanel()
	{
		ob_start(function () {});
		if (is_file(__DIR__ . "/assets/Bar/{$this->id}.panel.phtml")) {
			$data = $this->data;
			require __DIR__ . "/assets/Bar/{$this->id}.panel.phtml";
		}
		return ob_get_clean();
	}

}

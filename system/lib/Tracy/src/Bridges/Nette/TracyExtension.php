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

namespace Tracy\Bridges\Nette;

use Nette;


/**
 * Tracy extension for Nette DI.
 */
class TracyExtension extends Nette\DI\CompilerExtension
{
	public $defaults = array(
		'email' => NULL,
		'fromEmail' => NULL,
		'logSeverity' => NULL,
		'editor' => NULL,
		'browser' => NULL,
		'errorTemplate' => NULL,
		'strictMode' => NULL,
		'showBar' => NULL,
		'maxLen' => NULL,
		'maxDepth' => NULL,
		'showLocation' => NULL,
		'scream' => NULL,
		'bar' => array(), // of class name
		'blueScreen' => array(), // of callback
	);

	/** @var bool */
	private $debugMode;


	public function __construct($debugMode = FALSE)
	{
		$this->debugMode = $debugMode;
	}


	public function loadConfiguration()
	{
		$this->validateConfig($this->defaults);
		$container = $this->getContainerBuilder();

		$container->addDefinition($this->prefix('logger'))
			->setClass('Tracy\ILogger')
			->setFactory('Tracy\Debugger::getLogger');

		$container->addDefinition($this->prefix('blueScreen'))
			->setFactory('Tracy\Debugger::getBlueScreen');

		$container->addDefinition($this->prefix('bar'))
			->setFactory('Tracy\Debugger::getBar');
	}


	public function afterCompile(Nette\PhpGenerator\ClassType $class)
	{
		$initialize = $class->getMethod('initialize');
		$container = $this->getContainerBuilder();

		$options = $this->config;
		unset($options['bar'], $options['blueScreen']);
		foreach ($options as $key => $value) {
			if ($value !== NULL) {
				$key = ($key === 'fromEmail' ? 'getLogger()->' : '$') . $key;
				$initialize->addBody($container->formatPhp(
					'Tracy\Debugger::' . $key . ' = ?;',
					Nette\DI\Compiler::filterArguments(array($value))
				));
			}
		}

		if ($this->debugMode) {
			foreach ((array) $this->config['bar'] as $item) {
				$initialize->addBody($container->formatPhp(
					'$this->getService(?)->addPanel(?);',
					Nette\DI\Compiler::filterArguments(array(
						$this->prefix('bar'),
						is_string($item) ? new Nette\DI\Statement($item) : $item,
					))
				));
			}
		}

		foreach ((array) $this->config['blueScreen'] as $item) {
			$initialize->addBody($container->formatPhp(
				'$this->getService(?)->addPanel(?);',
				Nette\DI\Compiler::filterArguments(array($this->prefix('blueScreen'), $item))
			));
		}
	}

}

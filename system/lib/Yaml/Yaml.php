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

namespace lib\Yaml;

use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Exception\DumpException;
use exception\YamlException;

/**
 * Class Yaml
 * @package lib\Yaml
 */
class Yaml extends \Symfony\Component\Yaml\Yaml
{

    /**
     * @param $file
     * @param $array
     * @param int $inline - ������ ������ (1 ��� 2)
     * @throws YamlException
     */
    public function save($file, $array, $inline = 1) {

        try {

        $yaml = parent::dump($array, $inline);

        file_put_contents($file, $yaml);

        } catch(DumpException $e) {

            throw new YamlException('Unable to dump the YAML to file: %s', $e->getMessage());
        }

    }

    /**
     * @param $file
     * @return mixed
     * @throws YamlException
     */
    public function read($file) {

        try {

            return parent::parse(file_get_contents($file));

       } catch(ParseException $e) {

          throw new YamlException('Unable to parse the YAML string: %s', $e->getMessage());
       }
    }
}
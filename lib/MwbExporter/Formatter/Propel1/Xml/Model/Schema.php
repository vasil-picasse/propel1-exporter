<?php

/*
 * The MIT License
 *
 * Copyright (c) 2010 Johannes Mueller <circus2(at)web.de>
 * Copyright (c) 2012-2014 Toha <tohenk@yahoo.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace MwbExporter\Formatter\Propel1\Xml\Model;

use MwbExporter\Model\Schema as BaseSchema;
use MwbExporter\Writer\WriterInterface;
use MwbExporter\Formatter\Propel1\Xml\Formatter;
use MwbExporter\Helper\Comment;

class Schema extends BaseSchema
{
    /**
     * (non-PHPdoc)
     * @see \MwbExporter\Model\Schema::write()
     */
    public function write(WriterInterface $writer)
    {
        $writer
            ->open($this->getDocument()->translateFilename(null, $this))
            ->write('<?xml version="1.0" encoding="UTF-8"?>')
            ->writeCallback(function(WriterInterface $writer, Schema $_this = null) {
                if ($_this->getConfig()->get(Formatter::CFG_ADD_COMMENT)) {
                    $writer
                        ->write($_this->getFormatter()->getComment(Comment::FORMAT_XML))
                    ;
                }
            })
            ->write('<database name="%s" defaultIdMethod="native"', $this->getName())
            ->write('xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"')
            ->write('xsi:noNamespaceSchemaLocation="https://raw.githubusercontent.com/propelorm/Propel/1.6/generator/resources/xsd/database.xsd">')
            ->writeCallback(function(WriterInterface $writer, Schema $_this = null) {
                $_this->writeSchema($writer);
            })
            ->write('</database>')
            ->close()
        ;

        return $this;
    }
}
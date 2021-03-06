<?php
/*
 * The MIT License
 *
 * Copyright 2015 Anthony Maudry <anthony.maudry@thuata.com>.
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

namespace Thuata\UserBundle\Exception;

/**
 * Class AclInvalidValue
 *
 * @package Thuata\UserBundle\Exception
 *
 * @author Anthony Maudry <anthony.maudry@thuata.com>
 */
class AclInvalidValueException extends \Exception
{
    const MESSAGE_FORMAT = 'The value "%s" is invalid. A valid value is an integer and a power of 2 (0, 2, 4, 8, etc.)';
    const ERROR_CODE = 500;

    /**
     * AclInvalidValue constructor.
     *
     * @param mixed $value
     */
    public function __construct($value)
    {
        parent::__construct(sprintf(self::MESSAGE_FORMAT, (string) $value), self::ERROR_CODE, null);
    }
}
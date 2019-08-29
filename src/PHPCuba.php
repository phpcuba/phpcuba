<?php

namespace PHPCuba;

/**
 * Cuban PHP Community
 *
 * More functions for PHP. Strengthen PHP with new functions.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License
 * for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program as the file LICENSE.txt; if not, please see
 *
 * https://www.gnu.org/licenses/gpl-3.0.txt
 *
 * @see https://t.me/phpcuba
 * @see https://phpcuba.org
 */
class PHPCuba
{
    private static $version = '1.1.2';

    /**
     * Version of lib
     *
     * @return string
     * @author @rafageist
     */
    public static function version(): string
    {
        return self::$version;
    }
}

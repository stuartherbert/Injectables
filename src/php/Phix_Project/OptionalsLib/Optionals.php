<?php

/**
 * Copyright (c) 2013-present Stuart Herbert.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the names of the copyright holders nor the names of the
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package     Phix_Project
 * @subpackage  OptionalsLib
 * @author      Stuart Herbert <stuart@stuartherbert.com>
 * @copyright   2013-present Stuart Herbert. www.stuartherbert.com
 * @license     http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link        http://www.phix-project.org
 */

namespace Phix_Project\OptionalsLib;

/**
 * Dependency container
 *
 * @package     Phix_Project
 * @subpackage  OptionalsLib
 * @author      Stuart Herbert <stuart@stuartherbert.com>
 * @copyright   2013-present Stuart Herbert. www.stuartherbert.com
 * @license     http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link        http://www.phix-project.org
 */

class Optionals
{
	/**
	 * Magic method for handling attempts to access an optional dependency
	 * that hasn't been supplied this time
	 *
	 * @param  string $property
	 *         the name of the dependency that the caller is trying to use
	 * @return null
	 *         NULL - there is no such dependency available
	 */
	public function __get($property)
	{
		// all done
		return null;
	}

	public function requireValidOptionals()
	{
		// sanity check - make sure that every optional dependency
		// has the expected interface
		//
		// you wouldn't normally call this in your app, just in your
		// unit tests

		foreach ($this as $prop => $value)
		{
			$methodName = 'init' . ucfirst($prop);
			if (!method_exists($this, $methodName)) {
				throw new E5xx_InvalidOptionalDependency($prop);
			}
		}
	}


}
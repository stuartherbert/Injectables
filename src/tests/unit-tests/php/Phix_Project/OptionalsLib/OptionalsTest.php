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

use PHPUnit_Framework_TestCase;

class OptionalsTest extends PHPUnit_Framework_TestCase
{
	public function testCanInstantiate()
	{
	    // ----------------------------------------------------------------
	    // perform the change
	    //
	    // make sure we can create objects of type 'Optionals'

	    $optionals = new Optionals();

	    // ----------------------------------------------------------------
	    // test the results

	    $this->assertTrue($optionals instanceof Optionals);
	}

	public function testCanInstantiateTestContainer()
	{
	    // ----------------------------------------------------------------
	    // perform the change
	    //
	    // make sure we can create our own objects that inherit from
	    // the 'Optionals' container

	    $myOptionals = new MyOptionals();

	    // ----------------------------------------------------------------
	    // test the results

	    $this->assertTrue($myOptionals instanceof Optionals);
	}

	public function testCanValidateCorrectTestContainer()
	{
	    // ----------------------------------------------------------------
	    // setup your test

	    $myOptionals = new MyOptionals();
	    $expectedResult = true;

	    // ----------------------------------------------------------------
	    // perform the change
	    //
	    // make sure we can successfully validate the definition of our
	    // own optionals container

	    $actualResult = true;
	   	try {
	   		$myOptionals->requireValidOptionals();
	   	}
	   	catch (\Exception $e) {
	   		$actualResult = false;
	   	}

	    // ----------------------------------------------------------------
	    // test the results

	    $this->assertEquals($expectedResult, $actualResult);
	}

	public function testCanValidateIncorrectTestContainer()
	{
	    // ----------------------------------------------------------------
	    // setup your test

	    $myOptionals = new MyBadOptionals();
	    $expectedResult = false;

	    // ----------------------------------------------------------------
	    // perform the change
	    //
	    // make sure we can correctly detect when there are problems with
	    // the contents of the optionals container

	    $actualResult = true;
	   	try {
	   		$myOptionals->requireValidOptionals();
	   	}
	   	catch (\Exception $e) {
	   		$actualResult = false;
	   	}

	    // ----------------------------------------------------------------
	    // test the results

	    $this->assertEquals($expectedResult, $actualResult);
	}

	public function testCanTestForOptionalDependency()
	{
	    // ----------------------------------------------------------------
	    // setup your test
	    //
	    // missing AND uninitialised dependencies are both the same thing
	    // as far as the caller is concerned, and both resolve to FALSE

	    $myOptionals     = new MyOptionals();
	    $expectedResults = array(
	    	"trueOrFalse" => false,
	    	"falseOrTrue" => NULL
	    );

	    // ----------------------------------------------------------------
	    // perform the change

	    $actualResults = [];
	    foreach ($expectedResults as $prop => $expectedResult) {
	    	$actualResults[$prop] = $myOptionals->$prop;
	    }

	    // ----------------------------------------------------------------
	    // test the results

	    $this->assertEquals($expectedResults, $actualResults);
	}

	public function testCanCallOptionalDependency()
	{
	    // ----------------------------------------------------------------
	    // setup your test
	    //
	    // make sure we can call a dependency if it has been supplied
	    // and initialised

	    $myOptionals = new MyOptionals();
	    $myOptionals->initTrueOrFalse();
	    $expectedResults = [
	    	"trueOrFalse" => true,
	    	"falseOrTrue" => NULL
	    ];

	    // ----------------------------------------------------------------
	    // perform the change

	    $actualResults = [];
	    foreach ($expectedResults as $prop => $expectedResult) {
	    	if ($myOptionals->$prop) {
	    		$actualResults[$prop] = $myOptionals->$prop->isTrue(1);
	    	}
	    	else {
	    		$actualResults[$prop] = NULL;
	    	}
	    }

	    // ----------------------------------------------------------------
	    // test the results

	    $this->assertEquals($expectedResults, $actualResults);
	}
}
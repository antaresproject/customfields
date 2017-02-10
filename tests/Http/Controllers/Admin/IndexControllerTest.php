<?php

/**
 * Part of the Antares Project package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Customfields
 * @version    0.9.0
 * @author     Antares Team
 * @license    BSD License (3-clause)
 * @copyright  (c) 2017, Antares Project
 * @link       http://antaresproject.io
 */



namespace Antares\Customfields\TestCase;

use Antares\Customfields\Http\Controllers\Admin\IndexController;
use Mockery as m;
use Antares\Testbench\TestCase;

class IndexControllerTest extends TestCase
{

    /**
     * setup
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * tearing down
     */
    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * test creating instance of class
     */
    public function testConstructWithProcessor()
    {
        $mock = m::mock('\Antares\Customfields\Http\Processors\FieldProcessor');
        $stub = new IndexController($mock);
        $this->assertSame(get_class($stub), 'Antares\Customfields\Http\Controllers\Admin\IndexController');
    }

    /**
     * test setup filters
     */
    public function testSetupFilters()
    {
        $mock = m::mock('\Antares\Customfields\Http\Processors\FieldProcessor');
        $stub = new IndexController($mock);
        $this->assertnull($stub->setupFilters());
    }

}

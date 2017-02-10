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

use Mockery as m;
use Antares\Customfields\Http\Handlers\FieldsMenuHandler;
use Antares\Testing\TestCase;

class FieldsMenuHandlerTest extends TestCase
{

    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * Teardown the test environment.
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * test get position attribute
     */
    public function testGetPositionAttribute()
    {
        $stub     = new FieldsMenuHandler($this->app);
        $expected = '>:home';
        $this->assertSame($expected, $stub->getPositionAttribute());
    }

    /**
     * testing authorize methoda
     */
    public function testAuthorize()
    {
        $stub      = new FieldsMenuHandler($this->app);
        $guardMock = m::mock('Antares\Contracts\Auth\Guard');
        $guardMock->shouldReceive('guest')->andReturn(false);
        $this->assertFalse($stub->authorize($guardMock));
    }

}

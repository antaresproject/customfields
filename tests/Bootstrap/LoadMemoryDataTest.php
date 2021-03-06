<?php

/**
 * Part of the Antares package.
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
 * @copyright  (c) 2017, Antares
 * @link       http://antaresproject.io
 */

namespace Antares\Customfields\TestCase;

use Antares\Testing\ApplicationTestCase;

class LoadMemoryDataTest extends ApplicationTestCase
{

    /**
     * Test instance of `antares.memory.register.forms`.
     * 
     * @test
     */
    public function testInstanceOfRegisterFormsMemory()
    {
        $stub = $this->app->make('antares.memory')->driver('registry.forms');
        $this->assertInstanceOf('\Antares\Memory\Provider', $stub);
    }

}

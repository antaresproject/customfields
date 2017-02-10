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

use Illuminate\Foundation\Application;
use Antares\Customfields\Memory\FormsProvider;
use Antares\Testing\TestCase;
use Mockery as m;

class LoadMemoryDataTest extends TestCase
{

    /**
     * Define environment setup.
     *
     * @param Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);
        $memory = m::mock('\Antares\Contracts\Memory\Provider');

        $handler       = m::mock('Antares\Customfields\Memory\FormsRepository');
        $handler->shouldReceive('initiate')->withNoArgs()->andReturn([]);
        $formsProvider = new FormsProvider($handler);

        $memory->shouldReceive('extend')->with("registry", m::type("Closure"))->andReturnUsing(function() use($formsProvider) {
            return $formsProvider;
        });

        $memory->shouldReceive('driver')->with('registry.forms')->andReturn($formsProvider);
        $runtime = m::mock('Antares\Contracts\Memory\Provider');

        $memory->shouldReceive('make')->with("runtime.antares")->andReturn($runtime);
        $runtime->shouldReceive('put')->withAnyArgs()->andReturn("test");
        $app['antares.memory'] = $memory;
        $app->make('Antares\Customfields\Bootstrap\LoadMemoryData')->bootstrap($app);
    }

    /**
     * Test instance of `antares.memory.register.forms`.
     * @test
     */
    public function testInstanceOfRegisterFormsMemory()
    {
        $stub = $this->app->make('antares.memory')->driver('registry.forms');
        $this->assertInstanceOf('\Antares\Customfields\Memory\FormsProvider', $stub);
        $this->assertInstanceOf('\Antares\Memory\Provider', $stub);
    }

}

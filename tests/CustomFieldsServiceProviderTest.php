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
use Illuminate\Container\Container;
use Antares\Customfields\CustomFieldsServiceProvider;

class CustomFieldsServiceProviderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Application instance.
     *
     * @var \Illuminate\Container\Container
     */
    protected $app;

    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        $this->app = new Container();
    }

    /**
     * Teardown the test environment.
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * Test Antares\Customfields\CustomFieldsServiceProvider::register() method.
     * @test
     */
    public function testRegisterMethod()
    {

        $app           = $this->app;
        $app['config'] = m::mock('\Illuminate\Contracts\Config\Repository');
        $app['events'] = m::mock('\Illuminate\Contracts\Events\Dispatcher');
        $app['files']  = m::mock('\Illuminate\Filesystem\Filesystem');


        $stub = new CustomFieldsServiceProvider($app);
        $stub->register();
        $this->assertInstanceOf('\Antares\Customfields\Model\Field', $app['antares.customfields.model']);
        $this->assertInstanceOf('\Antares\Customfields\Model\FieldView', $app['antares.customfields.model.view']);
        $this->assertInstanceOf('\Antares\Customfields\Model\FieldGroup', $app['antares.customfields.model.group']);
        $this->assertInstanceOf('\Antares\Customfields\Model\FieldCategory', $app['antares.customfields.model.category']);
        $this->assertInstanceOf('\Antares\Customfields\Model\FieldType', $app['antares.customfields.model.type']);
        $this->assertInstanceOf('\Antares\Customfields\Model\FieldTypeOption', $app['antares.customfields.model.type.option']);
        $this->assertInstanceOf('\Antares\Customfields\Model\FieldValidator', $app['antares.customfields.model.validator']);
        $this->assertInstanceOf('\Antares\Customfields\Model\FieldValidatorConfig', $app['antares.customfields.model.validator.config']);
    }

    /**
     * Test CustomFieldsServiceProvider::provides() method.    
     * @test
     */
    public function testProvidesMethod()
    {
        $app  = new Container();
        $stub = new CustomFieldsServiceProvider($app);
        $this->assertEquals([
            'antares.customfields.model',
            'antares.customfields.model.view',
            'antares.customfields.model.category',
            'antares.customfields.model.group',
            'antares.customfields.model.type',
            'antares.customfields.model.type.option',
            'antares.customfields.model.validator',
            'antares.customfields.model.validator.config'], $stub->provides());
    }

    /**
     * Test CustomfieldsServiceProvider is deferred.
     * @test
     */
    public function testServiceIsDeferred()
    {
        $app  = new Container();
        $stub = new CustomFieldsServiceProvider($app);
        $this->assertFalse($stub->isDeferred());
    }

    /**
     * test booting method
     */
    public function testExceptionThrowsWhenBoot()
    {
        $path = realpath(__DIR__ . '/../../../vendor/antares/components/customfields');

        $app = [
            'router'                     => $router                      = m::mock('\Illuminate\Routing\Router'),
            'antares.customfields.model' => m::mock('Antares\Customfields\Model\Field'),
            'view.paths'                 => [$path]
        ];

        $config = m::mock('\Antares\Config\Repository');
        $config->shouldReceive('package')
                ->once()
                ->with('antares/customfields', $path . "/resources/config", 'antares/customfields')
                ->andReturnNull();


        $config->shouldReceive('offsetGet')
                ->once()
                ->andReturnUsing(function ($c) {
                    array(realpath(__DIR__ . '/../'));
                });
        $app['config'] = $config;
        $stub          = new CustomFieldsServiceProvider($app);
        try {
            $stub->boot();
        } catch (\Exception $ex) {
            $this->assertSame("array_map(): Argument #2 should be an array", $ex->getMessage());
        }
    }

}

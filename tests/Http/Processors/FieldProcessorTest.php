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

use Antares\Testing\TestCase;
use Antares\Customfields\Http\Processors\FieldProcessor;
use Mockery as m;

class FieldProcessorTest extends TestCase
{

    /**
     * @see parent::setUp
     */
    public function setUp()
    {
        parent::setUp();
        $this->app['antares.customfields.model.view'] = $fieldView                                    = m::mock(\Antares\Customfields\Model\FieldView::class);
        $fieldView->shouldReceive('query')->withNoArgs()->andReturnSelf()
                ->shouldReceive('where')->withAnyArgs()->andReturnSelf()
                ->shouldReceive('exists')->withNoArgs()->andReturn(false);
    }

    /**
     * @see parent::tearDown();
     */
    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * test constructing
     */
    public function testConstruct()
    {
        $presenter = m::mock('\Antares\Customfields\Http\Presenters\FieldPresenter');
        $validator = m::mock('\Antares\Customfields\Http\Validators\FieldValidator');

        $stub = new FieldProcessor($presenter, $validator);
        $this->assertSame(get_class($stub), 'Antares\Customfields\Http\Processors\FieldProcessor');
    }

    /**
     * test shows method without ajax
     */
    public function testShowWithoutAjax()
    {
        $presenter = m::mock('\Antares\Customfields\Http\Presenters\FieldPresenter');
        $presenter->shouldReceive('table')->with(m::type('\yajra\Datatables\Html\Builder'))->andReturn(1);

        $validator = m::mock('\Antares\Customfields\Http\Validators\FieldValidator');

        $request = m::mock('\Illuminate\Http\Request');
        $request->shouldReceive('ajax')->withNoArgs()->andReturn(false);
        $builder = m::mock('\yajra\Datatables\Html\Builder');
        $stub    = new FieldProcessor($presenter, $validator);
        $this->assertEquals($stub->show($request, $builder), 1);
    }

    /**
     * test show with ajax
     */
    public function testShowWithAjax()
    {
        $presenter = m::mock('\Antares\Customfields\Http\Presenters\FieldPresenter');
        $presenter->shouldReceive('tableJson')->with(m::type('\Illuminate\Database\Eloquent\Model'))->andReturn(1);
        $validator = m::mock('\Antares\Customfields\Http\Validators\FieldValidator');
        $request   = m::mock('\Illuminate\Http\Request');
        $request->shouldReceive('ajax')->withNoArgs()->andReturn(true);
        $builder   = m::mock('\yajra\Datatables\Html\Builder');
        $stub      = new FieldProcessor($presenter, $validator);
        $this->assertEquals($stub->show($request, $builder), 1);
    }

}

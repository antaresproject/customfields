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
use Antares\Testing\TestCase;
use Antares\Customfields\Model\Field;
use Antares\Customfields\Http\Presenters\FieldPresenter;

class FieldPresenterTest extends TestCase
{

    /**
     * @see parent::setup
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @see parent::tearDown()
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

        $mock = m::mock('\Antares\Customfields\Http\Forms\FieldFormFactory');
        $stub = new FieldPresenter($mock);
        $this->assertSame(get_class($stub), 'Antares\Customfields\Http\Presenters\FieldPresenter');
    }

    /**
     * testing table method
     */
    public function testTable()
    {
        $mock    = m::mock('\Antares\Customfields\Http\Forms\FieldFormFactory');
        $builder = m::mock('\yajra\Datatables\Html\Builder');
        $builder->shouldReceive('addColumn')->with(m::type('Array'))->andReturnSelf();
        $builder->shouldReceive('addAction')->with(m::type('Array'))->andReturnSelf();

        $stub = new FieldPresenter($mock);
        $this->assertInstanceOf(\Illuminate\View\View::class, $stub->table($builder));
    }

    /**
     * test tableJson method
     */
    public function testTableJson()
    {
        $mock = m::mock('\Antares\Customfields\Http\Forms\FieldFormFactory');

        $stub  = new FieldPresenter($mock);
        $model = m::mock('\Illuminate\Database\Eloquent\Model');

        $customField = new Field();
        $model->shouldReceive('select')->with(m::type('Array'))->andReturn($customField->query()->getQuery());
        $this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, $stub->tableJson($model));
    }

    /**
     * testing form method
     */
    public function testForm()
    {
        $mock     = m::mock('\Antares\Customfields\Http\Forms\FieldFormFactory');
        $mock->shouldReceive('of')
                ->with(m::type('String'), m::type('Closure'))
                ->andReturn(true)
                ->shouldReceive('build')
                ->andReturn(true);
        $stub     = new FieldPresenter($mock);
        $eloquent = m::mock('\Antares\Model\Eloquent');
        $eloquent->shouldReceive('getFlattenValidators')
                ->once()
                ->andReturn(array())
                ->shouldReceive('getAttribute')
                ->once()
                ->with(m::type('String'))
                ->andReturn(array());
        $route    = m::mock('\Illuminate\Routing\Route');
        $route->shouldReceive('getParameter')->withAnyArgs()->andReturn(true);
        $this->assertTrue($stub->form($eloquent, 'fooAction', $route));
    }

}

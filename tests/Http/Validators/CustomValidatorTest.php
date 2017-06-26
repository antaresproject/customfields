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

use Antares\Testing\TestCase;
use Antares\Customfields\Http\Validators\CustomValidator;
use Mockery as m;

class CustomValidatorTest extends TestCase
{

    /**
     * @see parent::setUp
     */
    public function setUp()
    {

        parent::setUp();
        $builder = m::mock(\Illuminate\Database\Eloquent\Builder::class);

        $builder->shouldReceive('query')->withNoArgs()->andReturnSelf()
                ->shouldReceive('where')->withAnyArgs()->andReturn($builder)
                ->shouldReceive('exists')->withAnyArgs()->andReturn(false);

        $this->app['antares.customfields.model.view'] = $builder;
    }

    /**
     * test validateNameOnCreate
     */
    public function testValidateNameOnCreate()
    {

        $translator = m::mock('\Illuminate\Translation\Translator');
        $stub       = new CustomValidator($translator, [], []);
        $this->assertTrue($stub->validateNameOnCreate('testattribute', '1', []));
    }

    /**
     * test validateValidatorList method
     */
    public function testValidateValidatorList()
    {

        $translator = m::mock('\Illuminate\Translation\Translator');
        $stub       = new CustomValidator($translator, [], []);
        $this->assertTrue($stub->validateValidatorList('testattribute', '1', []));
    }

}

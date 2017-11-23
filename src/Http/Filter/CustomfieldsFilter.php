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
 * @version    0.9.2
 * @author     Antares Team
 * @license    BSD License (3-clause)
 * @copyright  (c) 2017, Antares
 * @link       http://antaresproject.io
 */

namespace Antares\Customfields\Filter;

use Yajra\Datatables\Contracts\DataTableScopeContract;
use Antares\Datatables\Filter\SelectFilter;
use Antares\Customfields\Model\FieldType;
use Antares\Support\Str;

class CustomfieldsFilter extends SelectFilter implements DataTableScopeContract
{

    /**
     * name of filter
     *
     * @var String 
     */
    protected $name = 'Groups';

    /**
     * column to search
     *
     * @var String
     */
    protected $column = 'group';

    /**
     * filter pattern
     *
     * @var String
     */
    protected $pattern = '<span class="filter-label">Group:</span> %value';

    /**
     * filter instance dataprovider
     * 
     * @return array
     */
    protected function options()
    {
        $types  = FieldType::all(['id', 'name', 'type']);
        $return = [];
        foreach ($types as $type) {
            $return[$type->id] = ucfirst(Str::humanize(is_null($type->type) ? $type->name : $type->name . ' ' . $type->type));
        }
        return $return;
    }

    /**
     * Filters data by parameters from memory
     * 
     * @param mixed $builder
     */
    public function apply($collection)
    {
        $values = $this->getValues();
        if (!count($values)) {
            return $collection;
        }
        return $collection = $collection->whereIn('type_id', (array) $values);
    }

}

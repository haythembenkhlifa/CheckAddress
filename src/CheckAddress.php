<?php

namespace Haythem\CheckAddress;

use Laravel\Nova\Fields\Field;

class CheckAddress extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'check-address';


    public function endPoint($endPoint)
    {
        return $this->withMeta(['endPoint' => $endPoint]);
    }
}

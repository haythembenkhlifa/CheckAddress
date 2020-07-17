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

    public function initialAddressLine1($initial_address_line1 = '')
    {
        return $this->withMeta(['initialAddressLine1' => $initial_address_line1]);
    }

    public function initialAddressLine2($initial_address_line2 = '')
    {
        return $this->withMeta(['initialAddressLine2' => $initial_address_line2]);
    }

    public function initialPostalCode($initial_postal_code = '')
    {
        return $this->withMeta(['initialPostalCode' => $initial_postal_code]);
    }

    public function initialSuburb($initial_suburb = '')
    {
        return $this->withMeta(['initialSuburb' => $initial_suburb]);
    }
}

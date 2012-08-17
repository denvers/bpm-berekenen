<?php
namespace BPMBerekening\afschrijvingsmethode;

/**
 * User: dsessink
 * Date: 25-07-12
 * Time: 23:30
 */
use Exception;

class Taxatierapport implements IAfschrijvingsmethode
{
    /**
     * @param \BPMBerekening\Motorrijtuig\Motorrijtuig $motorrijtuig
     * @return mixed
     */
    public function setMotorrijtuig($motorrijtuig)
    {
        // TODO: Implement setMotorrijtuig() method.
    }

    /**
     * @param null $datum_aangifte
     * @return int|void
     */
    public function berekenAfschrijvingspercentage($datum_aangifte = null)
    {
        // TODO: Implement berekenAfschrijvingspercentage() method.
    }
}
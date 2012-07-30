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
     * @param Motorrijtuig $motorrijtuig
     * @return mixed
     */
    public function setMotorrijtuig($motorrijtuig)
    {
        // TODO: Implement setMotorrijtuig() method.
    }

    public function berekenAfschrijvingspercentage()
    {
        throw new Exception("Not yet implemented.");
    }
}

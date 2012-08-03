<?php
namespace BPMBerekening\afschrijvingsmethode;

/**
 * User: dsessink
 * Date: 25-07-12
 * Time: 23:27
 */
interface IAfschrijvingsmethode
{
    /**
     * @abstract
     * @param Motorrijtuig $motorrijtuig
     * @return mixed
     */
    public function setMotorrijtuig($motorrijtuig);

    /**
     * @abstract
     * @param \DateTime $datum_aangifte = null
     * @return int
     */
    public function berekenAfschrijvingspercentage($datum_aangifte = null);
}

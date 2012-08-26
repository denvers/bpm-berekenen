<?php
namespace BPMBerekening\Motorrijtuig;

/**
 * User: dsessink
 * Date: 24-07-12
 * Time: 14:07
 */
class PersonenautoGeenDiesel extends Motorrijtuig
{
    /**
     * @param mixed $co2_uitstoot
     */
    public function setCo2Uitstoot($co2_uitstoot)
    {
        // Requirement 11:
        // Geen co2_uitstoot vastgesteld; Dan wordt de CO2-uitstoot vastgesteld op 350 gr/km voor een benzineauto
        if (is_null($co2_uitstoot)) {
            $this->co2_uitstoot = 350;
        } else {
            $co2_uitstoot = intval($co2_uitstoot);

            if ($co2_uitstoot >= 0) {
                $this->co2_uitstoot = $co2_uitstoot;
            } else {
                $this->co2_uitstoot = 0;
            }
        }
    }
}

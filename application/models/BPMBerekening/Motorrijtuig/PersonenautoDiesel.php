<?php
namespace BPMBerekening\Motorrijtuig;

/**
 * User: dsessink
 * Date: 24-07-12
 * Time: 14:06
 */
class PersonenautoDiesel extends Motorrijtuig
{
    /**
     * @param int $co2_uitstoot (set to null als er geen co2 is vastgesteld)
     */
    public function setCo2Uitstoot($co2_uitstoot)
    {
        // Requirement 12:
        // Geen co2_uitstoot vastgesteld; Dan wordt de CO2-uitstoot vastgesteld op 302 gr/km voor een dieselauto
        if (is_null($co2_uitstoot)) {
            $this->co2_uitstoot = 302;
        } else {
            if ($co2_uitstoot >= 0) {
                $this->co2_uitstoot = $co2_uitstoot;
            } else {
                $this->co2_uitstoot = 0;
            }
        }
    }

    /**
     * @param boolean $voldoet
     */
    public function setEuro6Norm($voldoet)
    {
        if ($voldoet === true) {
            $this->euro_6norm = true;
        }
    }

    /**
     * @return bool
     */
    public function voldoetAanEuro6Norm()
    {
        return ($this->euro_6norm === true);
    }
}
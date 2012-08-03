<?php
require_once(dirname(__FILE__) . "/../models/bpm_berekening.php");

/**
 * Deze test class dekt de requirements 11 - 12
 */
class TestRequirements11to15 extends PHPUnit_Framework_TestCase
{
    /**
     * @requirement 11
     * @desc geen co2 vastgesteld; Dan wordt de CO2-uitstoot vastgesteld op 350 gr/km voor een benzineauto
     */
    public function testRequirement11()
    {
        $motorrijtuig = new \BPMBerekening\models\motorrijtuig\Personenauto_Geen_Diesel();
        $motorrijtuig->setCo2Uitstoot(null);

        $this->assertEquals(350, $motorrijtuig->getCo2Uitstoot());
    }

    /**
     * @requirement 12
     * @desc geen co2 vastgesteld; Dan wordt de CO2-uitstoot vastgesteld op 302 gr/km voor een dieselauto
     */
    public function testRequirement12()
    {
        $motorrijtuig = new \BPMBerekening\models\motorrijtuig\Personenauto_Diesel();
        $motorrijtuig->setCo2Uitstoot(null);

        $this->assertEquals(302, $motorrijtuig->getCo2Uitstoot());
    }
}
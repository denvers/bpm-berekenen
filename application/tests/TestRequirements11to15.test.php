<?php
use BPMBerekening\Motorrijtuig\PersonenautoGeenDiesel;
use BPMBerekening\Motorrijtuig\PersonenautoDiesel;

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
        $motorrijtuig = new PersonenautoGeenDiesel();
        $motorrijtuig->setCo2Uitstoot(null);

        $this->assertEquals(350, $motorrijtuig->getCo2Uitstoot());
    }

    /**
     * @requirement 12
     * @desc geen co2 vastgesteld; Dan wordt de CO2-uitstoot vastgesteld op 302 gr/km voor een dieselauto
     */
    public function testRequirement12()
    {
        $motorrijtuig = new PersonenautoDiesel();
        $motorrijtuig->setCo2Uitstoot(null);

        $this->assertEquals(302, $motorrijtuig->getCo2Uitstoot());
    }
}
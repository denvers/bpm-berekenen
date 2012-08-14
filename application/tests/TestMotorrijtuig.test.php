<?php
use BPMBerekening\Motorrijtuig\Motorfiets;

class TestMotorrijtuig extends PHPUnit_Framework_TestCase {

    var $motorrijtuig;

    protected function setUp()
    {
        $this->motorrijtuig = new Motorfiets();
    }

    // Inkoopwaarde
    public function testInkoopwaarde0ShouldStay0()
    {
        $this->motorrijtuig->setInkoopwaarde(0);
        $this->assertEquals(0, $this->motorrijtuig->getInkoopwaarde());
    }

    public function testInkoopwaardeNegativeValueShouldBeRejected()
    {
        try {
            $this->motorrijtuig->setInkoopwaarde(-100);
            $this->assertTrue(false);
        }
        catch( Exception $ex )
        {
            $this->assertTrue(true);
        }
    }

    public function testInkoopwaardeDecimalValueShouldBeRounded()
    {
        $this->motorrijtuig->setInkoopwaarde(100.10);
        $this->assertEquals(100, $this->motorrijtuig->getInkoopwaarde());
    }

    public function testInkoopwaardeNullShouldBecome0()
    {
        $this->motorrijtuig->setInkoopwaarde(null);
        $this->assertEquals(0, $this->motorrijtuig->getInkoopwaarde());
    }

    // TODO co2 uitstoot

    // TODO consumentenprijs

    // TODO netto catalogusprijs

    // TODO datum eerste ingebruikname

    // TODO datum eerste toelating
}
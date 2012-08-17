<?php
use BPMBerekening\Motorrijtuig\Motorfiets;

class TestMotorrijtuig extends PHPUnit_Framework_TestCase
{
    /**
     * @var Motorfiets
     */
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
        } catch (Exception $ex) {
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

    // CO2 uitstoot
    public function testCo2UitstootShouldBe0OrAbove()
    {
        $this->motorrijtuig->setCo2Uitstoot(0);
        $this->assertEquals(0, $this->motorrijtuig->getCo2Uitstoot());

        $this->motorrijtuig->setCo2Uitstoot(100);
        $this->assertEquals(100, $this->motorrijtuig->getCo2Uitstoot());
    }

    public function testCo2UitstootNegativeShouldBecome0()
    {
        $this->motorrijtuig->setCo2Uitstoot(-100);
        $this->assertEquals(0, $this->motorrijtuig->getCo2Uitstoot());
    }

    public function testCo2UitstootFloatShouldBecomeInt()
    {
        $this->motorrijtuig->setCo2Uitstoot(100.10);
        $this->assertEquals(100, $this->motorrijtuig->getCo2Uitstoot());

        $this->motorrijtuig->setCo2Uitstoot(100.50);
        $this->assertEquals(101, $this->motorrijtuig->getCo2Uitstoot());
    }

    // Consumentenprijs
    public function testConsumentenprijsShouldBecomeIntegerIfFloatPassed()
    {
        $this->motorrijtuig->setConsumentenprijs(10000.10);
        $this->assertEquals(10000, $this->motorrijtuig->getConsumentenprijs());
    }

    public function testConsumentenprijsCannotBeNegative()
    {
        $this->motorrijtuig->setConsumentenprijs(-10);
        $this->assertNotEquals(-10, $this->motorrijtuig->getConsumentenprijs());
    }

    // TODO test definitie van consumentenprijs (volgens Belastingdienst)

    // Netto catalogusprijs
    public function testNettoCatalogusPrijsIntegerShouldStayInteger()
    {
        $this->motorrijtuig->setNettoCatalogusprijs(10000);
        $this->assertEquals(10000, $this->motorrijtuig->getNettoCatalogusprijs());
    }

    public function testNettoCatalogusprijsCannotBeNegative()
    {
        $this->motorrijtuig->setNettoCatalogusprijs(-100);
        $this->assertEquals(0, $this->motorrijtuig->getNettoCatalogusprijs());
    }

    public function testNettoCatalogusprijsShouldBeInteger()
    {
        $this->motorrijtuig->setNettoCatalogusprijs(10000.10);
        $this->assertEquals(10000, $this->motorrijtuig->getNettoCatalogusprijs());
    }

    // Datum eerste ingebruikname
    public function testDatumEersteIngebruiknameShouldBeValidDate()
    {
        try {
            $this->motorrijtuig->setDatumIngebruikname(new DateTime("30-30-2030"));
            $this->assertEquals(true, false);
        } catch (Exception $ex) {
            $this->assertEquals(true, true);
        }
    }

    public function testDatumEersteIngebruiknameShouldBeInThePast()
    {
        $datetime_tomorrow = new DateTime(date("d-m-Y", strtotime("+1 day", time())));
        try {
            $this->motorrijtuig->setDatumIngebruikname($datetime_tomorrow);
            $this->assertEquals(true, false);
        } catch (Exception $ex) {
            $this->assertEquals(true, true);
        }
    }

    public function testDatumEersteIngebruiknameShouldBeAfterJanuary1900()
    {
        $this->assertEquals(false, $this->motorrijtuig->setDatumIngebruikname(new DateTime("31-12-1899")));
    }

    // TODO wat is het verschil tussen datum eerste ingebruikname en datum eerste toelating?
    // als dat het zelfde is dan moet 1 van de 2 komen te vervallen in de Motorrijtuig klasse
    // anders moet er een Unit test komen voor datum eerste toelating
}
<?php
use BPMBerekening\Afschrijvingsmethode\Koerslijst;
use BPMBerekening\Motorrijtuig\PersonenautoDiesel;

/**
 * User: dsessink
 * Date: 30-07-12
 * Time: 17:00
 */
class TestKoerslijst extends PHPUnit_Framework_TestCase
{
    /**
     * Test de afschrijving van een Motorrijtuig
     */
    public function testAfschrijving()
    {
        $Koerslijst = new Koerslijst();

        $afschrijving = $Koerslijst->berekenAfschrijving(10000, 5000);
        $this->assertEquals($afschrijving, 5000);

        $afschrijving = $Koerslijst->berekenAfschrijving(1, 0);
        $this->assertEquals($afschrijving, 1);

        $afschrijving = $Koerslijst->berekenAfschrijving(5000, 10000);
        $this->assertEquals($afschrijving, 0);

        $afschrijving = $Koerslijst->berekenAfschrijving(10000, 10000);
        $this->assertEquals($afschrijving, 0);
    }

    /**
     * Test het afschrijvingspercentage
     */
    public function testAfschrijvingsPercentageZonderWaarden()
    {
        $Koerslijst = new Koerslijst();

        // Expect an exception als er geen Motorrijtuig is gezet
        try {
            $Koerslijst->berekenAfschrijvingsPercentage(21700, 35000);
            $this->assertTrue(false);
        } catch (Exception $ex) {
            $this->assertTrue(true);
        }
    }

    // TODO
    public function testAfschrijvingsPercentageNormaal()
    {
//        $Koerslijst = new BPMBerekening\Afschrijvingsmethode\Koerslijst();
//        $Motorrijtuig = new \BPMBerekening\Motorrijtuig\Motorrijtuig();
//        $Motorrijtuig->setConsumentenprijs(35000);
//        $Motorrijtuig->getInkoopwaarde(15000);
//
//        $Koerslijst->setMotorrijtuig($Motorrijtuig);
//
//        $afschrijvingspercentage = $Koerslijst->berekenAfschrijvingsPercentage();
//        $this->assertEquals($afschrijvingspercentage, 62);
    }

    public function testAfschrijvingsPercentageVolledigAfgeschreven()
    {
        // TODO wat te doen als het afschrijvingsbedrag gelijk is aan de consumentenprijs?
        // misschien kan de PDF van de belastingdienst daar antwoord op geven.
        $Koerslijst = new Koerslijst();
        $motorrijtuig = new PersonenautoDiesel();
        $motorrijtuig->setConsumentenprijs(35000);
        $motorrijtuig->getInkoopwaarde(1);

        $Koerslijst->setMotorrijtuig($motorrijtuig);

        $afschrijvingspercentage = $Koerslijst->berekenAfschrijvingsPercentage();
        $this->assertEquals($afschrijvingspercentage, 100);
    }
}

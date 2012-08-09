<?php
require_once(dirname(__FILE__) . "/../models/koerslijst.php");

use \BPMBerekening\afschrijvingsmethode\Koerslijst;
use \BPMBerekening\models\motorrijtuig\Personenauto_Diesel;

/**
 * User: dsessink
 * Date: 30-07-12
 * Time: 17:00
 */
class TestKoerslijst extends PHPUnit_Framework_TestCase
{
    /**
     * Test de afschrijving van een motorrijtuig
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

        // Expect an exception als er geen motorrijtuig is gezet
        try {
            $Koerslijst->berekenAfschrijvingsPercentage(21700, 35000);
            $this->assertTrue(false);
        } catch( Exception $ex )
        {
            $this->assertTrue(true);
        }
    }

    public function testAfschrijvingsPercentageNormaal()
    {
        // TODO
//        $Koerslijst = new BPMBerekening\afschrijvingsmethode\Koerslijst();
//        $motorrijtuig = new \BPMBerekening\models\motorrijtuig\Motorrijtuig();
//        $motorrijtuig->setConsumentenprijs(35000);
//        $motorrijtuig->getInkoopwaarde(15000);
//
//        $Koerslijst->setMotorrijtuig($motorrijtuig);
//
//        $afschrijvingspercentage = $Koerslijst->berekenAfschrijvingsPercentage();
//        $this->assertEquals($afschrijvingspercentage, 62);
    }

    public function testAfschrijvingsPercentageVolledigAfgeschreven()
    {
        // TODO wat te doen als het afschrijvingsbedrag gelijk is aan de consumentenprijs?
        // misschien kan de PDF van de belastingdienst daar antwoord op geven.
        $Koerslijst = new Koerslijst();
        $motorrijtuig = new Personenauto_Diesel();
        $motorrijtuig->setConsumentenprijs(35000);
        $motorrijtuig->getInkoopwaarde(1);

        $Koerslijst->setMotorrijtuig($motorrijtuig);

        $afschrijvingspercentage = $Koerslijst->berekenAfschrijvingsPercentage();
        $this->assertEquals($afschrijvingspercentage, 100);
    }
}

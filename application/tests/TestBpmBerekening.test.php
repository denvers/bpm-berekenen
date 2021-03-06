<?php
use BPMBerekening\BPMBerekening;
use BPMBerekening\Motorrijtuig\PersonenautoDiesel;

class TestBpmBerekening extends PHPUnit_Framework_TestCase
{
    // setSoortAuto
    public function testSoortAutoPersonenautoDieselShouldReturnPersonenautoDiesel()
    {
        $bpmberekening = new BPMBerekening();
        $bpmberekening->setBrandstof("diesel");
        $bpmberekening->setSoortAuto("personenauto");

        $this->assertEquals(true, $bpmberekening->getMotorrijtuig() instanceof \BPMBerekening\Motorrijtuig\PersonenautoDiesel);
    }

    public function testSoortAutoPersonenautoBenzineShouldReturnPersonenautoGeenDiesel()
    {
        $bpmberekening = new BPMBerekening();
        $bpmberekening->setBrandstof("benzine");
        $bpmberekening->setSoortAuto("personenauto");

        $this->assertEquals(true, $bpmberekening->getMotorrijtuig() instanceof \BPMBerekening\Motorrijtuig\PersonenautoGeenDiesel);
    }

    public function testSoortAutoPersonenautoLpgShouldReturnPersonenautoGeenDiesel()
    {
        $bpmberekening = new BPMBerekening();
        $bpmberekening->setBrandstof("lpg");
        $bpmberekening->setSoortAuto("personenauto");

        $this->assertEquals(true, $bpmberekening->getMotorrijtuig() instanceof \BPMBerekening\Motorrijtuig\PersonenautoGeenDiesel);
    }

    // Kampeerauto
    public function testSoortAutoKampeerautoDieselShouldReturnKampeerautoDiesel()
    {
        $bpmberekening = new BPMBerekening();
        $bpmberekening->setBrandstof("diesel");
        $bpmberekening->setSoortAuto("kampeerauto");

        $this->assertEquals(true, $bpmberekening->getMotorrijtuig() instanceof \BPMBerekening\Motorrijtuig\KampeerautoDiesel);
    }

    public function testSoortAutoKampeerautoBenzineShouldReturnKampeerautoBenzine()
    {
        $bpmberekening = new BPMBerekening();
        $bpmberekening->setBrandstof("benzine");
        $bpmberekening->setSoortAuto("kampeerauto");

        $this->assertEquals(true, $bpmberekening->getMotorrijtuig() instanceof \BPMBerekening\Motorrijtuig\KampeerautoGeenDiesel);
    }

    public function testSoortAutoKampeerautoLpgShouldReturnKampeerautoGeenDiesel()
    {
        $bpmberekening = new BPMBerekening();
        $bpmberekening->setBrandstof("lpg");
        $bpmberekening->setSoortAuto("kampeerauto");

        $this->assertEquals(true, $bpmberekening->getMotorrijtuig() instanceof \BPMBerekening\Motorrijtuig\KampeerautoGeenDiesel);
    }

    // Bestelauto
    public function testSoortAutoBestelautoDieselShouldReturnBestelautoDiesel()
    {
        $bpmberekening = new BPMBerekening();
        $bpmberekening->setBrandstof("diesel");
        $bpmberekening->setSoortAuto("bestelauto");

        $this->assertEquals(true, $bpmberekening->getMotorrijtuig() instanceof \BPMBerekening\Motorrijtuig\BestelautoDiesel);
    }

    public function testSoortBestelautoBenzineShouldReturnBestelautoGeenDiesel()
    {
        $bpmberekening = new BPMBerekening();
        $bpmberekening->setBrandstof("benzine");
        $bpmberekening->setSoortAuto("bestelauto");

        $this->assertEquals(true, $bpmberekening->getMotorrijtuig() instanceof \BPMBerekening\Motorrijtuig\BestelautoGeenDiesel);
    }

    public function testSoortBestelautoLpgShouldReturnBestelautoGeenDiesel()
    {
        $bpmberekening = new BPMBerekening();
        $bpmberekening->setBrandstof("lpg");
        $bpmberekening->setSoortAuto("bestelauto");

        $this->assertEquals(true, $bpmberekening->getMotorrijtuig() instanceof \BPMBerekening\Motorrijtuig\BestelautoGeenDiesel);
    }

    // Motorfiets
    public function testSoortAutoMotorfietsBenzineShouldReturnMotorfiets()
    {
        $bpmberekening = new BPMBerekening();
        $bpmberekening->setBrandstof("benzine");
        $bpmberekening->setSoortAuto("motorfiets");

        $this->assertEquals(true, $bpmberekening->getMotorrijtuig() instanceof \BPMBerekening\Motorrijtuig\Motorfiets);
    }

    public function testSoortAutoMotorfietsDieselShouldReturnMotorfiets()
    {
        $bpmberekening = new BPMBerekening();
        $bpmberekening->setBrandstof("diesel");
        $bpmberekening->setSoortAuto("motorfiets");

        $this->assertEquals(true, $bpmberekening->getMotorrijtuig() instanceof \BPMBerekening\Motorrijtuig\Motorfiets);
    }

    public function testSoortAutoMotorfietsLpgShouldReturnMotorfiets()
    {
        $bpmberekening = new BPMBerekening();
        $bpmberekening->setBrandstof("lpg");
        $bpmberekening->setSoortAuto("motorfiets");

        $this->assertEquals(true, $bpmberekening->getMotorrijtuig() instanceof \BPMBerekening\Motorrijtuig\Motorfiets);
    }

    /**
     * Test de bpm berekening met onvoldoende input
     */
    public function testBpmBerekeningZonderWaardes()
    {
        // Verwacht een exception bij het berekenen van de BPM zonder voldoende input.
        try {
            $BpmBerekening = new BPMBerekening();
            $BpmBerekening->berekenBPM();
            $this->assertTrue(false);
        } catch (Exception $ex) {
            $this->assertTrue(true);
        }
    }

    /**
     * Test BPM over CO2 uitstoot Benzine personen auto
     *
     * @requirement 18: CO2 uitstoot van 0 tot en met 102 gram/km: trek van de CO2-uitstoot van de auto de waarde 0 af vermenigvuldig de uitkomst met het bedrag 0 tel hier het bedrag 0 bij op
     * @requirement 19: CO2 uitstoot van 102 tot en met 159 gram/km: trek van de CO2-uitstoot van de auto de waarde 102 af vermenigvuldig de uitkomst met het bedrag 101 tel hier het bedrag 0 bij op
     * @requirement 20: CO2 uitstoot van 159 tot en met 237 gram/km: trek van de CO2-uitstoot van de auto de waarde 159 af vermenigvuldig de uitkomst met het bedrag 121 tel hier het bedrag 5757 bij op
     * @requirement 21: CO2 uitstoot van 237 tot en met 242 gram/km: trek van de CO2-uitstoot van de auto de waarde 237 af vermenigvuldig de uitkomst met het bedrag 223 tel hier het bedrag 15195 bij op
     * @requirement 22: CO2 uitstoot van 242 en hoger: trek van de CO2-uitstoot van de auto de waarde 242 af vermenigvuldig de uitkomst met het bedrag 559 tel hier het bedrag 16310 bij op
     *
     * Naar het voorbeeld van:
     * http://www.belastingdienst.nl/wps/wcm/connect/bldcontentnl/belastingdienst/prive/auto_en_vervoer/belastingen_op_auto_en_motor/belasting_van_personenautos_en_motorrijwielen_bpm/bereken_de_bpm/bereken_de_bpm_voor_een_personenauto
     */
    public function testBpmOverCO2UitstootPersonenAutoBenzine()
    {
        $BpmBerekening = new BPMBerekening();

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("benzine", 0);
        $this->assertEquals($bpm, 0);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("benzine", 101);
        $this->assertEquals($bpm, 0);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("benzine", 102);
        $this->assertEquals($bpm, 0);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("benzine", 159);
        $this->assertEquals($bpm, 5757);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("benzine", 160);
        $this->assertEquals($bpm, 5878);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("benzine", 200);
        $this->assertEquals($bpm, 10718);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("benzine", 237);
        $this->assertEquals($bpm, 15195);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("benzine", 238);
        $this->assertEquals($bpm, 15418);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("benzine", 242);
        $this->assertEquals($bpm, 16310);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("benzine", 1000);
        $this->assertEquals($bpm, 440032);
    }

    /**
     * @requirement 18: CO2 uitstoot van 0 tot en met 102 gram/km: trek van de CO2-uitstoot van de auto de waarde 0 af vermenigvuldig de uitkomst met het bedrag 0 tel hier het bedrag 0 bij op
     * @requirement 19: CO2 uitstoot van 102 tot en met 159 gram/km: trek van de CO2-uitstoot van de auto de waarde 102 af vermenigvuldig de uitkomst met het bedrag 101 tel hier het bedrag 0 bij op
     * @requirement 20: CO2 uitstoot van 159 tot en met 237 gram/km: trek van de CO2-uitstoot van de auto de waarde 159 af vermenigvuldig de uitkomst met het bedrag 121 tel hier het bedrag 5757 bij op
     * @requirement 21: CO2 uitstoot van 237 tot en met 242 gram/km: trek van de CO2-uitstoot van de auto de waarde 237 af vermenigvuldig de uitkomst met het bedrag 223 tel hier het bedrag 15195 bij op
     * @requirement 22: CO2 uitstoot van 242 en hoger: trek van de CO2-uitstoot van de auto de waarde 242 af vermenigvuldig de uitkomst met het bedrag 559 tel hier het bedrag 16310 bij op
     */
    public function testBpmOverCO2UitstootPersonenAutoAardgas()
    {
        $BpmBerekening = new BPMBerekening();

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("aardgas", 0);
        $this->assertEquals($bpm, 0);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("aardgas", 101);
        $this->assertEquals($bpm, 0);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("aardgas", 102);
        $this->assertEquals($bpm, 0);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("aardgas", 159);
        $this->assertEquals($bpm, 5757);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("aardgas", 160);
        $this->assertEquals($bpm, 5878);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("aardgas", 200);
        $this->assertEquals($bpm, 10718);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("aardgas", 237);
        $this->assertEquals($bpm, 15195);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("aardgas", 238);
        $this->assertEquals($bpm, 15418);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("aardgas", 242);
        $this->assertEquals($bpm, 16310);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("aardgas", 1000);
        $this->assertEquals($bpm, 440032);
    }

    /**
     * @requirement 18: CO2 uitstoot van 0 tot en met 102 gram/km: trek van de CO2-uitstoot van de auto de waarde 0 af vermenigvuldig de uitkomst met het bedrag 0 tel hier het bedrag 0 bij op
     * @requirement 19: CO2 uitstoot van 102 tot en met 159 gram/km: trek van de CO2-uitstoot van de auto de waarde 102 af vermenigvuldig de uitkomst met het bedrag 101 tel hier het bedrag 0 bij op
     * @requirement 20: CO2 uitstoot van 159 tot en met 237 gram/km: trek van de CO2-uitstoot van de auto de waarde 159 af vermenigvuldig de uitkomst met het bedrag 121 tel hier het bedrag 5757 bij op
     * @requirement 21: CO2 uitstoot van 237 tot en met 242 gram/km: trek van de CO2-uitstoot van de auto de waarde 237 af vermenigvuldig de uitkomst met het bedrag 223 tel hier het bedrag 15195 bij op
     * @requirement 22: CO2 uitstoot van 242 en hoger: trek van de CO2-uitstoot van de auto de waarde 242 af vermenigvuldig de uitkomst met het bedrag 559 tel hier het bedrag 16310 bij op
     */
    public function testBpmOverCO2UitstootPersonenAutoLpg()
    {
        $BpmBerekening = new BPMBerekening();

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("lpg", 0);
        $this->assertEquals($bpm, 0);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("lpg", 101);
        $this->assertEquals($bpm, 0);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("lpg", 102);
        $this->assertEquals($bpm, 0);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("lpg", 159);
        $this->assertEquals($bpm, 5757);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("lpg", 160);
        $this->assertEquals($bpm, 5878);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("lpg", 200);
        $this->assertEquals($bpm, 10718);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("lpg", 237);
        $this->assertEquals($bpm, 15195);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("lpg", 238);
        $this->assertEquals($bpm, 15418);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("lpg", 242);
        $this->assertEquals($bpm, 16310);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("lpg", 1000);
        $this->assertEquals($bpm, 440032);
    }

    /**
     * Test BPM over CO2 uitstoot diesel personenauto
     *
     * Naar het voorbeeld van:
     * http://www.belastingdienst.nl/wps/wcm/connect/bldcontentnl/belastingdienst/prive/auto_en_vervoer/belastingen_op_auto_en_motor/belasting_van_personenautos_en_motorrijwielen_bpm/bereken_de_bpm/bereken_de_bpm_voor_een_personenauto
     * http://www.belastingdienst.nl/wps/wcm/connect/bldcontentnl/belastingdienst/prive/auto_en_vervoer/belastingen_op_auto_en_motor/belasting_van_personenautos_en_motorrijwielen_bpm/waarover_bpm_berekenen/bpm_tarief
     */
    public function testBpmOverCO2UitstootPersonenAutoDiesel()
    {
        $BpmBerekening = new BPMBerekening();

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("diesel", 0);
        $this->assertEquals($bpm, 0);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("diesel", 90);
        $this->assertEquals($bpm, 0);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("diesel", 91);
        $this->assertEquals($bpm, 0);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("diesel", 160);
        $this->assertEquals($bpm, 7309);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("diesel", 200);
        $this->assertEquals(12149, $bpm);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("diesel", 211);
        $this->assertEquals(13480, $bpm);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("diesel", 300);
        $this->assertEquals(41757, $bpm);
    }

    /**
     * Test BPM over Netto Catalogusprijs benzine personenauto
     *
     * @requirement 28: Geen diesel: 11,1% van netto-catalogusprijs en daar 450 EUR van aftrekken
     */
    public function testBpmOverNettoCatalogusprijsPersonenAutoBenzine()
    {
        $BpmBerekening = new BPMBerekening();
        $BpmBerekening->setSoortAuto("personenauto");

        $bpm = $BpmBerekening->berekenBpmOverCatalogusprijs("benzine", 25000, 0);
        $this->assertEquals(2325, $bpm);

        $bpm = $BpmBerekening->berekenBpmOverCatalogusprijs("benzine", 25000.1, 0);
        $this->assertEquals($bpm, 2325);

        $bpm = $BpmBerekening->berekenBpmOverCatalogusprijs("benzine", 25000.4, 0);
        $this->assertEquals($bpm, 2325);

        $bpm = $BpmBerekening->berekenBpmOverCatalogusprijs("benzine", 25000, -100);
        $this->assertEquals($bpm, 2325);

        $bpm = $BpmBerekening->berekenBpmOverCatalogusprijs("benzine", 25000, 100);
        $this->assertEquals($bpm, 2325);

        $bpm = $BpmBerekening->berekenBpmOverCatalogusprijs("benzine", 25000, 10.10);
        $this->assertEquals($bpm, 2325);

        $bpm = $BpmBerekening->berekenBpmOverCatalogusprijs("benzine", 1000, 0);
        $this->assertEquals(0, $bpm);

        $bpm = $BpmBerekening->berekenBpmOverCatalogusprijs("benzine", 1000, 1000);
        $this->assertEquals(0, $bpm);

        $bpm = $BpmBerekening->berekenBpmOverCatalogusprijs("lpg", 1000, 0);
        $this->assertEquals(0, $bpm);
    }

    /**
     * Test bpm berekening over netto catalogusprijs personenauto diesel
     * @requirement 29: Diesel: 11,1% van netto-catalogusprijs
     * @requirement 30: Diesel: Indien CO2-uitstoot boven 70 gram/km: 40,68EUR per gram/km CO2-uitstoot optellen
     */
    public function testBpmOverNettoCatalogusprijsPersonenAutoDiesel()
    {
        $BpmBerekening = new BPMBerekening();
        $BpmBerekening->setSoortAuto("personenauto");

        $bpm = $BpmBerekening->berekenBpmOverCatalogusprijs("diesel", 25000, 0);
        $this->assertNotEquals(0, $bpm);

        $bpm = $BpmBerekening->berekenBpmOverCatalogusprijs("diesel", 1000, 0);
        $this->assertNotEquals(110.10, $bpm);

        $bpm = $BpmBerekening->berekenBpmOverCatalogusprijs("diesel", 1000, 70);
        $this->assertNotEquals(110.10, $bpm);

        $bpm = $BpmBerekening->berekenBpmOverCatalogusprijs("diesel", 1000, 71);
        $this->assertNotEquals(150.78, $bpm);

        $bpm = $BpmBerekening->berekenBpmOverCatalogusprijs("diesel", 25000, 200);
        $this->assertEquals($bpm, 8063);

        $bpm = $BpmBerekening->berekenBpmOverCatalogusprijs("diesel", 25000.1, 200);
        $this->assertEquals($bpm, 8063);

        $bpm = $BpmBerekening->berekenBpmOverCatalogusprijs("diesel", 25000.4, 200);
        $this->assertEquals($bpm, 8063);

        $bpm = $BpmBerekening->berekenBpmOverCatalogusprijs("diesel", 21116, 160);
        $this->assertEquals($bpm, 6004);
    }

//    TODO
//    Voldoet uw dieselpersonenauto of dieselkampeerauto aan de Euro 6-norm?
//    En is uw dieselpersonenauto of dieselkampeerauto op naam gesteld na 31 december 2011?
//    Dan krijgt u een korting op de bpm van € 1.000.
    public function testEuro6NormDieselPersonenAuto()
    {
        $BpmBerekening = new BPMBerekening();

        $BpmBerekening->setSoortAuto("personenauto");
        $BpmBerekening->setBrandstof("diesel");
        $BpmBerekening->setCo2Uitstoot(160);
        $BpmBerekening->setConsumentenprijs(35000);
        $BpmBerekening->setNettoCatalogusprijs(21116);
        $BpmBerekening->setDatum(new DateTime("now"));
        $BpmBerekening->setDatumEersteIngebruikname("08-04-2010");
        $BpmBerekening->setInkoopwaarde(13300);
        $BpmBerekening->setEuro6Norm(true);

        $berekend = $BpmBerekening->berekenBPM();

        $this->assertTrue(is_array($berekend));
        $this->assertTrue(isset($berekend['koerslijst']));

        $this->assertEquals(1000, $berekend['koerslijst']['euro6_norm_korting']);
        $this->assertEquals(4058, $berekend['koerslijst']['netto_bpm']);
    }

    // TODO http://www.belastingdienst.nl/wps/wcm/connect/bldcontentnl/belastingdienst/prive/auto_en_vervoer/belastingen_op_auto_en_motor/belasting_van_personenautos_en_motorrijwielen_bpm/waarover_bpm_berekenen/bpm_tarief_co_2_uitstoot_personenauto
    public function testBpmBerekeningKampeerauto()
    {
    }

    // TODO
    public function testBpmBerekeningBestelauto()
    {
    }

    // TODO
    public function testBpmBerekeningMotorfiets()
    {
    }

    /**
     * Test de bruto bpm berekening
     */
    public function testBrutoBpm()
    {
        $BpmBerekening = new BPMBerekening();

        $brutobpm = $BpmBerekening->berekenBrutoBpm(0, 0);
        $this->assertEquals($brutobpm, 0);

        $brutobpm = $BpmBerekening->berekenBrutoBpm(1, 0);
        $this->assertEquals($brutobpm, 1);

        $brutobpm = $BpmBerekening->berekenBrutoBpm(0, 1);
        $this->assertEquals($brutobpm, 1);

        $brutobpm = $BpmBerekening->berekenBrutoBpm(1, 1);
        $this->assertEquals($brutobpm, 2);

        $brutobpm = $BpmBerekening->berekenBrutoBpm(7309, 6004);
        $this->assertEquals($brutobpm, 13313);
    }

    /**
     * Test de netto bpm berekening
     * TODO bpm berekening volgens koerslijst controleren
     */
    public function testTeBetalenBpm()
    {
        $BpmBerekening = new BPMBerekening();

        $BpmBerekening->setSoortAuto("personenauto");
        $BpmBerekening->setBrandstof("diesel");
        $BpmBerekening->setCo2Uitstoot(160);
        $BpmBerekening->setConsumentenprijs(35000);
        $BpmBerekening->setNettoCatalogusprijs(21116);
        $BpmBerekening->setDatum(new DateTime("now"));
        $BpmBerekening->setDatumEersteIngebruikname("08-04-2010");
        $BpmBerekening->setInkoopwaarde(13300);

        $berekend = $BpmBerekening->berekenBPM();

        $this->assertTrue(is_array($berekend));
        $this->assertTrue(isset($berekend['koerslijst']));
        $this->assertTrue(isset($berekend['forfaitaire_tabel']));
//        $this->assertTrue( isset($berekend['taxatierapport']) );

        // koerslijst
//        $this->assertEquals( $berekend['koerslijst']['afschrijving'], 21700 );
//        $this->assertEquals( $berekend['koerslijst']['afschrijvingspercentage'], 62 );
//        $this->assertEquals( $berekend['koerslijst']['bpm_over_c02_uitstoot'], 7309 );
//        $this->assertEquals( $berekend['koerslijst']['bpm_over_catalogusprijs'], 6004 );
//        $this->assertEquals( $berekend['koerslijst']['bruto_bpm'], 13313 );
//        $this->assertEquals( $berekend['koerslijst']['netto_bpm'], 5058 );
    }
}
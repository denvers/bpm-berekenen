<?php
require_once(dirname(__FILE__) . "/../models/bpm_berekening.php");

class TestBpmBerekening extends PHPUnit_Framework_TestCase
{

    public function testBpmBerekeningZonderWaardes()
    {
//        FIXME
    }

    /**
     * Test BPM over CO2 uitstoot Benzine personen auto
     *
     * Naar het voorbeeld van:
     * http://www.belastingdienst.nl/wps/wcm/connect/bldcontentnl/belastingdienst/prive/auto_en_vervoer/belastingen_op_auto_en_motor/belasting_van_personenautos_en_motorrijwielen_bpm/bereken_de_bpm/bereken_de_bpm_voor_een_personenauto
     */
    public function testBpmOverCO2UitstootPersonenAutoBenzine()
    {
        $BpmBerekening = new \BPMBerekening\models\BPM_Berekening();

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

    public function testBpmOverCO2UitstootPersonenAutoAardgas()
    {
        $BpmBerekening = new \BPMBerekening\models\BPM_Berekening();

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

    public function testBpmOverCO2UitstootPersonenAutoLpg()
    {
        $BpmBerekening = new \BPMBerekening\models\BPM_Berekening();

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
        $BpmBerekening = new \BPMBerekening\models\BPM_Berekening();

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("diesel", 0);
        $this->assertEquals($bpm, 0);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("diesel", 90);
        $this->assertEquals($bpm, 0);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("diesel", 91);
        $this->assertEquals($bpm, 0);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("diesel", 160);
        $this->assertEquals($bpm, 7309);

        $bpm = $BpmBerekening->berekenBpmOverCO2Uitstoot("diesel", 200);
        $this->assertEquals($bpm, 12149);

        // FIXME ook randvoorwaarden testen
    }

    /**
     * Test BPM over Netto Catalogusprijs benzine personenauto
     */
    public function testBpmOverNettoCatalogusprijsPersonenAutoBenzine()
    {
        $BpmBerekening = new \BPMBerekening\models\BPM_Berekening();

        $bpm = $BpmBerekening->berekenBpmOverCatalogusprijs("benzine", 25000, 0);
        $this->assertEquals($bpm, 2325);

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
    }

    public function testBpmOverNettoCatalogusprijsPersonenAutoDiesel()
    {
        $BpmBerekening = new BPMBerekening\models\BPM_Berekening();

        $bpm = $BpmBerekening->berekenBpmOverCatalogusprijs("diesel", 25000, 0);
        $this->assertNotEquals($bpm, 0);

        $bpm = $BpmBerekening->berekenBpmOverCatalogusprijs("diesel", 25000, 200);
        $this->assertEquals($bpm, 8063);

        $bpm = $BpmBerekening->berekenBpmOverCatalogusprijs("diesel", 25000.1, 200);
        $this->assertEquals($bpm, 8063);

        $bpm = $BpmBerekening->berekenBpmOverCatalogusprijs("diesel", 25000.4, 200);
        $this->assertEquals($bpm, 8063);

        $bpm = $BpmBerekening->berekenBpmOverCatalogusprijs("diesel", 21116, 160);
        $this->assertEquals($bpm, 6004);
    }

//    FIXME
//    Voldoet uw dieselpersonenauto of dieselkampeerauto aan de Euro 6-norm?
//    En is uw dieselpersonenauto of dieselkampeerauto op naam gesteld na 31 december 2011?
//    Dan krijgt u een korting op de bpm van € 1.000.
    public function testEuro6NormDieselPersonenAuto()
    {

    }

    // FIXME http://www.belastingdienst.nl/wps/wcm/connect/bldcontentnl/belastingdienst/prive/auto_en_vervoer/belastingen_op_auto_en_motor/belasting_van_personenautos_en_motorrijwielen_bpm/waarover_bpm_berekenen/bpm_tarief_co_2_uitstoot_personenauto
    public function testBpmBerekeningKampeerauto()
    {
    }

    public function testBpmBerekeningBestelauto()
    {
    }

    public function testBpmBerekeningMotorfiets()
    {
    }

    /**
     * Test de afschrijving van een motorrijtuig
     */
    public function testAfschrijving()
    {
        $BpmBerekening = new BPMBerekening\models\BPM_Berekening();

        $afschrijving = $BpmBerekening->berekenAfschrijving(10000, 5000);
        $this->assertEquals($afschrijving, 5000);

        $afschrijving = $BpmBerekening->berekenAfschrijving(1, 0);
        $this->assertEquals($afschrijving, 1);

        $afschrijving = $BpmBerekening->berekenAfschrijving(5000, 10000);
        $this->assertEquals($afschrijving, 0);

        $afschrijving = $BpmBerekening->berekenAfschrijving(10000, 10000);
        $this->assertEquals($afschrijving, 0);
    }

    /**
     * Test het afschrijvingspercentage
     */
    public function testAfschrijvingsPercentage()
    {
        $BpmBerekening = new BPMBerekening\models\BPM_Berekening();

        $afschrijvingspercentage = $BpmBerekening->berekenAfschrijvingsPercentage(21700, 35000);
        $this->assertEquals($afschrijvingspercentage, 62);

        // FIXME wat te doen als het afschrijvingsbedrag gelijk is aan de consumentenprijs?
        // misschien kan de PDF van de belastingdienst daar antwoord op geven.
        $afschrijvingspercentage = $BpmBerekening->berekenAfschrijvingsPercentage(35000, 35000);
        $this->assertEquals($afschrijvingspercentage, 100);
    }

    /**
     * Test de bruto bpm berekening
     */
    public function testBrutoBpm()
    {
        $BpmBerekening = new BPMBerekening\models\BPM_Berekening();

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

    public function testTeBetalenBpm()
    {
        $BpmBerekening = new \BPMBerekening\models\BPM_Berekening();

        $BpmBerekening->setBrandstof("diesel");
        $BpmBerekening->setCo2Uitstoot(160);
        $BpmBerekening->setConsumentenprijs(35000);
        $BpmBerekening->setNettoCatalogusprijs(21116);
        $BpmBerekening->setDatum( new DateTime("now") );
        $BpmBerekening->setDatumEersteIngebruikname("08-04-2010");
        $BpmBerekening->setInkoopwaarde(13300);
        $BpmBerekening->setSoortAuto("personenauto");

        $berekend = $BpmBerekening->berekenBPM();

        $this->assertTrue( is_array($berekend) );

        $this->assertEquals( $berekend['afschrijving'], 21700 );
        $this->assertEquals( $berekend['afschrijvingspercentage'], 62 );
        $this->assertEquals( $berekend['bpm_over_c02_uitstoot'], 7309 );
        $this->assertEquals( $berekend['bpm_over_catalogusprijs'], 6004 );
        $this->assertEquals( $berekend['bruto_bpm'], 13313 );
        $this->assertEquals( $berekend['netto_bpm'], 5058 );
    }
}
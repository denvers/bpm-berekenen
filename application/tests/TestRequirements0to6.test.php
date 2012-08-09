<?php
use BPMBerekening\BPMBerekening;

/**
 * Deze test class dekt de requirements 1 t/m 6
 */
class TestRequirements0to6 extends PHPUnit_Framework_TestCase
{
    /**
     * @requirement 1
     * @desc        U betaalt geen bpm voor personenauto’s met een CO2-uitstoot van 0 gram per kilometer.
     */
    public function testRequirement1()
    {
        $BpmBerekening = new BPMBerekening();

        // dieselpersonenauto
        $BpmBerekening->setSoortAuto("personenauto");
        $BpmBerekening->setBrandstof("diesel");
        $BpmBerekening->setCo2Uitstoot(0);
        $BpmBerekening->setConsumentenprijs(35000);
        $BpmBerekening->setNettoCatalogusprijs(21116);
        $BpmBerekening->setDatum(new DateTime("now"));
        $BpmBerekening->setDatumEersteIngebruikname("08-04-2010");
        $BpmBerekening->setInkoopwaarde(13300);

        $berekend = $BpmBerekening->berekenBPM();

        $this->assertEquals(0, $berekend['koerslijst']['netto_bpm']);

        // benzinepersonenauto
        $BpmBerekening->setSoortAuto("personenauto");
        $BpmBerekening->setBrandstof("benzine");
        $BpmBerekening->setCo2Uitstoot(0);
        $BpmBerekening->setConsumentenprijs(35000);
        $BpmBerekening->setNettoCatalogusprijs(21116);
        $BpmBerekening->setDatum(new DateTime("now"));
        $BpmBerekening->setDatumEersteIngebruikname("08-04-2010");
        $BpmBerekening->setInkoopwaarde(13300);

        $berekend = $BpmBerekening->berekenBPM();

        $this->assertEquals(0, $berekend['koerslijst']['netto_bpm']);
    }

    /**
     * @requirement 2
     * @desc        U betaalt geen bpm voor bestelauto’s met een CO2-uitstoot van 0 gram per kilometer.
     */
    public function testRequirement2()
    {
        $BpmBerekening = new BPMBerekening();

        // dieselbestelauto
        $BpmBerekening->setSoortAuto("bestelauto");
        $BpmBerekening->setBrandstof("diesel");
        $BpmBerekening->setCo2Uitstoot(0);
        $BpmBerekening->setConsumentenprijs(35000);
        $BpmBerekening->setNettoCatalogusprijs(21116);
        $BpmBerekening->setDatum(new DateTime("now"));
        $BpmBerekening->setDatumEersteIngebruikname("08-04-2010");
        $BpmBerekening->setInkoopwaarde(13300);

        $berekend = $BpmBerekening->berekenBPM();

        $this->assertEquals(0, $berekend['koerslijst']['netto_bpm']);

        // benzinebestelauto
        $BpmBerekening->setSoortAuto("bestelauto");
        $BpmBerekening->setBrandstof("benzine");
        $BpmBerekening->setCo2Uitstoot(0);
        $BpmBerekening->setConsumentenprijs(35000);
        $BpmBerekening->setNettoCatalogusprijs(21116);
        $BpmBerekening->setDatum(new DateTime("now"));
        $BpmBerekening->setDatumEersteIngebruikname("08-04-2010");
        $BpmBerekening->setInkoopwaarde(13300);

        $berekend = $BpmBerekening->berekenBPM();

        $this->assertEquals(0, $berekend['koerslijst']['netto_bpm']);
    }

    /**
     * @requirement 3
     * @desc        U betaalt geen bpm voor kampeerauto’s met een CO2-uitstoot van 0 gram per kilometer.
     */
    public function testRequirement3()
    {
        $BpmBerekening = new BPMBerekening();

        // dieselkampeerauto
        $BpmBerekening->setSoortAuto("kampeerauto");
        $BpmBerekening->setBrandstof("diesel");
        $BpmBerekening->setCo2Uitstoot(0);
        $BpmBerekening->setConsumentenprijs(35000);
        $BpmBerekening->setNettoCatalogusprijs(21116);
        $BpmBerekening->setDatum(new DateTime("now"));
        $BpmBerekening->setDatumEersteIngebruikname("08-04-2010");
        $BpmBerekening->setInkoopwaarde(13300);

        $berekend = $BpmBerekening->berekenBPM();

        $this->assertEquals(0, $berekend['koerslijst']['netto_bpm']);

        // benzinekampeerauto
        $BpmBerekening->setSoortAuto("kampeerauto");
        $BpmBerekening->setBrandstof("benzine");
        $BpmBerekening->setCo2Uitstoot(0);
        $BpmBerekening->setConsumentenprijs(35000);
        $BpmBerekening->setNettoCatalogusprijs(21116);
        $BpmBerekening->setDatum(new DateTime("now"));
        $BpmBerekening->setDatumEersteIngebruikname("08-04-2010");
        $BpmBerekening->setInkoopwaarde(13300);

        $berekend = $BpmBerekening->berekenBPM();

        $this->assertEquals(0, $berekend['koerslijst']['netto_bpm']);
    }

    /**
     * @requirement 4
     * @desc        U betaalt geen bpm voor motoren met een CO2-uitstoot van 0 gram per kilometer.
     */
    public function testRequirement4()
    {
        $BpmBerekening = new BPMBerekening();

        $BpmBerekening->setSoortAuto("motorfiets");
        $BpmBerekening->setBrandstof("benzine");
        $BpmBerekening->setCo2Uitstoot(0);
        $BpmBerekening->setConsumentenprijs(35000);
        $BpmBerekening->setNettoCatalogusprijs(21116);
        $BpmBerekening->setDatum(new DateTime("now"));
        $BpmBerekening->setDatumEersteIngebruikname("08-04-2010");
        $BpmBerekening->setInkoopwaarde(13300);

        $berekend = $BpmBerekening->berekenBPM();

        $this->assertEquals(0, $berekend['koerslijst']['netto_bpm']);
    }

    /**
     * @requirement 5
     * @desc        U betaalt ook geen bpm voor personenauto’s die op of na 1 januari 2009 voor het eerst in gebruik zijn genomen en uitgerust zijn met een benzinemotor met een CO2-uitstoot van maximaal 102 gram per kilometer
     */
    public function testRequirement5()
    {
        $BpmBerekening = new BPMBerekening();

        // personenauto, benzine, 1-1-2009, 102 gr/km
        $BpmBerekening->setSoortAuto("personenauto");
        $BpmBerekening->setBrandstof("benzine");
        $BpmBerekening->setDatumEersteIngebruikname("01-01-2009");
        $BpmBerekening->setCo2Uitstoot(102);

        $BpmBerekening->setConsumentenprijs(35000);
        $BpmBerekening->setNettoCatalogusprijs(21116);
        $BpmBerekening->setDatum(new DateTime("now"));
        $BpmBerekening->setInkoopwaarde(13300);

        $berekend = $BpmBerekening->berekenBPM();

        $this->assertEquals(0, $berekend['koerslijst']['netto_bpm']);
    }

    public function testRequirement5_LatereEersteIngebruikname()
    {
        $BpmBerekening = new BPMBerekening();

        // personenauto, benzine, 1-1-2011, 102 gr/km
        $BpmBerekening->setSoortAuto("personenauto");
        $BpmBerekening->setBrandstof("benzine");
        $BpmBerekening->setDatumEersteIngebruikname("01-01-2011");
        $BpmBerekening->setCo2Uitstoot(102);

        $BpmBerekening->setConsumentenprijs(35000);
        $BpmBerekening->setNettoCatalogusprijs(21116);
        $BpmBerekening->setDatum(new DateTime("now"));
        $BpmBerekening->setInkoopwaarde(13300);

        $berekend = $BpmBerekening->berekenBPM();

        $this->assertEquals(0, $berekend['koerslijst']['netto_bpm']);
    }

    public function testRequirement5_LagereCO2Uitstoot()
    {
        $BpmBerekening = new BPMBerekening();

        // personenauto, benzine, 1-1-2011, 50 gr/km
        $BpmBerekening->setSoortAuto("personenauto");
        $BpmBerekening->setBrandstof("benzine");
        $BpmBerekening->setDatumEersteIngebruikname("01-01-2011");
        $BpmBerekening->setCo2Uitstoot(50);

        $BpmBerekening->setConsumentenprijs(35000);
        $BpmBerekening->setNettoCatalogusprijs(21116);
        $BpmBerekening->setDatum(new DateTime("now"));
        $BpmBerekening->setInkoopwaarde(13300);

        $berekend = $BpmBerekening->berekenBPM();

        $this->assertEquals(0, $berekend['koerslijst']['netto_bpm']);
    }

    /**
     * @requirement 6
     * @desc        U betaalt ook geen bpm voor personenauto’s die op of na 1 januari 2009 voor het eerst in gebruik zijn genomen en uitgerust zijn met een dieselmotor met een CO2-uitstoot van maximaal 91 gram per kilometer
     */
    public function testRequirement6()
    {
        $BpmBerekening = new BPMBerekening();

        // personenauto, diesel, 1-1-2009, 91 gr/km
        $BpmBerekening->setSoortAuto("personenauto");
        $BpmBerekening->setBrandstof("diesel");
        $BpmBerekening->setDatumEersteIngebruikname("01-01-2009");
        $BpmBerekening->setCo2Uitstoot(91);

        $BpmBerekening->setConsumentenprijs(35000);
        $BpmBerekening->setNettoCatalogusprijs(21116);
        $BpmBerekening->setDatum(new DateTime("now"));
        $BpmBerekening->setInkoopwaarde(13300);

        $berekend = $BpmBerekening->berekenBPM();

        $this->assertEquals(0, $berekend['koerslijst']['netto_bpm']);

        // personenauto, diesel, 1-1-2009, 102 gr/km
        $BpmBerekening->setSoortAuto("personenauto");
        $BpmBerekening->setBrandstof("diesel");
        $BpmBerekening->setDatumEersteIngebruikname("01-01-2009");
        $BpmBerekening->setCo2Uitstoot(102);

        $BpmBerekening->setConsumentenprijs(35000);
        $BpmBerekening->setNettoCatalogusprijs(21116);
        $BpmBerekening->setDatum(new DateTime("now"));
        $BpmBerekening->setInkoopwaarde(13300);

        $berekend = $BpmBerekening->berekenBPM();

        $this->assertNotEquals(0, $berekend['koerslijst']['netto_bpm']);

        // personenauto, diesel, 1-1-2011, 91 gr/km
        $BpmBerekening->setSoortAuto("personenauto");
        $BpmBerekening->setBrandstof("diesel");
        $BpmBerekening->setDatumEersteIngebruikname("01-01-2011");
        $BpmBerekening->setCo2Uitstoot(91);

        $BpmBerekening->setConsumentenprijs(35000);
        $BpmBerekening->setNettoCatalogusprijs(21116);
        $BpmBerekening->setDatum(new DateTime("now"));
        $BpmBerekening->setInkoopwaarde(13300);

        $berekend = $BpmBerekening->berekenBPM();

        $this->assertEquals(0, $berekend['koerslijst']['netto_bpm']);

        // personenauto, diesel, 1-1-2011, 50 gr/km
        $BpmBerekening->setSoortAuto("personenauto");
        $BpmBerekening->setBrandstof("diesel");
        $BpmBerekening->setDatumEersteIngebruikname("01-01-2011");
        $BpmBerekening->setCo2Uitstoot(50);

        $BpmBerekening->setConsumentenprijs(35000);
        $BpmBerekening->setNettoCatalogusprijs(21116);
        $BpmBerekening->setDatum(new DateTime("now"));
        $BpmBerekening->setInkoopwaarde(13300);

        $berekend = $BpmBerekening->berekenBPM();

        $this->assertEquals(0, $berekend['koerslijst']['netto_bpm']);
    }
}
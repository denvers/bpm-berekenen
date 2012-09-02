<?php
error_reporting(E_ALL);
ini_set("display_errors", true);

require_once( dirname(__FILE__) . '/../models/BPMBerekening/BPMBerekening.php' );
require_once( dirname(__FILE__) . '/../models/BPMBerekening/Afschrijvingsmethode/ForfaitaireTabel.php' );
require_once( dirname(__FILE__) . '/../models/BPMBerekening/Motorrijtuig/BestelautoDiesel.php' );

use BPMBerekening\BPMBerekening;
use BPMBerekening\Afschrijvingsmethode\ForfaitaireTabel;
use BPMBerekening\Motorrijtuig\BestelautoDiesel;

/**
 * @info http://www.belastingdienst.nl/wps/wcm/connect/bldcontentnl/belastingdienst/prive/auto_en_vervoer/belastingen_op_auto_en_motor/belasting_van_personenautos_en_motorrijwielen_bpm/waarover_bpm_berekenen/afschrijving_op_basis_van_koerslijst_taxatierapport_of_forfaitaire_tabel/afschrijving_op_basis_van_forfaitaire_tabel
 * TODO
 */
class TestForfaitaireTabel extends PHPUnit_Framework_TestCase
{
    // @rules
    // Begint de periode op de laatste dag van een maand en eindigt deze op de laatste dag van een kortere maand? Dan is er toch sprake van een hele maand.
    // Voorbeeld:
    //
    // 31 januari tot en met 28 februari wordt gerekend als 1 maand
    // 31 januari tot en met 1 maart wordt gerekend als 2 maanden
    public function testBpmBerekeningZonderWaardes()
    {
        // TODO
    }

    /**
     * Voor een bestelauto geldt een afwijkende regeling. Het afschrijvingspercentage is na 5 jaar 100%.
     */
    public function testAfschrijvingspercentageBestelautoNa5jaar()
    {
        $motorrijtuig = new BestelautoDiesel();
        $motorrijtuig->setDatumIngebruikname( new DateTime("2005-01-01") );

        $forfaitairetabel = new ForfaitaireTabel();
        $forfaitairetabel->setMotorrijtuig($motorrijtuig);
        $this->assertEquals(100, $forfaitairetabel->berekenAfschrijvingspercentage( new DateTime("now") ));
    }

    /**
     * @requirement 47 Te betalen bpm over co2-uitstoot: 7309 EUR
     * @requirement 48 Te betalen bpm over catalogusprijs: 6004 EUR
     * @requirement 49 Bruto bpm op datum aangifte: 13.313 EUR
     * @requirement 50 Te betalen bpm (netto): 9.008 EUR
     */
    public function testBpmBerekening()
    {
        // Personenauto,
        // diesel,
        // datum eerste ingebruikname: 26-04-2011,
        // co2-uitstoot: 160 gr/km,
        // datum aangifte: 08-07-2012,
        // netto-catalogusprijs: 21116,
        // consumentenprijs: 35000
        // RESULTS ===>
        // Te betalen bpm over co2-uitstoot: 7309 EUR
        // Te betalen bpm over catalogusprijs: 6004 EUR
        // Bruto bpm op datum aangifte: 13.313 EUR
        // Te betalen bpm (netto): 9.008 EUR

        $BPM_berekening = new BPMBerekening();
        $BPM_berekening->setSoortAuto("personenauto");
        $BPM_berekening->setBrandstof("diesel");
        $BPM_berekening->setDatum(new DateTime("26-04-2011"));
        $BPM_berekening->setCo2Uitstoot(160);
        $BPM_berekening->setDatumEersteIngebruikname("08-04-2012");
        $BPM_berekening->setNettoCatalogusprijs(21116);
        $BPM_berekening->setConsumentenprijs(35000);

        $berekende_bpm = $BPM_berekening->berekenBPM();
        $this->assertTrue(is_array($berekende_bpm));
        $this->assertTrue(isset($berekende_bpm['forfaitaire_tabel']));

        $this->assertEquals(7309, $berekende_bpm['forfaitaire_tabel']['bpm_over_c02_uitstoot']);
        $this->assertEquals(6004, $berekende_bpm['forfaitaire_tabel']['bpm_over_catalogusprijs']);
        $this->assertEquals(13313, $berekende_bpm['forfaitaire_tabel']['bruto_bpm']);
        $this->assertEquals(9008, $berekende_bpm['forfaitaire_tabel']['netto_bpm']);
    }

    /**
     * @requirement 42: 31 januari tot en met 28 februari wordt gerekend als 1 maand
     * TODO 31 december tot en met 31 januari moet ook als 1 maand gerekend worden
     */
    public function testRequirement42()
    {
        $datetime_eerste_ingebruikname = new DateTime("31-01-2000");
        $datetime_eerste_tenaamstelling_nl = new DateTime("28-02-2000");

        $forfaitaire_tabel = new ForfaitaireTabel();

        $leeftijd_in_maanden = $forfaitaire_tabel->berekenLeeftijdInMaanden($datetime_eerste_ingebruikname, $datetime_eerste_tenaamstelling_nl);
        $this->assertEquals(1, $leeftijd_in_maanden);
    }

    /**
     * @requirement 43: 31 januari tot en met 1 maart wordt gerekend als 2 maanden
     * TODO 31 december tot en met 1 februari moet ook als 2 maanden gerekend worden
     */
    public function testRequirement43()
    {
        $datetime_eerste_ingebruikname = new DateTime("31-01-2000");
        $datetime_eerste_tenaamstelling_nl = new DateTime("01-03-2000");

        $forfaitaire_tabel = new ForfaitaireTabel();

        $leeftijd_in_maanden = $forfaitaire_tabel->berekenLeeftijdInMaanden($datetime_eerste_ingebruikname, $datetime_eerste_tenaamstelling_nl);
        $this->assertEquals(2, $leeftijd_in_maanden);
    }

    /**
     * @requirement 44: Voor een bestelauto is het afschrijvingspercentage na 5 jaar 100% (forfaitaire tabel)
     */
    public function testRequirement44()
    {
        $BPM_berekening = new BPMBerekening();
        $BPM_berekening->setSoortAuto("bestelauto");
        $BPM_berekening->setBrandstof("diesel");
        $BPM_berekening->setDatum(new DateTime("01-01-2005"));
        $BPM_berekening->setDatumEersteIngebruikname("01-01-2010");

        $berekende_bpm = $BPM_berekening->berekenBpmVolgensForfaitairetabel();

        $this->assertTrue(is_array($berekende_bpm));
        $this->assertEquals(100, $berekende_bpm['afschrijvingspercentage']);
        $this->assertNotEquals(0, $berekende_bpm['afschrijvingspercentage']);
    }

    /**
     * @requirement 45: Bij een datum eerste toelating van 26 april 2011 en een eerste tenaamstelling in NL van 8 april 2012 geldt een afschrijvingspercentage van 28%. Voor de overige 2 volle maanden en de 3e gedeeltelijke maand is de afschrijving 3 x 1,444%. Dus: 28% + (3 x 1,444%) = 32,332%.
     */
    public function testRequirement45()
    {
        // Bij een datum eerste toelating van 26 april 2011 en een eerste tenaamstelling in NL van 8 april 2012
        // geldt een afschrijvingspercentage van 28%.
        // Voor de overige 2 volle maanden en de 3e gedeeltelijke maand is de afschrijving 3 x 1,444%.
        // Dus: 28% + (3 x 1,444%) = 32,332%.

        $BPM_berekening = new BPMBerekening();
        $BPM_berekening->setSoortAuto("personenauto");
        $BPM_berekening->setBrandstof("benzine");
        $BPM_berekening->setDatum(new DateTime("08-04-2012"));
        $BPM_berekening->setDatumEersteIngebruikname("26-04-2011");

        $berekende_bpm = $BPM_berekening->berekenBpmVolgensForfaitairetabel();

        $this->assertTrue(is_array($berekende_bpm));
        $this->assertEquals(32.332, $berekende_bpm['afschrijvingspercentage']);
    }
}
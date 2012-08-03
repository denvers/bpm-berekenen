<?php
require_once(dirname(__FILE__) . "/../models/forfaitaire_tabel.php");

/**
 * @info http://www.belastingdienst.nl/wps/wcm/connect/bldcontentnl/belastingdienst/prive/auto_en_vervoer/belastingen_op_auto_en_motor/belasting_van_personenautos_en_motorrijwielen_bpm/waarover_bpm_berekenen/afschrijving_op_basis_van_koerslijst_taxatierapport_of_forfaitaire_tabel/afschrijving_op_basis_van_forfaitaire_tabel
 * FIXME TODO
 */
class TestForfaitaireTabel extends PHPUnit_Framework_TestCase
{
    // @rules
    // 1. Voor een bestelauto geldt een afwijkende regeling. Het afschrijvingspercentage is na 5 jaar 100%.
    // 2. Begint de periode op de laatste dag van een maand en eindigt deze op de laatste dag van een kortere maand? Dan is er toch sprake van een hele maand.
    // Voorbeeld:
    //
    // 31 januari tot en met 28 februari wordt gerekend als 1 maand
    // 31 januari tot en met 1 maart wordt gerekend als 2 maanden
    public function testBpmBerekeningZonderWaardes()
    {

    }

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

        $BPM_berekening = new \BPMBerekening\models\BPM_Berekening();
        $BPM_berekening->setSoortAuto("personenauto");
        $BPM_berekening->setBrandstof("diesel");
        $BPM_berekening->setDatum(new DateTime("26-04-2011"));
        $BPM_berekening->setCo2Uitstoot(160);
        $BPM_berekening->setDatumEersteIngebruikname("08-07-2012");
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
}
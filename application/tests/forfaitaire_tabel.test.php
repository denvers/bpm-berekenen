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
        $personenauto = new \BPMBerekening\models\motorrijtuig\Personenauto_Diesel();
        $personenauto->setDatumEersteToelating(new DateTime("26-04-2011"));
        $personenauto->setDatumIngebruikname(new DateTime("08-04-2012"));
    }
}
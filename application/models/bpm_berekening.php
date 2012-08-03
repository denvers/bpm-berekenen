<?php
namespace BPMBerekening\models;

require_once( dirname(__FILE__) . "/../models/forfaitaire_tabel.php" );
require_once( dirname(__FILE__) . "/../models/koerslijst.php" );

require_once( dirname(__FILE__) . "/../models/personenauto_diesel.php" );
require_once( dirname(__FILE__) . "/../models/personenauto_geen_diesel.php" );

require_once( dirname(__FILE__) . "/../models/bestelauto_diesel.php" );
require_once( dirname(__FILE__) . "/../models/bestelauto_geen_diesel.php" );

require_once( dirname(__FILE__) . "/../models/kampeerauto_diesel.php" );
require_once( dirname(__FILE__) . "/../models/kampeerauto_geen_diesel.php" );

require_once( dirname(__FILE__) . "/../models/motorfiets.php" );

/**
 * User: dsessink
 * Date: 25-07-12
 * Time: 14:11
 */
class BPM_Berekening
{
    private $debug = false;

    /**
     * @var DateTime
     */
    private $datum;

    /**
     * @var int
     */
    private $bpm_toeslag_co2_uitstoot;

    /**
     * @var int
     */
    private $korting;

    /**
     * @var string
     */
    private $soort_auto;

    /**
     * @var string
     */
    private $brandstof;

    /**
     * @var string
     */
    private $datum_eerste_ingebruikname;

    /**
     * @var int
     */
    private $co2_uitstoot;

    /**
     * @var int
     */
    private $netto_catalogusprijs;

    /**
     * @var int
     */
    private $consumentenprijs;

    /**
     * @var int
     */
    private $inkoopwaarde;

    /**
     * @param string $brandstof
     */
    public function setBrandstof($brandstof)
    {
        $this->brandstof = $brandstof;
    }

    /**
     * @param int $co2_uitstoot
     */
    public function setCo2Uitstoot($co2_uitstoot)
    {
        $this->co2_uitstoot = $co2_uitstoot;
    }

    /**
     * @param int $consumentenprijs
     */
    public function setConsumentenprijs($consumentenprijs)
    {
        $this->consumentenprijs = $consumentenprijs;
    }

    /**
     * @param \BPMBerekening\models\DateTime $datum
     */
    public function setDatum($datum)
    {
        $this->datum = $datum;
    }

    /**
     * @param string $datum_eerste_ingebruikname
     */
    public function setDatumEersteIngebruikname($datum_eerste_ingebruikname)
    {
        $this->datum_eerste_ingebruikname = $datum_eerste_ingebruikname;
    }

    /**
     * @param int $inkoopwaarde
     */
    public function setInkoopwaarde($inkoopwaarde)
    {
        $this->inkoopwaarde = $inkoopwaarde;
    }

    /**
     * @param int $netto_catalogusprijs
     */
    public function setNettoCatalogusprijs($netto_catalogusprijs)
    {
        $this->netto_catalogusprijs = $netto_catalogusprijs;
    }

    /**
     * @param string $soort_auto
     */
    public function setSoortAuto($soort_auto)
    {
        switch($soort_auto)
        {
            case "personenauto":
                $this->soort_auto = $soort_auto;
                break;

            case "kampeerauto":
                $this->soort_auto = $soort_auto;
                break;

            case "bestelauto":
                $this->soort_auto = $soort_auto;
                break;

            case "motorfiets":
                $this->soort_auto = $soort_auto;
                break;

            default:
                    throw new \Exception("Onbekend soort auto gedetecteerd.");
                break;
        }
    }

    /**
     * @return string
     */
    private function getSoortAuto()
    {
        return $this->soort_auto;
    }

    /**
     * @return string
     */
    private function getBrandstof()
    {
        return $this->brandstof;
    }

    /**
     * @return motorrijtuig\Personenauto_Diesel|motorrijtuig\Motorrijtuig
     * @throws \Exception
     */
    public function getMotorrijtuig()
    {
        switch($this->getSoortAuto())
        {
            case "personenauto":
                if ( $this->brandstof == "diesel" )
                {
                    $motorrijtuig = new \BPMBerekening\models\motorrijtuig\Personenauto_Diesel();
                }
                else
                {
                    $motorrijtuig = new \BPMBerekening\models\motorrijtuig\Personenauto_Geen_Diesel();
                }
                break;

            case "kampeerauto":
                if ( $this->brandstof == "diesel" )
                {
                    $motorrijtuig = new \BPMBerekening\models\motorrijtuig\Kampeerauto_Diesel();
                }
                else
                {
                    $motorrijtuig = new \BPMBerekening\models\motorrijtuig\Kampeerauto_Geen_Diesel();
                }
                break;

            case "bestelauto":
                if ( $this->brandstof == "diesel" )
                {
                    $motorrijtuig = new \BPMBerekening\models\motorrijtuig\Bestelauto_Diesel();
                }
                else
                {
                    $motorrijtuig = new \BPMBerekening\models\motorrijtuig\Bestelauto_Geen_Diesel();
                }
                break;

            case "motorfiets":
                $motorrijtuig = new \BPMBerekening\models\motorrijtuig\Motorfiets();
                break;

            default:
                throw new \Exception("Onbekend soort auto: ".$this->getSoortAuto());
                break;
        }

        $motorrijtuig->setBrandstofsoort($this->brandstof);
        $motorrijtuig->setCo2Uitstoot($this->co2_uitstoot);
        $motorrijtuig->setConsumentenprijs($this->consumentenprijs);
        $motorrijtuig->setDatumIngebruikname( new \DateTime($this->datum_eerste_ingebruikname) );
        $motorrijtuig->setNettoCatalogusprijs($this->netto_catalogusprijs);
        $motorrijtuig->setSoort($this->soort_auto);
        $motorrijtuig->setInkoopwaarde($this->inkoopwaarde);

        return $motorrijtuig;
    }

    /**
     * Dekt requirement 1-6
     * @param \BPMBerekening\models\motorrijtuig\Motorrijtuig $motorrijtuig
     * @return bool
     */
    private function geenBpmVoorMotorrijtuigOpBasisVanCO2Uitstoot($motorrijtuig)
    {
        // Requirement 1:
        // U betaalt geen bpm voor personenauto’s met een CO2-uitstoot van 0 gram per kilometer.

        // Requirement 2:
        // U betaalt geen bpm voor bestelauto’s met een CO2-uitstoot van 0 gram per kilometer.

        // Requirement 3:
        // U betaalt geen bpm voor kampeerauto’s met een CO2-uitstoot van 0 gram per kilometer.

        // Requirement 4:
        // U betaalt geen bpm voor motoren met een CO2-uitstoot van 0 gram per kilometer.

        $classname = get_class($motorrijtuig);

        if (
            $motorrijtuig->getCo2Uitstoot() == 0 &&
            (
                $classname == 'BPMBerekening\models\motorrijtuig\Personenauto_Diesel' ||
                $classname == 'BPMBerekening\models\motorrijtuig\Personenauto_Geen_Diesel' ||
                $classname == 'BPMBerekening\models\motorrijtuig\Bestelauto_Diesel' ||
                $classname == 'BPMBerekening\models\motorrijtuig\Bestelauto_Geen_Diesel' ||
                $classname == 'BPMBerekening\models\motorrijtuig\Kampeerauto_Diesel' ||
                $classname == 'BPMBerekening\models\motorrijtuig\Kampeerauto_Geen_Diesel' ||
                $classname == 'BPMBerekening\models\motorrijtuig\Motorfiets'
                )
            )
        {
            return true;
        }

        // Requirement 5:
        // U betaalt ook geen bpm voor personenauto’s die op of na 1 januari 2009 voor het eerst in gebruik zijn genomen en uitgerust zijn met een benzinemotor met een CO2-uitstoot van maximaal 102 gram per kilometer
        if ( $classname == 'BPMBerekening\models\motorrijtuig\Personenauto_Geen_Diesel' )
        {
            if ( $motorrijtuig->getCo2Uitstoot() <= 102 )
            {
                /**
                 * @var DateTime
                 */
                $datum_eerste_ingebruikname = $motorrijtuig->getDatumEersteIngebruikname();

                if ( $datum_eerste_ingebruikname->format("Ymd") >= 20090101 )
                {
                    return true;
                }
            }
        }

        // Requirement 6:
        // U betaalt ook geen bpm voor personenauto’s die op of na 1 januari 2009 voor het eerst in gebruik zijn genomen en uitgerust zijn met een dieselmotor met een CO2-uitstoot van maximaal 91 gram per kilometer
        if ( $classname == 'BPMBerekening\models\motorrijtuig\Personenauto_Diesel' )
        {
            if ( $motorrijtuig->getCo2Uitstoot() <= 91 )
            {
                /**
                 * @var DateTime
                 */
                $datum_eerste_ingebruikname = $motorrijtuig->getDatumEersteIngebruikname();

                if ( $datum_eerste_ingebruikname->format("Ymd") >= 20090101 )
                {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Bereken de te betalen BPM voor het voertuig
     */
    public function berekenBPM()
    {
        $motorrijtuig = $this->getMotorrijtuig();
        $bpmberekening = array();

        if ( true === $this->geenBpmVoorMotorrijtuigOpBasisVanCO2Uitstoot($motorrijtuig) )
        {
            $bpmberekening['koerslijst'] = array(
                'afschrijvingspercentage' => "n.v.t.",
                'bpm_over_c02_uitstoot' => 0,
                'bpm_over_catalogusprijs' => 0,
                'bruto_bpm' => 0,
                'netto_bpm' => 0,
            );

            $bpmberekening['forfaitaire_tabel'] = array(
                'afschrijvingspercentage' => "n.v.t.",
                'bpm_over_c02_uitstoot' => 0,
                'bpm_over_catalogusprijs' => 0,
                'bruto_bpm' => 0,
                'netto_bpm' => 0,
            );

            return $bpmberekening;
        }

        // Algemene BPM berekeningen
        $bpm_over_c02 = $this->berekenBpmOverCO2Uitstoot($this->brandstof, $this->co2_uitstoot);
        $bpm_over_catalogusprijs = $this->berekenBpmOverCatalogusprijs($this->brandstof, $this->netto_catalogusprijs, $this->co2_uitstoot);
        $bruto_bpm = $this->berekenBrutoBpm($bpm_over_c02, $bpm_over_catalogusprijs);

        // Forfaitaire_tabel
        $Forfaitaire_Tabel = new \BPMBerekening\afschrijvingsmethode\Forfaitaire_Tabel();
        $Forfaitaire_Tabel->setMotorrijtuig($motorrijtuig);
        $afschrijvingspercentage = $Forfaitaire_Tabel->berekenAfschrijvingspercentage($this->datum);

        $netto_bpm = $this->berekenNettoBpmBedrag($afschrijvingspercentage, $bruto_bpm);

        $bpmberekening['forfaitaire_tabel'] = array(
            'afschrijvingspercentage' => $afschrijvingspercentage,
            'bpm_over_c02_uitstoot' => $bpm_over_c02,
            'bpm_over_catalogusprijs' => $bpm_over_catalogusprijs,
            'bruto_bpm' => $bruto_bpm,
            'netto_bpm' => $netto_bpm,
        );

        // Koerslijst
        $Koerslijst = new \BPMBerekening\afschrijvingsmethode\Koerslijst();
        $Koerslijst->setMotorrijtuig($motorrijtuig);
        $afschrijvingspercentage = $Koerslijst->berekenAfschrijvingspercentage($this->datum);

        $netto_bpm = $this->berekenNettoBpmBedrag($afschrijvingspercentage, $bruto_bpm);

        $bpmberekening['koerslijst'] = array(
            'afschrijvingspercentage' => $afschrijvingspercentage,
            'bpm_over_c02_uitstoot' => $bpm_over_c02,
            'bpm_over_catalogusprijs' => $bpm_over_catalogusprijs,
            'bruto_bpm' => $bruto_bpm,
            'netto_bpm' => $netto_bpm,
        );

        // Taxatierapport
        // TODO
//        $bpmberekening['taxatierapport'] = array(
//            'afschrijvingspercentage' => $afschrijvingspercentage,
//            'bpm_over_c02_uitstoot' => $bpm_over_c02,
//            'bpm_over_catalogusprijs' => $bpm_over_catalogusprijs,
//            'bruto_bpm' => $bruto_bpm,
//            'netto_bpm' => $netto_bpm,
//        );

        return $bpmberekening;
    }

    /**
     * @param $bpm_co2_uitstoot
     * @param $bpm_catalogusprijs
     * @return mixed
     * @test done
     */
    public function berekenBrutoBpm($bpm_co2_uitstoot, $bpm_catalogusprijs)
    {
        return $bpm_catalogusprijs + $bpm_co2_uitstoot;
    }

    /**
     * @param $brandstof
     * @param $co2_uitstoot
     * @return mixed
     * @throws \Exception
     * @test done
     */
    public function berekenBpmOverCO2Uitstoot($brandstof, $co2_uitstoot)
    {
        if (strtolower($brandstof) == "diesel") {
            return $this->berekenBpmOverCO2UitstootDiesel($co2_uitstoot);
        } elseif (strtolower($brandstof) == "benzine") {
            return $this->berekenBpmOverCO2UitstootBenzine($co2_uitstoot);
        } elseif (strtolower($brandstof) == "aardgas") {
            return $this->berekenBpmOverCO2UitstootBenzine($co2_uitstoot);
        } elseif (strtolower($brandstof) == "lpg") {
            return $this->berekenBpmOverCO2UitstootBenzine($co2_uitstoot);
        }
        else {
            $ex = new \Exception("#1: Brandstof: ".$brandstof." is onbekend.");
            \Laravel\Log::exception($ex);
            throw $ex;
        }
    }

    /**
     * @param $co2_uitstoot
     * @return mixed
     * @test done
     */
    private function berekenBpmOverCO2UitstootDiesel($co2_uitstoot)
    {
        /*
        Neem de CO2-uitstoot van de auto (in gram per kilometer). In dit voorbeeld 200 gram per kilometer.
        In de tabel valt deze waarde tussen de 143 en de 211 gram per kilometer
        Trek van de uitstoot van uw auto 143 gram per kilometer af. In dit voorbeeld is dit dus 200 - 143 = 57.
        Vermenigvuldig de uitkomst met het bedrag dat in kolom IV staat van dezelfde rij. In dit voorbeeld is dit 57 x € 121 = € 6.897
        Tel bij de uitkomst het bedrag dat in kolom III staat van dezelfde rij. In dit voorbeeld dus € 6.897 + €  5.252 = € 12.149
        bron: http://www.belastingdienst.nl/wps/wcm/connect/bldcontentnl/belastingdienst/prive/auto_en_vervoer/belastingen_op_auto_en_motor/belasting_van_personenautos_en_motorrijwielen_bpm/bereken_de_bpm/bereken_de_bpm_voor_een_personenauto
        */
        $rekenwaarden = array(
            array('I' => 0, 'II' => 91, 'III' => 0, 'IV' => 0),
            array('I' => 91, 'II' => 143, 'III' => 0, 'IV' => 101),
            array('I' => 143, 'II' => 211, 'III' => 5252, 'IV' => 121),
            array('I' => 211, 'II' => 225, 'III' => 13480, 'IV' => 559),
            array('I' => 255, 'II' => 1000000000, 'III' => 16602, 'IV' => 559),
        );

        // toe te passen rekenwaarde vinden
        $toegepaste_rekenwaarde = null;
        foreach ($rekenwaarden as $key => $rekenwaarde) {
            if ($co2_uitstoot > $rekenwaarde['I'] && $co2_uitstoot < $rekenwaarde['II']) {
                $toegepaste_rekenwaarde = $rekenwaarde;
            }
        }

        $bpm = (($co2_uitstoot - $toegepaste_rekenwaarde['I']) * $toegepaste_rekenwaarde['IV']) + $toegepaste_rekenwaarde['III'];

        $this->output("Te betalen bpm over CO2 uitstoot (diesel): ((" . $co2_uitstoot . " - " . $toegepaste_rekenwaarde['I'] . ") x EUR " . $toegepaste_rekenwaarde['IV'] . ") + EUR " . $toegepaste_rekenwaarde['III'] . " = EUR " . $bpm . "<br>");

        return $bpm;
    }

    /**
     * @param $co2_uitstoot
     * @return mixed
     * @test done
     */
    private function berekenBpmOverCO2UitstootBenzine($co2_uitstoot)
    {
        /*
        Neem de CO2-uitstoot van de auto in gram per kilometer. In dit voorbeeld 200 gram per kilometer.
        In de tabel valt deze waarde tussen de 159 en de 237 gram per kilometer.
        Trek van de uitstoot van uw auto 159 gram per kilometer af. In dit voorbeeld: 200 - 159 = 41
        Vermenigvuldig de uitkomst met het bedrag dat in kolom IV staat van dezelfde rij In dit voorbeeld: 41 x € 121 = € 4.961. Tel bij de uitkomst het bedrag dat in kolom III staat van dezelfde rij. In dit voorbeeld: € 4.961 + € 5.757 = € 10.718
        bron: http://www.belastingdienst.nl/wps/wcm/connect/bldcontentnl/belastingdienst/prive/auto_en_vervoer/belastingen_op_auto_en_motor/belasting_van_personenautos_en_motorrijwielen_bpm/bereken_de_bpm/bereken_de_bpm_voor_een_personenauto
        */
        $rekenwaarden = array(
            array('I' => 0, 'II' => 102, 'III' => 0, 'IV' => 0),
            array('I' => 102, 'II' => 159, 'III' => 0, 'IV' => 101),
            array('I' => 159, 'II' => 237, 'III' => 5757, 'IV' => 121),
            array('I' => 237, 'II' => 242, 'III' => 15195, 'IV' => 223),
            array('I' => 242, 'II' => 1000000000, 'III' => 16310, 'IV' => 559),
        );

        // toe te passen rekenwaarde vinden
        $toegepaste_rekenwaarde = null;
        foreach ($rekenwaarden as $key => $rekenwaarde) {
            if ($co2_uitstoot >= $rekenwaarde['I'] && $co2_uitstoot <= $rekenwaarde['II']) {
                $toegepaste_rekenwaarde = $rekenwaarde;
            }
        }

        $bpm = (($co2_uitstoot - $toegepaste_rekenwaarde['I']) * $toegepaste_rekenwaarde['IV']) + $toegepaste_rekenwaarde['III'];

        $this->output("Te betalen bpm over CO2 uitstoot (benzine): ((" . $co2_uitstoot . " - " . $toegepaste_rekenwaarde['I'] . ") x EUR " . $toegepaste_rekenwaarde['IV'] . ") + EUR " . $toegepaste_rekenwaarde['III'] . " = EUR " . $bpm . "<br>");

        return $bpm;
    }

    /**
     * @param $brandstof
     * @param $netto_catalogusprijs
     * @param $co2_uitstoot
     * @return float
     * @test done
     */
    public function berekenBpmOverCatalogusprijs($brandstof, $netto_catalogusprijs, $co2_uitstoot)
    {
        if (strtolower($brandstof) == "diesel") {
            return $this->berekenBpmOverCatalogusprijsDiesel($netto_catalogusprijs, $co2_uitstoot);
        }
        else {
            return $this->berekenBpmOverCatalogusprijsGeenDiesel($netto_catalogusprijs);
        }
    }

    /**
     * @param $netto_catalogusprijs
     * @param $co2_uitstoot
     * @return float
     * @test done
     */
    private function berekenBpmOverCatalogusprijsDiesel($netto_catalogusprijs, $co2_uitstoot)
    {
        /*
         http://www.belastingdienst.nl/wps/wcm/connect/bldcontentnl/belastingdienst/prive/auto_en_vervoer/belastingen_op_auto_en_motor/belasting_van_personenautos_en_motorrijwielen_bpm/waarover_bpm_berekenen/bpm_tarief_catalogusprijs_personenautos
        */

        $bpm_tarief = 11.1;
        $dieseltoeslag = 40.68;
        $vermeerderingsbedrag_drempel = 70;

        $bpm = ($netto_catalogusprijs * $bpm_tarief / 100);

        $this->output("Bpm over catalogusprijs (diesel): (" . $netto_catalogusprijs . " x " . $bpm_tarief . "/100)");

        if ($co2_uitstoot > $vermeerderingsbedrag_drempel) {
            $bpm += round(round($co2_uitstoot - $vermeerderingsbedrag_drempel) * $dieseltoeslag);

            $this->output(" + ((" . $co2_uitstoot . "-" . $vermeerderingsbedrag_drempel . ") x EUR " . $dieseltoeslag . ")");
        }

        $this->output(" = EUR " . floor($bpm) . "<br>");

        return floor($bpm);
    }

    /**
     * @param $netto_catalogusprijs
     * @return float
     * @test done
     */
    private function berekenBpmOverCatalogusprijsGeenDiesel($netto_catalogusprijs)
    {
        /*
         http://www.belastingdienst.nl/wps/wcm/connect/bldcontentnl/belastingdienst/prive/auto_en_vervoer/belastingen_op_auto_en_motor/belasting_van_personenautos_en_motorrijwielen_bpm/waarover_bpm_berekenen/bpm_tarief_catalogusprijs_personenautos
        */

        $bpm_tarief = 11.1;
        $brandstofkorting = 450;

        $bpm = floor( ($netto_catalogusprijs * $bpm_tarief / 100) - $brandstofkorting );

        $this->output("Bpm over catalogusprijs (geen diesel): (" . $netto_catalogusprijs . " x " . $bpm_tarief . "/100) - EUR ".$brandstofkorting." = EUR ".$bpm."<br>");

        return $bpm;
    }

    private function berekenNettoBpmBedrag($afschrijvingspercentage, $bruto_bpm)
    {
        $bpm = floor(((100 - $afschrijvingspercentage) / 100) * $bruto_bpm);

        $this->output("Te betalen bpm: ((100 - " . $afschrijvingspercentage . "%) / 100) x " . $bruto_bpm . " = EUR " . $bpm . "<br>");

        return $bpm;
    }

    private function output($msg)
    {
        \Laravel\Log::info($msg);
    }
}

<?php
namespace BPMBerekening;

use DateTime;
use BPMBerekening\BpmBerekeningHistorisch;
use BPMBerekening\Afschrijvingsmethode\ForfaitaireTabel;
use BPMBerekening\Afschrijvingsmethode\Koerslijst;
use BPMBerekening\Motorrijtuig\PersonenautoDiesel;
use BPMBerekening\Motorrijtuig\PersonenautoGeenDiesel;
use BPMBerekening\Motorrijtuig\KampeerautoGeenDiesel;
use BPMBerekening\Motorrijtuig\KampeerautoDiesel;
use BPMBerekening\Motorrijtuig\BestelautoDiesel;
use BPMBerekening\Motorrijtuig\BestelautoGeenDiesel;
use BPMBerekening\Motorrijtuig\Motorfiets;

/**
 * User: dsessink
 * Date: 25-07-12
 * Time: 14:11
 */
class BPMBerekening
{
    /**
     * @var bool
     */
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
     * @var boolean;
     */
    private $euro6_norm;

    /**
     * @param string $brandstof
     */
    public function setBrandstof($brandstof)
    {
        $this->brandstof = $brandstof;
    }

    /**
     * @return string
     */
    private function getBrandstof()
    {
        return $this->brandstof;
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
     * @param DateTime $datum
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
     * @param boolean $euro6_norm
     */
    public function setEuro6Norm($euro6_norm)
    {
        $this->euro6_norm = $euro6_norm;
    }

    /**
     * @param string $soort_auto
     */
    public function setSoortAuto($soort_auto)
    {
        switch ($soort_auto) {
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

        return true;
    }

    /**
     * @return string
     */
    private function getSoortAuto()
    {
        return $this->soort_auto;
    }

    /**
     * @return \BPMBerekening\Motorrijtuig\PersonenautoDiesel
     * @throws \Exception
     */
    public function getMotorrijtuig()
    {
        switch ($this->getSoortAuto()) {
            case "personenauto":
                if ($this->brandstof == "diesel") {
                    $motorrijtuig = new PersonenautoDiesel();
                    $motorrijtuig->setEuro6Norm($this->euro6_norm);
                } else {
                    $motorrijtuig = new PersonenautoGeenDiesel();
                }
                break;

            case "kampeerauto":
                if ($this->brandstof == "diesel") {
                    $motorrijtuig = new KampeerautoDiesel();
                } else {
                    $motorrijtuig = new KampeerautoGeenDiesel();
                }
                break;

            case "bestelauto":
                if ($this->brandstof == "diesel") {
                    $motorrijtuig = new BestelautoDiesel();
                } else {
                    $motorrijtuig = new BestelautoGeenDiesel();
                }
                break;

            case "motorfiets":
                $motorrijtuig = new Motorfiets();
                break;

            default:
                throw new \Exception("Onbekend soort auto: " . $this->getSoortAuto());
                break;
        }

        $motorrijtuig->setBrandstofsoort($this->brandstof);
        $motorrijtuig->setCo2Uitstoot($this->co2_uitstoot);
        $motorrijtuig->setConsumentenprijs($this->consumentenprijs);
        $motorrijtuig->setDatumIngebruikname(new DateTime($this->datum_eerste_ingebruikname));
        $motorrijtuig->setNettoCatalogusprijs($this->netto_catalogusprijs);
        $motorrijtuig->setInkoopwaarde($this->inkoopwaarde);

        return $motorrijtuig;
    }

    /**
     * Dekt requirement 1-6
     *
     * @param \BPMBerekening\Motorrijtuig\Motorrijtuig $motorrijtuig
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
                $classname == 'BPMBerekening\Motorrijtuig\PersonenautoDiesel' ||
                $classname == 'BPMBerekening\Motorrijtuig\PersonenautoGeenDiesel' ||
                $classname == 'BPMBerekening\Motorrijtuig\BestelautoDiesel' ||
                $classname == 'BPMBerekening\Motorrijtuig\BestelautoGeenDiesel' ||
                $classname == 'BPMBerekening\Motorrijtuig\KampeerautoDiesel' ||
                $classname == 'BPMBerekening\Motorrijtuig\KampeerautoGeenDiesel' ||
                $classname == 'BPMBerekening\Motorrijtuig\Motorfiets'
            )
        ) {
            return true;
        }

        // Requirement 5:
        // U betaalt ook geen bpm voor personenauto’s die op of na 1 januari 2009 voor het eerst in gebruik zijn genomen en uitgerust zijn met een benzinemotor met een CO2-uitstoot van maximaal 102 gram per kilometer
        if ($classname == 'BPMBerekening\Motorrijtuig\PersonenautoGeenDiesel') {
            if ($motorrijtuig->getCo2Uitstoot() <= 102) {
                /**
                 * @var DateTime
                 */
                $datum_eerste_ingebruikname = $motorrijtuig->getDatumEersteIngebruikname();

                if ($datum_eerste_ingebruikname->format("Ymd") >= 20090101) {
                    return true;
                }
            }
        }

        // Requirement 6:
        // U betaalt ook geen bpm voor personenauto’s die op of na 1 januari 2009 voor het eerst in gebruik zijn genomen en uitgerust zijn met een dieselmotor met een CO2-uitstoot van maximaal 91 gram per kilometer
        if ($classname == 'BPMBerekening\Motorrijtuig\PersonenautoDiesel') {
            if ($motorrijtuig->getCo2Uitstoot() <= 91) {
                /**
                 * @var DateTime
                 */
                $datum_eerste_ingebruikname = $motorrijtuig->getDatumEersteIngebruikname();

                if ($datum_eerste_ingebruikname->format("Ymd") >= 20090101) {
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

        if (true === $this->geenBpmVoorMotorrijtuigOpBasisVanCO2Uitstoot($motorrijtuig)) {
            $bpmberekening['koerslijst'] = array(
                'afschrijvingspercentage' => "n.v.t.",
                'bpm_over_c02_uitstoot' => 0,
                'bpm_over_catalogusprijs' => 0,
                'euro6_norm_korting' => 0,
                'bruto_bpm' => 0,
                'netto_bpm' => 0,
            );

            $bpmberekening['forfaitaire_tabel'] = array(
                'afschrijvingspercentage' => "n.v.t.",
                'bpm_over_c02_uitstoot' => 0,
                'bpm_over_catalogusprijs' => 0,
                'euro6_norm_korting' => 0,
                'bruto_bpm' => 0,
                'netto_bpm' => 0,
            );

            $bpmberekening['historisch_bruto_bpm_bedrag'] = array(
                'afschrijvingspercentage' => "n.v.t.",
                'bpm_over_c02_uitstoot' => 0,
                'bpm_over_catalogusprijs' => 0,
                'euro6_norm_korting' => 0,
                'bruto_bpm' => 0,
                'netto_bpm' => 0,
            );

            return $bpmberekening;
        }

        // Koerslijst
        $bpmberekening['koerslijst'] = $this->berekenBpmVolgensKoerslijst($motorrijtuig);

        // Forfaitaire_tabel
        $bpmberekening['forfaitaire_tabel'] = $this->berekenBpmVolgensForfaitaireTabel();

        // Op basis van historisch bruto bpm bedrag
        // TODO alleen voor auto's > 1 jan 1993
        $bpmberekening['historisch_bruto_bpm_bedrag'] = $this->berekenBpmVolgensHistorischBrutoBpmBedrag();

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
     * Volledige BPM berekening volgens koerslijst
     *
     * @param \BPMBerekening\Motorrijtuig\Motorrijtuig $motorrijtuig
     */
    private function berekenBpmVolgensKoerslijst($motorrijtuig)
    {
        // Requirement 7:
        $bpm_over_c02 = $this->berekenBpmOverCO2Uitstoot($this->brandstof, $this->co2_uitstoot);

        // Requirement 8: 2/2 van de hoogte van het te betalen bpm-bedrag voor personenauto's wordt bepaald door de catalogusprijs van de personenauto (BPM)
        // Requirement 9: De hoogte van het te betalen bpm-bedrag voor motoren wordt uitsluitend bepaald door de CO2-uitstoot van de motor in gram per kilometer
        // Requirement 10: De hoogte van het te betalen bpm-bedrag voor bestelauto's wordt uitsluitend bepaald door de CO2-uitstoot van de motor in gram per kilometer
        $bpm_over_catalogusprijs = $this->berekenBpmOverCatalogusprijs($this->brandstof, $this->netto_catalogusprijs, $this->co2_uitstoot);

        $bruto_bpm = $this->berekenBrutoBpm($bpm_over_c02, $bpm_over_catalogusprijs);

        $Koerslijst = new \BPMBerekening\afschrijvingsmethode\Koerslijst();
        $Koerslijst->setMotorrijtuig($motorrijtuig);
        $afschrijvingspercentage = $Koerslijst->berekenAfschrijvingspercentage($this->datum);

        $netto_bpm = $this->berekenNettoBpmBedrag($afschrijvingspercentage, $bruto_bpm);

        return array(
            'afschrijvingspercentage' => $afschrijvingspercentage,
            'bpm_over_c02_uitstoot' => $bpm_over_c02,
            'bpm_over_catalogusprijs' => $bpm_over_catalogusprijs,
            'euro6_norm_korting' => ($this->getBrandstof() == "diesel" && $this->getSoortAuto() == "personenauto" && $this->euro6_norm === true) ? 1000 : 0,
            'bruto_bpm' => $bruto_bpm,
            'netto_bpm' => $netto_bpm,
        );
    }

    /**
     * Volledige BPM berekening volgens forfaitaire tabel
     *
     * @return array
     */
    public function berekenBpmVolgensForfaitairetabel()
    {
        $motorrijtuig = $this->getMotorrijtuig();
        $bpm_over_c02 = $this->berekenBpmOverCO2Uitstoot($this->brandstof, $this->co2_uitstoot);
        $bpm_over_catalogusprijs = $this->berekenBpmOverCatalogusprijs($this->brandstof, $this->netto_catalogusprijs, $this->co2_uitstoot);

        $bruto_bpm = $this->berekenBrutoBpm($bpm_over_c02, $bpm_over_catalogusprijs);

        $Forfaitaire_Tabel = new \BPMBerekening\afschrijvingsmethode\ForfaitaireTabel();
        $Forfaitaire_Tabel->setMotorrijtuig($motorrijtuig);
        $afschrijvingspercentage = $Forfaitaire_Tabel->berekenAfschrijvingspercentage($this->datum);

        $netto_bpm = $this->berekenNettoBpmBedrag($afschrijvingspercentage, $bruto_bpm);

        return array(
            'afschrijvingspercentage' => $afschrijvingspercentage,
            'bpm_over_c02_uitstoot' => $bpm_over_c02,
            'bpm_over_catalogusprijs' => $bpm_over_catalogusprijs,
            'euro6_norm_korting' => null,
            'bruto_bpm' => $bruto_bpm,
            'netto_bpm' => $netto_bpm,
        );
    }

    /**
     * Volledige BPM berekening volgens historisch bruto bpm bedrag
     *
     * @return array
     */
    public function berekenBpmVolgensHistorischBrutoBpmBedrag()
    {
        $motorrijtuig = $this->getMotorrijtuig();

        $bpm_over_c02 = $this->berekenBpmOverCO2Uitstoot($this->brandstof, $this->co2_uitstoot);

        $BpmBerekeningHistorisch = new BpmBerekeningHistorisch();
        $bpm_over_catalogusprijs = $BpmBerekeningHistorisch->berekenBpmOverCatalogusprijs($motorrijtuig);

        $bruto_bpm = $this->berekenBrutoBpm($bpm_over_c02, $bpm_over_catalogusprijs);

        $Koerslijst = new Koerslijst();
        $Koerslijst->setMotorrijtuig($motorrijtuig);
        $afschrijvingspercentage = $Koerslijst->berekenAfschrijvingspercentage($this->datum);

        $netto_bpm = $this->berekenNettoBpmBedrag($afschrijvingspercentage, $bruto_bpm);

        return array(
            'afschrijvingspercentage' => $afschrijvingspercentage,
            'bpm_over_c02_uitstoot' => $bpm_over_c02,
            'bpm_over_catalogusprijs' => $bpm_over_catalogusprijs,
            'euro6_norm_korting' => ($this->getBrandstof() == "diesel" && $this->getSoortAuto() == "personenauto" && $this->euro6_norm === true) ? 1000 : 0,
            'bruto_bpm' => $bruto_bpm,
            'netto_bpm' => $netto_bpm,
        );
    }

    /**
     * @param int $bpm_co2_uitstoot
     * @param int $bpm_catalogusprijs
     * @return mixed
     * @test done
     */
    public function berekenBrutoBpm($bpm_co2_uitstoot, $bpm_catalogusprijs)
    {
        return $bpm_catalogusprijs + $bpm_co2_uitstoot;
    }

    /**
     * @param string $brandstof
     * @param int $co2_uitstoot
     * @return mixed
     * @throws \Exception
     * @requirement 7
     */
    public function berekenBpmOverCO2Uitstoot($brandstof, $co2_uitstoot)
    {
        // Requirement 7:
        // 1/2 van de hoogte van het te betalen bpm-bedrag voor personenauto's wordt bepaald door de CO2-uitstoot van de personenauto in gram per kilometer (BPM toeslag)
        if (strtolower($brandstof) == "diesel") {
            return $this->berekenBpmOverCO2UitstootDiesel($co2_uitstoot);
        } elseif (strtolower($brandstof) == "benzine") {
            return $this->berekenBpmOverCO2UitstootBenzine($co2_uitstoot);
        } elseif (strtolower($brandstof) == "aardgas") {
            return $this->berekenBpmOverCO2UitstootBenzine($co2_uitstoot);
        } elseif (strtolower($brandstof) == "lpg") {
            return $this->berekenBpmOverCO2UitstootBenzine($co2_uitstoot);
        } else {
            $ex = new \Exception("#1: Brandstof: " . $brandstof . " is onbekend.");
            \Laravel\Log::exception($ex);
            throw $ex;
        }
    }

    /**
     * @param int $co2_uitstoot
     * @return mixed
     * @requirement 23: CO2-uitstoot van 0 tot en met 91 gram/km: trek van de CO2-uitstoot van de auto de waarde 0 af vermenigvuldig de uitkomst met het bedrag 0 tel hier het bedrag 0 bij op
     * @requirement 24: CO2-uitstoot van 91 tot en met 143 gram/km: trek van de CO2-uitstoot van de auto de waarde 91 af vermenigvuldig de uitkomst met het bedrag 101 tel hier het bedrag 0 bij op
     * @requirement 25: CO2-uitstoot van 143 tot en met 211 gram/km: trek van de CO2-uitstoot van de auto de waarde 143 af vermenigvuldig de uitkomst met het bedrag 121 tel hier het bedrag 5252 bij op
     * @requirement 26: CO2-uitstoot van 211 tot en met 225 gram/km: trek van de CO2-uitstoot van de auto de waarde 211 af vermenigvuldig de uitkomst met het bedrag 223 tel hier het bedrag 13480 bij op
     * @requirement 27: CO2-uitstoot van 225 gram/km en hoger: trek van de CO2-uitstoot van de auto de waarde 225 af vermenigvuldig de uitkomst met het bedrag 559 tel hier het bedrag 16602 bij op
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
            array('I' => 211, 'II' => 225, 'III' => 13480, 'IV' => 223),
            array('I' => 255, 'II' => 1000000000, 'III' => 16602, 'IV' => 559),
        );

        // toe te passen rekenwaarde vinden
        $toegepaste_rekenwaarde = null;
        foreach ($rekenwaarden as $rekenwaarde) {
            if ($co2_uitstoot >= $rekenwaarde['I'] && $co2_uitstoot <= $rekenwaarde['II']) {
                $toegepaste_rekenwaarde = $rekenwaarde;
                break;
            }
        }

        $bpm = (($co2_uitstoot - $toegepaste_rekenwaarde['I']) * $toegepaste_rekenwaarde['IV']) + $toegepaste_rekenwaarde['III'];

        $this->output("Te betalen bpm over CO2 uitstoot (diesel): ((" . $co2_uitstoot . " - " . $toegepaste_rekenwaarde['I'] . ") x EUR " . $toegepaste_rekenwaarde['IV'] . ") + EUR " . $toegepaste_rekenwaarde['III'] . " = EUR " . $bpm . "<br>");

        return $bpm;
    }

    /**
     * @param int $co2_uitstoot
     * @return mixed
     * @requirement 18: CO2 uitstoot van 0 tot en met 102 gram/km: trek van de CO2-uitstoot van de auto de waarde 0 af vermenigvuldig de uitkomst met het bedrag 0 tel hier het bedrag 0 bij op
     * @requirement 19: CO2 uitstoot van 102 tot en met 159 gram/km: trek van de CO2-uitstoot van de auto de waarde 102 af vermenigvuldig de uitkomst met het bedrag 101 tel hier het bedrag 0 bij op
     * @requirement 20: CO2 uitstoot van 159 tot en met 237 gram/km: trek van de CO2-uitstoot van de auto de waarde 159 af vermenigvuldig de uitkomst met het bedrag 121 tel hier het bedrag 5757 bij op
     * @requirement 21: CO2 uitstoot van 237 tot en met 242 gram/km: trek van de CO2-uitstoot van de auto de waarde 237 af vermenigvuldig de uitkomst met het bedrag 223 tel hier het bedrag 15195 bij op
     * @requirement 22: CO2 uitstoot van 242 en hoger: trek van de CO2-uitstoot van de auto de waarde 242 af vermenigvuldig de uitkomst met het bedrag 559 tel hier het bedrag 16310 bij op
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
        foreach ($rekenwaarden as $rekenwaarde) {
            if ($co2_uitstoot >= $rekenwaarde['I'] && $co2_uitstoot <= $rekenwaarde['II']) {
                $toegepaste_rekenwaarde = $rekenwaarde;
                break;
            }
        }

        $bpm = (($co2_uitstoot - $toegepaste_rekenwaarde['I']) * $toegepaste_rekenwaarde['IV']) + $toegepaste_rekenwaarde['III'];

        $this->output("Te betalen bpm over CO2 uitstoot (benzine): ((" . $co2_uitstoot . " - " . $toegepaste_rekenwaarde['I'] . ") x EUR " . $toegepaste_rekenwaarde['IV'] . ") + EUR " . $toegepaste_rekenwaarde['III'] . " = EUR " . $bpm . "<br>");

        return $bpm;
    }

    /**
     * @param string $brandstof
     * @param int $netto_catalogusprijs
     * @param int $co2_uitstoot
     * @return float
     * @requirement 8: 2/2 van de hoogte van het te betalen bpm-bedrag voor personenauto's wordt bepaald door de catalogusprijs van de personenauto (BPM)
     */
    public function berekenBpmOverCatalogusprijs($brandstof, $netto_catalogusprijs, $co2_uitstoot)
    {
        $bpm_over_catalogusprijs = 0;

        if ($this->getSoortAuto() == "personenauto") {
            // Requirement 8:
            // 2/2 van de hoogte van het te betalen bpm-bedrag voor personenauto's wordt bepaald door de catalogusprijs van de personenauto (BPM)
            if (strtolower($brandstof) == "diesel") {
                $bpm_over_catalogusprijs = $this->berekenBpmOverCatalogusprijsDiesel($netto_catalogusprijs, $co2_uitstoot);
            } else {
                $bpm_over_catalogusprijs = $this->berekenBpmOverCatalogusprijsGeenDiesel($netto_catalogusprijs);
            }
        }

        return $bpm_over_catalogusprijs;
    }

    /**
     * @param int $netto_catalogusprijs
     * @param int $co2_uitstoot
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
     * @param int $netto_catalogusprijs
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

        $bpm = floor(($netto_catalogusprijs * $bpm_tarief / 100) - $brandstofkorting);

        if ($bpm < 0) $bpm = 0;

        $this->output("Bpm over catalogusprijs (geen diesel): (" . $netto_catalogusprijs . " x " . $bpm_tarief . "/100) - EUR " . $brandstofkorting . " = EUR " . $bpm . "<br>");

        return $bpm;
    }

    /**
     * @requirement 51: Netto bpm-bedrag is het bruto bpm-bedrag min de korting op basis van de afschrijving van het Motorrijtuig
     * @param int $afschrijvingspercentage
     * @param int $bruto_bpm
     * @return float|int
     */
    private function berekenNettoBpmBedrag($afschrijvingspercentage, $bruto_bpm)
    {
        $bpm = floor(((100 - $afschrijvingspercentage) / 100) * $bruto_bpm);

        // Requirement 31: 1000 EUR korting op de bpm als de dieselpersonenauto voldoet aan de EURO 6-norm
        if ($this->euro6_norm === true && $this->getBrandstof() == "diesel" && $this->getSoortAuto() == "personenauto") {
            $bpm = $bpm - 1000;
            $this->output("Euro6 norm korting: 1000 EUR<br>");
        }

        if ($bpm < 0) $bpm = 0;

        $this->output("Te betalen bpm: ((100 - " . $afschrijvingspercentage . "%) / 100) x " . $bruto_bpm . " = EUR " . $bpm . "<br>");

        return $bpm;
    }

    /**
     * @param string $msg
     */
    private function output($msg)
    {
        \Laravel\Log::info($msg);
    }
}
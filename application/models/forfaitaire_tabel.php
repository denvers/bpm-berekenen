<?php
namespace BPMBerekening\afschrijvingsmethode;

require_once( dirname(__FILE__) . "/IAfschrijvingsmethode.php" );

/**
 * User: dsessink
 * Date: 25-07-12
 * Time: 23:24
 *
 * http://www.belastingdienst.nl/wps/wcm/connect/bldcontentnl/belastingdienst/prive/auto_en_vervoer/belastingen_op_auto_en_motor/belasting_van_personenautos_en_motorrijwielen_bpm/waarover_bpm_berekenen/afschrijving_op_basis_van_koerslijst_taxatierapport_of_forfaitaire_tabel/afschrijving_op_basis_van_forfaitaire_tabel
 */
use Exception;

class Forfaitaire_Tabel implements IAfschrijvingsmethode
{
    /**
     * @var \BPMBerekening\models\motorrijtuig\Motorrijtuig
     */
    private $motorrijtuig;

    /**
     * @param \BPMBerekening\models\motorrijtuig\Motorrijtuig $motorrijtuig
     * @return void
     */
    public function setMotorrijtuig($motorrijtuig)
    {
        if ( !class_basename($motorrijtuig) == "Motorrijtuig" )
        {
            throw new Exception("Invalid motorrijtuig given: ".class_basename($motorrijtuig));
        }

        $this->motorrijtuig = $motorrijtuig;
    }

    /**
     * @param \DateTime $datum_aangifte
     * @return int
     */
    public function berekenAfschrijvingspercentage($datum_aangifte = null)
    {
        $datum_eerste_tenaamstelling_nederland = $datum_aangifte; //new \DateTime("08-04-2012"); //new \DateTime("now");
        $datum_eerste_ingebruikname = $this->motorrijtuig->getDatumEersteIngebruikname();

        return $this->tabel($datum_eerste_tenaamstelling_nederland, $datum_eerste_ingebruikname);
    }

    /**
     * De forfaitaire tabel zoals gegeven op:
     * http://www.belastingdienst.nl/wps/wcm/connect/bldcontentnl/belastingdienst/prive/auto_en_vervoer/belastingen_op_auto_en_motor/belasting_van_personenautos_en_motorrijwielen_bpm/waarover_bpm_berekenen/afschrijving_op_basis_van_koerslijst_taxatierapport_of_forfaitaire_tabel/afschrijving_op_basis_van_forfaitaire_tabel
     *
     * @param \DateTime $datum_eerste_tenaamstelling_nederland
     * @param \DateTime $datum_eerste_ingebruikname
     * @return int
     */
    private function tabel($datum_eerste_tenaamstelling_nederland, $datum_eerste_ingebruikname)
    {
        $interval = $datum_eerste_ingebruikname->diff($datum_eerste_tenaamstelling_nederland);
        $leeftijd_in_maanden = ($interval->y * 12) + $interval->m;

        $forfaitwaarden = $this->getForfaitWaarden($leeftijd_in_maanden);

        $overige_maanden = $this->berekenOverigeMaanden($interval, $forfaitwaarden);
        $afschrijvingspercentage = $forfaitwaarden[2] + ($overige_maanden * $forfaitwaarden[3]);

        return $afschrijvingspercentage;
    }

    /**
     * @param $leeftijd_in_maanden
     * @return array
     * @throws \Exception
     */
    private function getForfaitWaarden($leeftijd_in_maanden)
    {
        $forfaitwaarden = null;

        $tabel = array(
            array(0, 1, 0, 8),
            array(1, 3, 8, 3),
            array(3, 5, 14, 2.5),
            array(5, 9, 19, 2.25),
            array(9, 18, 28, 1.444),
            array(18, 30, 41, 0.917),
            array(30, 42, 52, 0.833),
            array(42, 54, 62, 0.75),
            array(54, 66, 71, 0.416),
            array(66, 78, 76, 0.416),
            array(78, 90, 81, 0.333),
            array(90, 112, 85, 0.333),
            array(112, 124, 89, 0.25),
            array(124, 1000000, 92, 0.083),
        );

        foreach( $tabel as $forfait )
        {
            if ( $leeftijd_in_maanden >= $forfait[0] && $leeftijd_in_maanden <= $forfait[1] )
            {
                $forfaitwaarden = $forfait;
                break;
            }
        }

        if ( is_null($forfaitwaarden) )
        {
            throw new Exception("Geen forfaitwaarden gevonden voor leeftijd (in maanden) van: ".$leeftijd_in_maanden);
        }

        return $forfaitwaarden;
    }

    /**
     * @param $interval
     * @param $forfaitwaarden
     * @return int
     */
    private function berekenOverigeMaanden($interval, $forfaitwaarden)
    {
        $leeftijd_in_maanden = ($interval->y * 12) + $interval->m;
        $overige_maanden = $leeftijd_in_maanden - $forfaitwaarden[0];
        if ( $interval->d > 0 )
        {
            $overige_maanden += 1; // extra maand omdat er nog dagen van een extra maand zijn. niet precies x maanden dus.
        }

        return $overige_maanden;
    }
}

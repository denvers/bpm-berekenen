<?php
namespace BPMBerekening\afschrijvingsmethode;

/**
 * User: dsessink
 * Date: 25-07-12
 * Time: 23:32
 */
use Exception;

class Koerslijst implements IAfschrijvingsmethode
{
    /**
     * @var \BPMBerekening\models\motorrijtuig\Motorrijtuig
     */
    private $motorrijtuig;

    /**
     * @param \BPMBerekening\models\motorrijtuig\Motorrijtuig $motorrijtuig
     * @return mixed
     */
    public function setMotorrijtuig($motorrijtuig)
    {
        if ( !class_basename($motorrijtuig) == "Motorrijtuig" )
        {
            throw new Exception("Invalid motorrijtuig given: ".class_basename($motorrijtuig));
        }

        $this->motorrijtuig = $motorrijtuig;
    }

    public function berekenAfschrijvingspercentage($datum_aangifte = null)
    {
        // FIXME waarde volgens de koerslijst ophalen
        // en niet de door de gebruiker ingevoerde inkoopwaarde ;)
        // die inkoopwaarde kan wel weg
        if ( !isset($this->motorrijtuig) )
        {
            $ex = new Exception("Geen motorrijtuig object gevonden voor het berekenen van het afschrijvingspercentage.");
            \Laravel\Log::exception($ex);
            throw $ex;
        }

        $inkoopwaarde_volgens_koerslijst = $this->motorrijtuig->getInkoopwaarde();
        $consumentenprijs = $this->motorrijtuig->getConsumentenprijs();

        $afschrijving = $this->berekenAfschrijving($consumentenprijs, $inkoopwaarde_volgens_koerslijst);

        $percentage = $afschrijving / ($consumentenprijs / 100);

        \Laravel\Log::info("Afschrijvingspercentage: EUR " . $afschrijving . " / ( EUR " . $consumentenprijs . " / 100 ) = " . $percentage . "%<br>");

        return $percentage;
    }

    /**
     * @param $consumentenprijs
     * @param $inkoopwaarde
     * @return int
     */
    public function berekenAfschrijving($consumentenprijs, $inkoopwaarde)
    {
        $afschrijving = $consumentenprijs - $inkoopwaarde;

        if ( $afschrijving <= 0 )
            $afschrijving = 0;

        \Laravel\Log::info("Afschrijving: EUR " . $consumentenprijs . " - EUR " . $inkoopwaarde . " = EUR " . $afschrijving . "<br>");

        return $afschrijving;
    }
}

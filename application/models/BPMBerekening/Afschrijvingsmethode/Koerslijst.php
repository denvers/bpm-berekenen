<?php
namespace BPMBerekening\Afschrijvingsmethode;

use Exception;
use Laravel\Log;

/**
 * User: dsessink
 * Date: 25-07-12
 * Time: 23:32
 */
class Koerslijst implements IAfschrijvingsmethode
{
    /**
     * @var \BPMBerekening\Motorrijtuig\Motorrijtuig
     */
    private $motorrijtuig;

    /**
     * @param \BPMBerekening\Motorrijtuig\Motorrijtuig $motorrijtuig
     * @throws \Exception
     * @return mixed
     */
    public function setMotorrijtuig($motorrijtuig)
    {
        if (!class_basename($motorrijtuig) == "Motorrijtuig") {
            throw new Exception("Invalid Motorrijtuig given: " . class_basename($motorrijtuig));
        }

        $this->motorrijtuig = $motorrijtuig;
    }

    /**
     * @param null $datum_aangifte
     * @return float|int
     * @throws \Exception
     */
    public function berekenAfschrijvingspercentage($datum_aangifte = null)
    {
        // TODO waarde volgens de koerslijst ophalen
        // en niet de door de gebruiker ingevoerde inkoopwaarde ;)
        // die inkoopwaarde kan wel weg
        if (!isset($this->motorrijtuig)) {
            $ex = new Exception("Geen Motorrijtuig object gevonden voor het berekenen van het afschrijvingspercentage.");
            Log::exception($ex);
            throw $ex;
        }

        $inkoopwaarde_volgens_koerslijst = $this->motorrijtuig->getInkoopwaarde();
        $consumentenprijs = $this->motorrijtuig->getConsumentenprijs();

        $afschrijving = $this->berekenAfschrijving($consumentenprijs, $inkoopwaarde_volgens_koerslijst);

        $percentage = $afschrijving / ($consumentenprijs / 100);

        Log::info("Afschrijvingspercentage: EUR " . $afschrijving . " / ( EUR " . $consumentenprijs . " / 100 ) = " . $percentage . "%<br>");

        return $percentage;
    }

    /**
     * @param int $consumentenprijs
     * @param int $inkoopwaarde
     * @return int
     */
    public function berekenAfschrijving($consumentenprijs, $inkoopwaarde)
    {
        $afschrijving = $consumentenprijs - $inkoopwaarde;

        if ($afschrijving <= 0)
            $afschrijving = 0;

        Log::info("Afschrijving: EUR " . $consumentenprijs . " - EUR " . $inkoopwaarde . " = EUR " . $afschrijving . "<br>");

        return $afschrijving;
    }
}
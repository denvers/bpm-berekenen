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
     * @param Motorrijtuig $motorrijtuig
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

    public function berekenAfschrijvingspercentage($datum_aangifte)
    {
        // FIXME waarde volgens de koerslijst ophalen
        // en niet de door de gebruiker ingevoerde inkoopwaarde ;)
        // die inkoopwaarde kan wel weg
        $inkoopwaarde_volgens_koerslijst = $this->motorrijtuig->getVerkoopprijs();
        $consumentenprijs = $this->motorrijtuig->getConsumentenprijs();

        $afschrijving = $this->berekenAfschrijving($consumentenprijs, $inkoopwaarde_volgens_koerslijst);

        $percentage = $afschrijving / ($consumentenprijs / 100);

//        $this->output("Afschrijvingspercentage: EUR " . $afschrijving . " / ( EUR " . $consumentenprijs . " / 100 ) = " . $percentage . "%<br>");

        return $percentage;
    }

    /**
     * @param $consumentenprijs
     * @param $inkoopwaarde
     * @return int
     */
    private function berekenAfschrijving($consumentenprijs, $inkoopwaarde)
    {
        $afschrijving = $consumentenprijs - $inkoopwaarde;

        if ( $afschrijving <= 0 )
            $afschrijving = 0;

//        $this->output("Afschrijving: EUR " . $consumentenprijs . " - EUR " . $inkoopwaarde . " = EUR " . $afschrijving . "<br>");

        return $afschrijving;
    }
}

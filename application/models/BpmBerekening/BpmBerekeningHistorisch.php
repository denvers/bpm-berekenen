<?php
namespace BPMBerekening;

use Laravel\Log;

/**
 * User: dsessink
 * Date: 25-07-12
 * Time: 14:11
 */
class BpmBerekeningHistorisch
{
    /**
     * @param \BpmBerekening\Motorrijtuig\Motorrijtuig $motorrijtuig
     * @throws \Exception
     * @return float|int
     */
    public function berekenBpmOverCatalogusprijs($motorrijtuig)
    {
        $bpm_over_catalogusprijs = 0;

        $datum_eerste_ingebruikname = $motorrijtuig->getDatumEersteIngebruikname()->format("Ymd");

        if ($datum_eerste_ingebruikname < 19930101) {
            throw new \Exception("Geen historische bpm tarieven bekend voor auto met datum eerste ingebruikname: " . $datum_eerste_ingebruikname);
        } //        --- 1a ---
//        ingebruikname in periode van 1 januari 1993 tot en met 30 juni 1997:
        elseif ($datum_eerste_ingebruikname >= 19930101 && $datum_eerste_ingebruikname <= 19970630) {
            \Laravel\Log::info("Historische BPM berekening regel: ingebruikname in periode van 1 januari 1993 tot en met 30 juni 1997");

            $bpm_over_catalogusprijs = $this->berekenBpmOvercatalogusprijsJanuari1993tmApril2000($motorrijtuig);
        } //        --- 1b ---
//        ingebruikname in periode van 1 juli 1997 tot en met 31 december 1997:
        elseif ($datum_eerste_ingebruikname >= 19970701 && $datum_eerste_ingebruikname <= 19971231) {
            \Laravel\Log::info("Historische BPM berekening regel: ingebruikname in periode van 1 juli 1997 tot en met 31 december 1997");

            $bpm_over_catalogusprijs = $this->berekenBpmOvercatalogusprijsJanuari1993tmApril2000($motorrijtuig);
        } //        --- 1c ---
//        ingebruikname in periode van 1 januari 1998 tot en met 30 april 2000:
        elseif ($datum_eerste_ingebruikname >= 19980101 && $datum_eerste_ingebruikname <= 20000430) {
            \Laravel\Log::info("Historische BPM berekening regel: ingebruikname in periode van 1 januari 1998 tot en met 30 april 2000");

            $bpm_over_catalogusprijs = $this->berekenBpmOvercatalogusprijsJanuari1993tmApril2000($motorrijtuig);
        } //        --- 2 ---
//        ingebruikname in periode van 1 mei 2000 tot en met 30 juni 2001:
        elseif ($datum_eerste_ingebruikname >= 20000501 && $datum_eerste_ingebruikname <= 20010630) {
            \Laravel\Log::info("Historische BPM berekening regel: ingebruikname in periode van 1 mei 2000 tot en met 30 juni 2001");
        } //        --- 3 ---
//        ingebruikname in periode van 1 juli 2001 tot en met 31 december 2001:
        elseif ($datum_eerste_ingebruikname >= 20010701 && $datum_eerste_ingebruikname <= 20011231) {
            \Laravel\Log::info("Historische BPM berekening regel: ingebruikname in periode van 1 juli 2001 tot en met 31 december 2001");
        } //        --- 4 ---
//        ingebruikname in periode van 1 januari 2002 tot en met 31 december 2003:
        elseif ($datum_eerste_ingebruikname >= 20020101 && $datum_eerste_ingebruikname <= 20031231) {
            \Laravel\Log::info("Historische BPM berekening regel: ingebruikname in periode van 1 januari 2002 tot en met 31 december 2003");
        } //        --- 5 ---
//        ingebruikname in periode van 1 januari 2004 tot en met 31 december 2004:
        elseif ($datum_eerste_ingebruikname >= 20040101 && $datum_eerste_ingebruikname <= 20041231) {
            \Laravel\Log::info("Historische BPM berekening regel: ingebruikname in periode van 1 januari 2004 tot en met 31 december 2004");
        } //        --- 6 ---
//        ingebruikname in periode van 1 januari 2005 tot en met 31 mei 2005:
        elseif ($datum_eerste_ingebruikname >= 20050101 && $datum_eerste_ingebruikname <= 20050531) {
            \Laravel\Log::info("Historische BPM berekening regel: ingebruikname in periode van 1 januari 2005 tot en met 31 mei 2005");
        } //        --- 7 ---
//        ingebruikname in periode van 1 juni 2005 tot en met 30 juni 2005:
        elseif ($datum_eerste_ingebruikname >= 20050601 && $datum_eerste_ingebruikname <= 20050630) {
            \Laravel\Log::info("Historische BPM berekening regel: ingebruikname in periode van 1 juni 2005 tot en met 30 juni 2005");
        } //        --- 8 ---
//        ingebruikname in periode van 1 juli 2005 tot en met 31 december 2005:
        elseif ($datum_eerste_ingebruikname >= 20050701 && $datum_eerste_ingebruikname <= 20051231) {
            \Laravel\Log::info("Historische BPM berekening regel: ingebruikname in periode van 1 juli 2005 tot en met 31 december 2005");
        } //        --- 9 ---
//        ingebruikname in periode van 1 januari 2006 tot en met 30 juni 2006:
        elseif ($datum_eerste_ingebruikname >= 20060101 && $datum_eerste_ingebruikname <= 20060630) {
            \Laravel\Log::info("Historische BPM berekening regel: ingebruikname in periode van 1 januari 2006 tot en met 30 juni 2006");
        } //        --- 10 ---
//        ingebruikname in periode van 1 juli 2006 tot en met 31 januari 2008:
        elseif ($datum_eerste_ingebruikname >= 20060701 && $datum_eerste_ingebruikname <= 20080131) {
            \Laravel\Log::info("Historische BPM berekening regel: ingebruikname in periode van 1 juli 2006 tot en met 31 januari 2008");
        } //        --- 11 ---
//        ingebruikname in periode van 1 februari 2008 tot en met 31 maart 2008:
        elseif ($datum_eerste_ingebruikname >= 20080201 && $datum_eerste_ingebruikname <= 20080331) {
            \Laravel\Log::info("Historische BPM berekening regel: ingebruikname in periode van 1 februari 2008 tot en met 31 maart 2008");
        } //        --- 12 ---
//        ingebruikname in periode van 1 april 2008 tot en met 31 december 2008:
        elseif ($datum_eerste_ingebruikname >= 20080401 && $datum_eerste_ingebruikname <= 20081231) {
            \Laravel\Log::info("Historische BPM berekening regel: ingebruikname in periode van 1 april 2008 tot en met 31 december 2008");
        } //        --- 12b ---
//        ingebruikname in periode van 1 januari 2009 tot en met 31 december 2009:
        elseif ($datum_eerste_ingebruikname >= 20090101 && $datum_eerste_ingebruikname <= 20091231) {
            \Laravel\Log::info("Historische BPM berekening regel: ingebruikname in periode van 1 januari 2009 tot en met 31 december 2009");
        }

        // TODO
//        ingebruikname in periode van 1 januari 2010 tot en met 31 december 2010:
//        ingebruikname in periode van 1 januari 2011 tot en met 31 december 2011:
//        ingebruikname in periode van 1 januari 2012 tot en met 30 juni 2012:
//        ingebruikname in periode van 1 juli 2012 tot en met 1 augustus 2012:

        return $bpm_over_catalogusprijs;
    }

    /**
     * @param \BpmBerekening\Motorrijtuig\Motorrijtuig $motorrijtuig
     */
    public function berekenBpmOvercatalogusprijsJanuari1993tmApril2000($motorrijtuig)
    {
//        ingebruikname in periode van 1 januari 1993 tot en met 30 juni 1997:
//        ingebruikname in periode van 1 juli 1997 tot en met 31 december 1997:
//        ingebruikname in periode van 1 januari 1998 tot en met 30 april 2000:

        // Personenauto
        if (get_class($motorrijtuig) == "BPMBerekening\Motorrijtuig\PersonenautoGeenDiesel") {
            $bpm_tarief = 45.2;
            $brandstofkorting = 1540;
        } elseif (get_class($motorrijtuig) == "BPMBerekening\Motorrijtuig\PersonenautoDiesel") {
            $bpm_tarief = 45.2;
            $brandstofkorting = 961;
        } // Bestelauto
        elseif (get_class($motorrijtuig) == "BPMBerekening\Motorrijtuig\BestelautoGeenDiesel") {
            //bestelauto met benzinemotor: geen bpm
            return 0;
        } elseif (get_class($motorrijtuig) == "BPMBerekening\Motorrijtuig\BestelautoDiesel") {
            //bestelauto met dieselmotor: geen bpm
            return 0;
        } // Motorfiets
        elseif (get_class($motorrijtuig) == "BPMBerekening\Motorrijtuig\Motorfiets") {
//            requirement 106: netto-catalogusprijs tot en met 2133 EUR: 10,2 % van netto-catalogusprijs
//            requirement 107: netto-catalogusprijs vanaf 2134 EUR: 20,7% van netto-catalogusprijs
//            requirement 108: netto-catalogusprijs vanaf 2134 EUR: verminder met 224 EUR
            if ($motorrijtuig->getNettoCatalogusprijs() <= 2133) {
                $bpm_tarief = 10.2;
                $brandstofkorting = 0;
            } else {
                $bpm_tarief = 20.7;
                $brandstofkorting = 224;
            }
        }

        // TODO requirement 109: oude bpm tarieven elektro, waterstof, zeer zuinige personenauto, hybride => geen bpm

        $bpm = floor(($motorrijtuig->getNettoCatalogusprijs() * $bpm_tarief / 100) - $brandstofkorting);

        if ($bpm < 0) $bpm = 0;

        return $bpm;
    }

    /**
     * @param string $msg
     */
    private function log($msg)
    {
        \Laravel\Log::info($msg);
    }
}
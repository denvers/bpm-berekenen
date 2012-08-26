<?php namespace BPMBerekening;

use DateTime;

/**
 * User: dsessink
 * Date: 24-07-12
 * Time: 14:04
 */
abstract class Motorrijtuig
{
    /**
     * @var int
     */
    protected $co2_uitstoot;

    /**
     * @var DateTime
     */
    private $datum_ingebruikname;

    /**
     * @var DateTime
     */
    private $datum_eerste_toelating;

    /**
     * @var Brandstofsoort
     */
    private $brandstofsoort;

    /**
     * @var int
     */
    private $netto_catalogusprijs;

    /**
     * @var int
     */
    private $catalogusprijs;

    /**
     * @var int
     */
    private $inkoopwaarde;

    /**
     * @var int
     */
    private $consumentenprijs;

    /**
     * @var int
     */
    private $bruto_bpmbedrag;

    /**
     * @var int
     */
    private $netto_bpmbedrag;

    /**
     * @var boolean
     */
    protected $euro_6norm = false;

    /**
     * @var double
     */
    private $afschrijvingspercentage;

    /**
     * @var int
     */
    private $omzetbelasting;

    /**
     * @param \BPMBerekening\Brandstofsoort\Brandstofsoort $brandstofsoort
     */
    public function setBrandstofsoort($brandstofsoort)
    {
        $this->brandstofsoort = $brandstofsoort;
    }

    /**
     * @param int $co2_uitstoot
     */
    public function setCo2Uitstoot($co2_uitstoot)
    {
        if ( $co2_uitstoot < 0 ) $co2_uitstoot = 0;
        $co2_uitstoot = round($co2_uitstoot);

        $this->co2_uitstoot = $co2_uitstoot;
    }

    /**
     * @return int
     */
    public function getCo2Uitstoot()
    {
        return $this->co2_uitstoot;
    }

    /**
     * @param int $consumentenprijs
     */
    public function setConsumentenprijs($consumentenprijs)
    {
        $consumentenprijs = round($consumentenprijs);
        if ( $consumentenprijs < 0 ) $consumentenprijs = 0;
        $this->consumentenprijs = $consumentenprijs;
    }

    /**
     * @return int
     */
    public function getConsumentenprijs()
    {
        return $this->consumentenprijs;
    }

    /**
     * @param int $netto_catalogusprijs
     */
    public function setNettoCatalogusprijs($netto_catalogusprijs)
    {
        $netto_catalogusprijs = round($netto_catalogusprijs);
        if ( $netto_catalogusprijs < 0 ) $netto_catalogusprijs = 0;
        $this->netto_catalogusprijs = $netto_catalogusprijs;
    }

    /**
     * @return int
     */
    public function getNettoCatalogusprijs()
    {
        return $this->netto_catalogusprijs;
    }

    /**
     * @param DateTime $datum_ingebruikname
     */
    public function setDatumIngebruikname($datum_ingebruikname)
    {
        $this->datum_ingebruikname = $datum_ingebruikname;
    }

    /**
     * @return DateTime
     */
    public function getDatumEersteIngebruikname()
    {
        return $this->datum_ingebruikname;
    }

    /**
     * @param int $inkoopwaarde
     */
    public function setInkoopwaarde($inkoopwaarde)
    {
        $inkoopwaarde = round($inkoopwaarde);
        if ( $inkoopwaarde < 0 ) $inkoopwaarde = 0;

        $this->inkoopwaarde = $inkoopwaarde;
    }

    /**
     * @return int
     */
    public function getInkoopwaarde()
    {
        return $this->inkoopwaarde;
    }

    /**
     * @param DateTime $datum_eerste_toelating
     */
    public function setDatumEersteToelating($datum_eerste_toelating)
    {
        $this->datum_eerste_toelating = $datum_eerste_toelating;
    }

    /**
     * @return DateTime
     */
    public function getDatumEersteToelating()
    {
        return $this->datum_eerste_toelating;
    }
}
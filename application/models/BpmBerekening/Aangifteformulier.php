<?php
namespace BPMBerekening;

/**
 * User: dsessink
 * Date: 25-07-12
 * Time: 16:16
 */
class Aangifteformulier
{
    /**
     * @var string
     */
    private $aangifteformulier_origineel;

    public function __construct()
    {
        $this->aangifteformulier_origineel = dirname(__FILE__) . "/../../pdf/originals/berekening_bpm_bij_aangifte_melding_bpm0141b22fol.pdf";
        $this->aangifteformulier_fdf_origineel = dirname(__FILE__) . "/../../pdf/originals/data.fdf";
        $this->tempname_fdf = dirname(__FILE__) . "/../../pdf/temp_" . time() . ".fdf";
        $this->tempname_pdf = dirname(__FILE__) . "/../../pdf/temp_" . time() . ".pdf";
    }

    /**
     * TODO
     */
    public function get()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', true);

        $strings = array(
            "Naam" => "Test aangifte Denver",

            "ParticulierOfOndernemer" => "Particulier",

            "2a_NettoCatalogusPrijs_ZonderAccessoires" => "31337",

            "2b_S_Airco" => "Ja",
            "2b_B_Airco" => "1337",

            "2b_S_Overig1" => "Ja",
            "2b_B_Overig1" => "1337",
            "2b_O_Overig1" => "Extra optie 1",

            "2b_S_Audio" => "Off",
            "2b_S_Automaat" => "Off",
            "2b_S_Climate" => "Off",
            "2b_S_Cruise" => "Off",
            "2b_S_Leer" => "Off",
            "2b_S_Metallic" => "Off",
            "2b_S_Navigatie" => "Off",

            "2b_S_Overig2" => "Off",
            "2b_S_Overig3" => "Off",
            "2b_S_Overig4" => "Off",
            "2b_S_Overig5" => "Off",

            // Automatisch berekend?
//            "2b_Totaal_Accessoires" => "2675",
//            "2c_NettoCatalogusPrijs" => "34012",
//            "2c_NettoCatalogusPrijsA" => "34012",
//            "2c_NettoCatalogusPrijsB" => "34012",
//            "2c_NettoCatalogusPrijsC" => "34012",
//            "2c_NettoCatalogusPrijsD" => "34012",
//            "2c_NettoCatalogusPrijsE" => "34012",
//            "2c_NettoCatalogusPrijsF" => "34012",
//            "2c_NettoCatalogusPrijsG" => "34012",

            "2d" => "Auto_Benzine",
            "2dACO2" => "160",
//            "2dACO2uitstoot" => "4700",
//            "2dA_Bruto-BPM" => "8025",
            "2dB_Bruto-BPM" => "2825",
            "2dC_Bruto-BPM" => "5675",

            "3" => "Afschrijvingstabel",
            "3_vrijstelling" => "Nee",

            "4a" => "1339",
            "4a_2" => "1339",
            "4b" => "53", // 4b: afschrijvingspercentage
//            "4c" => "710",
//            "4f" => "629",
//            "4h" => "629",

            "5b_0" => "Off",

            "5b_2" => "0",
            "5e" => "0",
            "5f" => "0",
            "5h" => "0",
            "5i" => "0",
            "5j_2" => "0",
            "5l" => "0",
            "5o" => "0",
            "6b_0" => "0",
            "6b_2" => "0",
            "6d" => "0",
            "6f" => "0",
            "6g" => "0",
            "6h_2" => "0",
            "6j" => "0",
            "6m" => "0",

//            "BPM_CO2+BPM_Catalogus_C" => "5675",

            "BSNnummer" => "163315826",

//            "PercentageCatalogusPrijs-aftrek_A" => "3325",
//            "PercentageCatalogusPrijs-aftrek_B" => "2825",
//            "PercentageCatalogusPrijs-aftrek_C" => "5675",
//            "PercentageCatalogusPrijs-aftrek_E" => "13095",
//            "PercentageCatalogusPrijs_A" => "3375",
//            "PercentageCatalogusPrijs_B" => "3375",
//            "PercentageCatalogusPrijs_C" => "3375",
//            "PercentageCatalogusPrijs_D" => "12822",
//            "PercentageCatalogusPrijs_E" => "12822",
//            "PercentageCatalogusPrijs_G" => "6598",

        );

        $keys = array(
            "2b_S_Airco" => "Ja",
        );

        $fdf = $this->create_fdf($strings, $keys);

        file_put_contents($this->tempname_fdf, $fdf);

//        echo sprintf(
//            "/usr/local/bin/pdftk %s fill_form %s output %s ",
//            $this->aangifteformulier_origineel,
//            $this->tempname_fdf,
//            $this->tempname_pdf
//        );

        header('Content-type: application/pdf');
        exec(
            sprintf(
                "/usr/local/bin/pdftk %s fill_form %s output %s",
                $this->aangifteformulier_origineel,
                $this->tempname_fdf,
                $this->tempname_pdf
            )
        );

        exit;
    }

    /**
     * @param $strings
     * @param $keys
     * @return string
     */
    private function create_fdf($strings, $keys)
    {
        $fdf = "%FDF-1.2\n";
        $fdf .= "%����\n";
        $fdf .= "1 0 obj\n";
        $fdf .= "<</FDF<</Fields [\n";

        foreach ($strings as $key => $value) {
            $key = addcslashes($key, "\n\r\t\\()");
            $value = addcslashes($value, "\n\r\t\\()");
            $fdf .= "<</T ($key) /V ($value) >> \n";
        }
        foreach ($keys as $key => $value) {
            $key = addcslashes($key, "\n\r\t\\()");
            $fdf .= "<</T ($key) /V /$value >> \n";
        }

        $fdf .= "] /ID[<0E00356DF56AF0F1ED07BA7D7B00E8E1><F039B0B37E2AB94997AFCFC8DE13BE86>]>>/Type/Catalog>>";

        $fdf .= "endobj\n";
        $fdf .= "trailer\n";
        $fdf .= "<</Root 1 0 R>>\n";
        $fdf .= "%%EOF";

        return $fdf;
    }
}

<?php

class Home_Controller extends Base_Controller
{

    /*
     |--------------------------------------------------------------------------
     | The Default Controller
     |--------------------------------------------------------------------------
     |
     | Instead of using RESTful routes and anonymous functions, you might wish
     | to use controllers to organize your application API. You'll love them.
     |
     | This controller responds to URIs beginning with "home", and it also
     | serves as the default controller for the application, meaning it
     | handles requests to the root of the application.
     |
     | You can respond to GET requests to "/home/profile" like so:
     |
     |		public function action_profile()
     |		{
     |			return "This is your profile!";
     |		}
     |
     | Any extra segments are passed to the method as parameters:
     |
     |		public function action_profile($id)
     |		{
     |			return "This is the profile for user {$id}.";
     |		}
     |
     */

    public function action_index()
    {
        $viewdata = array();

        if (Input::has('soort')) {
            $viewdata['berekening_uitgevoerd'] = true;
            $viewdata['berekening'] = $this->berekeningUitvoeren();

//            $aangifteformulier = new Aangifteformulier();
//            $aangifteformulier->get();
//            die();
        }

        return View::make('home.index', $viewdata);
    }

    private function berekeningUitvoeren()
    {
//        Array
//        (
//            [soort] => personenauto
//            [brandstof] => benzine
//            [datum_eerste_ingebruikname] =>
//            [co2_uitstoot] =>
//            [netto_catalogusprijs_eerste_ingebruikname] =>
//            [consumentenprijs] =>
//            [inkoopwaarde] =>
//            [laravel_session] => VmgaVtgy4ehR3MzPJWghG6fpUELGcbqLIXt4TsKT
//            [session_payload] => Bv6GGim6BH79ZBfFAPpgLIUPdDgaD+3FhkWEOlaFuPVU6+/MoX6l+NvpsHDshCgU4Rz0ONqMcDAc/EMGBMpKR3NHJ4932FiD93GTPQ0Bk1BdHA43jpacTG3V0dnOqBtvXFAPDWlR46EeszVhrGqTpGPgX2mFKV7+NeYmUAAzCQ7KW8E32Q7VbY+eWOzZZOjqFZoRmvVYDf76X7rb3jD3SmU9Rdmt/uvSdrJDo+ZNQ8S2VW0hcx773vgrncUKzgf8Zkjq/eJRY4KvxRWTSTzPBtfqZ2od0LaCO9gRzlqu3wZUaTtjOMdR0erRbueM3Rnd8Eb7FwSRQfQ4ETOpv9CBzA==
//            [SQLiteManager_currentLangue] => 2
//        )

        require_once(dirname(__FILE__) . "/../models/BPM_Berekening.php");

        $BPM_Berekening = new \BPMBerekening\models\BPM_Berekening();
        $BPM_Berekening->setBrandstof(Input::get('brandstof'));
        $BPM_Berekening->setCo2Uitstoot(Input::get('co2_uitstoot'));
        $BPM_Berekening->setConsumentenprijs(Input::get('consumentenprijs'));
        $BPM_Berekening->setDatum(new DateTime(Input::get('datum_aangifte')));
        $BPM_Berekening->setDatumEersteIngebruikname(Input::get('datum_eerste_ingebruikname'));
        $BPM_Berekening->setInkoopwaarde(Input::get('inkoopwaarde'));
        $BPM_Berekening->setNettoCatalogusprijs(Input::get('netto_catalogusprijs_eerste_ingebruikname'));
        $BPM_Berekening->setSoortAuto(Input::get('soort'));

        if ( Input::get('euro6_norm') == "ja" )
        {
            $BPM_Berekening->setEuro6Norm(true);
        }

        return $BPM_Berekening->berekenBPM("forfaitaire_tabel");
    }
}
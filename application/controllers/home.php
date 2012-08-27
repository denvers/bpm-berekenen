<?php
use BPMBerekening\BPMBerekening;

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

        $input = Input::all();

        $rules = array(
            'soort' => 'required',
            'brandstof' => 'required',
            'datum_aangifte' => 'required|after:' . date('d-m-Y', strtotime('-1 day')), // vandaag of daarna
            'datum_eerste_ingebruikname' => 'required|before:' . date('d-m-Y'), // voor vandaag
            'co2_uitstoot' => 'integer',
            'netto_catalogusprijs_eerste_ingebruikname' => 'required|integer|min:1',
            'consumentenprijs' => 'required|integer|min:1',
            'inkoopwaarde' => 'required|integer|min:0',
        );

        $validation = Validator::make($input, $rules);

        if (!Input::get('soort') || $validation->fails()) {
            $viewdata['validation_errors'] = $validation->errors;
        } else {
            $viewdata['berekening_uitgevoerd'] = true;
            $viewdata['berekening'] = $this->berekeningUitvoeren();

//            $aangifteformulier = new Aangifteformulier();
//            $aangifteformulier->get();
//            die();

        }

        return View::make('home.index', $viewdata);
    }

    /**
     * @return array
     */
    private function berekeningUitvoeren()
    {
        $BPM_Berekening = new BPMBerekening();
        $BPM_Berekening->setSoortAuto(Input::get('soort'));
        $BPM_Berekening->setBrandstof(Input::get('brandstof'));
        $BPM_Berekening->setDatumEersteIngebruikname(Input::get('datum_eerste_ingebruikname'));
        $BPM_Berekening->setDatum(new DateTime(Input::get('datum_aangifte')));
        $BPM_Berekening->setCo2Uitstoot(Input::get('co2_uitstoot'));
        $BPM_Berekening->setNettoCatalogusprijs(Input::get('netto_catalogusprijs_eerste_ingebruikname'));
        $BPM_Berekening->setConsumentenprijs(Input::get('consumentenprijs'));
        $BPM_Berekening->setInkoopwaarde(Input::get('inkoopwaarde'));

        if (Input::get('euro6_norm') == "ja") {
            $BPM_Berekening->setEuro6Norm(true);
        }

        return $BPM_Berekening->berekenBPM();
    }
}
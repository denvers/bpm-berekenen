<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>BPM Berekenen</title>
	<meta name="viewport" content="width=device-width">
	{{ HTML::style('laravel/css/style.css') }}

    <style>
        label { display: inline-block; width: 200px; }
    </style>
</head>
<body>
	<div class="wrapper">
		<header>
			<h1>BPM Berekenen</h1>
			<h2>Snel &amp; eenvoudig de goedkoopste berekening!</h2>

			<p class="intro-text" style="margin-top: 45px;">
			</p>
		</header>
		<div role="main" class="main">
			<div class="home">
				<h2>Voertuiggegevens</h2>

				<p>
					Om welk voertuig gaat het? Vul de gegevens juist in voor een juiste BPM berekening:
				</p>

                <?= Form::open('/', 'POST'); ?>

                <?= Form::label('soort', 'Soort auto'); ?>
                <?= Form::select('soort', array('personenauto' => 'Personenauto', 'motorfiets' => 'Motorfiets', 'bestelauto' => 'Bestelauto', 'kampeerauto' => 'Kampeerauto')); ?>
                <br>

                <?= Form::label('brandstof', 'Brandstof'); ?>
                <?= Form::select('brandstof', array('benzine' => 'Benzine', 'diesel' => 'Diesel')); ?>
                <br>

                <?= Form::label('euro6_norm', 'Dieselpersonenauto voldoet aan EURO6 norm?'); ?>
                <?= Form::checkbox('euro6_norm', 'ja'); ?>
                <br>

                <?= Form::label('datum_eerste_ingebruikname', 'Datum eerste toelating'); ?>
                <?= Form::text('datum_eerste_ingebruikname', Input::get('datum_eerste_ingebruikname')); ?> <em>01-01-1970</em>
                <br>

                <?= Form::label('datum_aangifte', 'Datum aangifte'); ?>
                <?= Form::text('datum_aangifte', date('d-m-Y') /*Input::get('datum_aangifte')*/); ?> <em>01-01-1970</em>
                <br>

                <?= Form::label('co2_uitstoot', 'CO2-uitstoot'); ?>
                <?= Form::text('co2_uitstoot', Input::get('co2_uitstoot')); ?> gram / km
                <br>

                <?= Form::label('netto_catalogusprijs_eerste_ingebruikname', 'Netto-catalogusprijs bij eerste ingebruikname'); ?>
                <?= Form::text('netto_catalogusprijs_eerste_ingebruikname', Input::get('netto_catalogusprijs_eerste_ingebruikname')); ?> EUR
                <br>

                <?= Form::label('consumentenprijs', 'Consumentenprijs'); ?>
                <?= Form::text('consumentenprijs', Input::get('consumentenprijs')); ?> EUR <em>(nieuwprijs in Nederland op datum eerste ingebruikname)</em>
                <br>

                <?= Form::label('inkoopwaarde', 'Inkoopwaarde op datum aangifte'); ?>
                <?= Form::text('inkoopwaarde', Input::get('inkoopwaarde')); ?> EUR <em>(volgens koerslijst, tegentaxatie of fortaitairtabel)</em>
                <br>

                <?= Form::submit('Nu berekenen!'); ?>

                <?= Form::close(); ?>

                <hr>

                <!--
                'afschrijving' => $afschrijving,
                'afschrijvingspercentage' => $afschrijvingspercentage,
                'bpm_over_c02_uitstoot' => $bpm_over_c02,
                'bpm_over_catalogusprijs' => $bpm_over_catalogusprijs,
                'korting' => 1000,
                'bruto_bpm' => $bruto_bpm,
                'netto_bpm' => $netto_bpm,
                -->

                <?php if (isset($berekening_uitgevoerd) && $berekening_uitgevoerd == true): ?>

                <h2>Uw BPM berekening</h2>

                    <div style="display:inline-block; width:30%; padding: 0 15px 0 0; vertical-align: top;">
                        <h3>Forfaitaire tabel</h3>
                        <ul>
                            <li>Afschrijvingspercentage: <?= $berekening['forfaitaire_tabel']['afschrijvingspercentage']; ?>%</li>
                            <li>BPM over CO<sub>2</sub>-uitstoot: &euro; <?= number_format($berekening['forfaitaire_tabel']['bpm_over_c02_uitstoot'], 0, ",", "."); ?>,-</li>
                            <li>BPM over catalogusprijs: &euro; <?= number_format($berekening['forfaitaire_tabel']['bpm_over_catalogusprijs'], 0, ",", "."); ?>,-</li>
                            <li>Bruto bpm (op datum aangifte): &euro; <?= number_format($berekening['forfaitaire_tabel']['bruto_bpm'], 0, ",", "."); ?>,-</li>
                            <li><b>Te betalen bpm (netto bpm): &euro; <?= number_format($berekening['forfaitaire_tabel']['netto_bpm'], 0, ",", "."); ?>,-</b></li>
                        </ul>
                    </div>

                    <div style="display:inline-block; width:30%; padding: 0 15px 0 0; vertical-align: top;">
                        <h3>Koerslijst tabel</h3>
                        <ul>
                            <li>Afschrijvingspercentage: <?= $berekening['koerslijst']['afschrijvingspercentage']; ?>%</li>
                            <li>BPM over CO<sub>2</sub>-uitstoot: &euro; <?= number_format($berekening['koerslijst']['bpm_over_c02_uitstoot'], 0, ",", "."); ?>,-</li>
                            <li>BPM over catalogusprijs: &euro; <?= number_format($berekening['koerslijst']['bpm_over_catalogusprijs'], 0, ",", "."); ?>,-</li>
                            <li>Bruto bpm (op datum aangifte): &euro; <?= number_format($berekening['koerslijst']['bruto_bpm'], 0, ",", "."); ?>,-</li>
                            <li>EURO6-norm korting: &euro; <?= number_format($berekening['koerslijst']['euro6_norm_korting'], 0, ",", "."); ?>,-</li>
                            <li><b>Te betalen bpm (netto bpm): &euro; <?= number_format($berekening['koerslijst']['netto_bpm'], 0, ",", "."); ?>,-</b></li>
                        </ul>
                    </div>

                    <div style="display:inline-block; width:30%; padding: 0 15px 0 0; vertical-align: top;">
                        <h3>Historisch bruto bpm bedrag</h3>
                        <?php if ( count($berekening['historisch_bruto_bpm_bedrag']) ): ?>
                        <ul>
                            <li>Afschrijvingspercentage: <?= $berekening['historisch_bruto_bpm_bedrag']['afschrijvingspercentage']; ?>%</li>
                            <li>BPM over CO<sub>2</sub>-uitstoot: &euro; <?= number_format($berekening['historisch_bruto_bpm_bedrag']['bpm_over_c02_uitstoot'], 0, ",", "."); ?>,-</li>
                            <li>BPM over catalogusprijs: &euro; <?= number_format($berekening['historisch_bruto_bpm_bedrag']['bpm_over_catalogusprijs'], 0, ",", "."); ?>,-</li>
                            <li>Bruto bpm (op datum aangifte): &euro; <?= number_format($berekening['historisch_bruto_bpm_bedrag']['bruto_bpm'], 0, ",", "."); ?>,-</li>
                            <li>EURO6-norm korting: &euro; <?= number_format($berekening['historisch_bruto_bpm_bedrag']['euro6_norm_korting'], 0, ",", "."); ?>,-</li>
                            <li><b>Te betalen bpm (netto bpm): &euro; <?= number_format($berekening['historisch_bruto_bpm_bedrag']['netto_bpm'], 0, ",", "."); ?>,-</b></li>
                        </ul>
                        <?php else: ?>
                        <p>Bpm berekening op basis van historisch bruto bpm bedrag niet avn toepassing.</p>
                        <?php endif; ?>
                    </div>

                <?php endif; ?>

			</div>
		</div>
	</div>
</body>
</html>

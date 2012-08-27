<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>BPM Berekenen | Snel &amp; eenvoudig de goedkoopste bpm berekening!</title>
    <meta name="viewport" content="width=device-width">
    {{ HTML::style('laravel/css/style.css') }}

    <style>
        label {
            display: inline-block;
            width: 200px;
        }
    </style>
    <script type="text/javascript">

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-1776373-29']);
        _gaq.push(['_trackPageview']);

        (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

    </script>
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

            <?php if (isset($validation_errors)): ?>
            <div class="error" style="color: red;">
                <ul>
                    <?php foreach( $validation_errors->messages as $msg ): ?>
                    <li><?= $msg[0]; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <div class="sidebar">
                <p>
                    Om welk voertuig gaat het? Vul de gegevens juist in voor een juiste BPM berekening:
                </p>
            </div>

            <div class="content">

                <?= Form::open('/#bpm-berekening', 'POST'); ?>

                <table>
                    <tr>
                        <th width="200"><?= Form::label('soort', 'Soort auto'); ?></th>
                        <td><?= Form::select('soort', array('personenauto' => 'Personenauto', 'motorfiets' => 'Motorfiets', 'bestelauto' => 'Bestelauto', 'kampeerauto' => 'Kampeerauto'), Input::get('soort')); ?></td>
                    </tr>
                    <tr>
                        <th><?= Form::label('brandstof', 'Brandstof'); ?></th>
                        <td><?= Form::select('brandstof', array('benzine' => 'Benzine', 'diesel' => 'Diesel'), Input::get('brandstof')); ?></td>
                    </tr>
                    <tr>
                        <th><?= Form::label('euro6_norm', 'Dieselpersonenauto voldoet aan EURO6 norm?'); ?></th>
                        <td><?= Form::checkbox('euro6_norm', 'ja', Input::get('euro6_norm')); ?></td>
                    </tr>
                    <tr>
                        <th><?= Form::label('datum_eerste_ingebruikname', 'Datum eerste toelating'); ?></th>
                        <td><?= Form::text('datum_eerste_ingebruikname', Input::get('datum_eerste_ingebruikname')); ?> <small>bijv. 01-01-1970</small></td>
                    </tr>
                    <tr>
                        <th><?= Form::label('datum_aangifte', 'Datum aangifte'); ?></th>
                        <td><?= Form::text('datum_aangifte', date('d-m-Y') /*Input::get('datum_aangifte')*/); ?> <small>bijv. 01-01-1970</small></td>
                    </tr>
                    <tr>
                        <th><?= Form::label('co2_uitstoot', 'CO2-uitstoot'); ?></th>
                        <td><?= Form::text('co2_uitstoot', Input::get('co2_uitstoot')); ?> <small>gram / km</small></td>
                    </tr>
                    <tr>
                        <th><?= Form::label('netto_catalogusprijs_eerste_ingebruikname', 'Netto-catalogusprijs bij eerste ingebruikname'); ?></th>
                        <td><?= Form::text('netto_catalogusprijs_eerste_ingebruikname', Input::get('netto_catalogusprijs_eerste_ingebruikname')); ?> <small>EUR</small></td>
                    </tr>
                    <tr>
                        <th>
                            <?= Form::label('consumentenprijs', 'Consumentenprijs'); ?><br>
                            <small>Nieuwprijs in Nederland op datum eerste ingebruikname</small>
                        </th>
                        <td><?= Form::text('consumentenprijs', Input::get('consumentenprijs')); ?> <small>EUR</small></td>
                    </tr>
                    <tr>
                        <th>
                            <?= Form::label('inkoopwaarde', 'Inkoopwaarde op datum aangifte'); ?><br>
                            <small>volgens koerslijst, tegentaxatie of fortaitairtabel</small>
                        </th>
                        <td><?= Form::text('inkoopwaarde', Input::get('inkoopwaarde')); ?> <small>EUR</small></td>
                    </tr>
                </table>

                <?= Form::submit('Nu berekenen!'); ?>

                <?= Form::close(); ?>
            </div>

                <?php if (isset($berekening_uitgevoerd) && $berekening_uitgevoerd == true): ?>
                <div class="content">
                    <h2>Uw BPM berekening</h2>

                    <table>
                        <tr>
                            <th></th>
                            <th>Forfaitairetabel</th>
                            <th>Koerslijst</th>
                            <th>Historisch bruto bpm bedrag</th>
                        </tr>
                        <tr>
                            <th>Afschrijvingspercentage</th>
                            <td><?= $berekening['forfaitaire_tabel']['afschrijvingspercentage']; ?>%</td>
                            <td><?= $berekening['koerslijst']['afschrijvingspercentage']; ?>%</td>
                            <td><?= $berekening['historisch_bruto_bpm_bedrag']['afschrijvingspercentage']; ?>%</td>
                        </tr>
                        <tr>
                            <th>Bpm over CO<sub>2</sub>-uitstoot</th>
                            <td>&euro; <?= number_format($berekening['forfaitaire_tabel']['bpm_over_c02_uitstoot'], 0, ",", "."); ?>,-</td>
                            <td>&euro; <?= number_format($berekening['koerslijst']['bpm_over_c02_uitstoot'], 0, ",", "."); ?>,-</td>
                            <td>&euro; <?= number_format($berekening['historisch_bruto_bpm_bedrag']['bpm_over_c02_uitstoot'], 0, ",", "."); ?>,-</td>
                        </tr>
                        <tr>
                            <th>Bruto bpm<br><small>op datum aangifte</small></th>
                            <td>&euro; <?= number_format($berekening['forfaitaire_tabel']['bruto_bpm'], 0, ",", "."); ?>,-</td>
                            <td>&euro; <?= number_format($berekening['koerslijst']['bruto_bpm'], 0, ",", "."); ?>,-</td>
                            <td>&euro; <?= number_format($berekening['historisch_bruto_bpm_bedrag']['bruto_bpm'], 0, ",", "."); ?>,-</td>
                        </tr>
                        <tr>
                            <th>Afschrijvingspercentage</th>
                            <td><?= $berekening['forfaitaire_tabel']['afschrijvingspercentage']; ?>%</td>
                            <td><?= $berekening['koerslijst']['afschrijvingspercentage']; ?>%</td>
                            <td><?= $berekening['historisch_bruto_bpm_bedrag']['afschrijvingspercentage']; ?>%</td>
                        </tr>
                        <tr>
                            <th>Te betalen bpm<br><small>netto bpm</small></th>
                            <td>&euro; <?= number_format($berekening['forfaitaire_tabel']['netto_bpm'], 0, ",", "."); ?>,-</td>
                            <td>&euro; <?= number_format($berekening['koerslijst']['netto_bpm'], 0, ",", "."); ?>,-</td>
                            <td>&euro; <?= number_format($berekening['historisch_bruto_bpm_bedrag']['netto_bpm'], 0, ",", "."); ?>,-</td>
                        </tr>
                    </table>
                </div>
                <?php endif; ?>
        </div>
    </div>
    <footer style="padding: 15px 0 0 0; margin: 15px 0 0 0; border-top: solid 1px #eee;">
        Auto invoeren? Bereken hier snel de bpm! - Vragen of suggesties? <a href="mailto:info@snelbpmberekenen.nl">info@snelbpmberekenen.nl</a> <br>
        <small>Hoewel de berekening geheel volgens de berekening van de Belastingdienst wordt gedaan, kunnen hier geen rechten aan ontleend worden.</small>
    </footer>
</div>
</body>
</html>
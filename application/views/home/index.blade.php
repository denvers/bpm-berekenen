<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Snel &amp; eenvoudig de goedkoopste bpm berekening op snelbpmberekenen.nl!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--
    {{ HTML::style('laravel/css/style.css') }}
    -->
    {{ HTML::style('css/bootstrap.min.css') }}
    {{ HTML::style('css/bootstrap-responsive.min.css') }}
    {{ HTML::style('css/style.css') }}

    <script type="text/javascript">

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-1776373-29']);
        _gaq.push(['_trackPageview']);

        (function () {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();

    </script>
</head>
<body>

<div class="container-fluid">
    <header class="page-header">
        <h1>BPM Berekenen <small>Snel &amp; eenvoudig de goedkoopste berekening!</small> <span class="label label-info">beta</span></h1>
        <p>Blijf op de hoogte van updates via Twitter: <a href="http://twitter.com/bpmberekenen">@bpmberekenen</a></p>
    </header>

    <div class="alert alert-success">
        <h4>Wist je dat</h4>
        De bpm berekening is gratis en actueel volgens de meest recente berekeningen van 2012!
    </div>

    <div role="main" class="main">
        <div class="home">

            <h2>Voertuiggegevens</h2>

            <?php if (isset($validation_errors)): ?>
            <div class="alert alert-error">
                <strong>Oeps</strong>
                <ul>
                    <?php foreach ($validation_errors->messages as $msg): ?>
                    <li><?= $msg[0]; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <p class="lead">
                Om welk voertuig gaat het? Vul de gegevens juist in voor een juiste BPM berekening
            </p>

            <div class="">

                <?= Form::open('/#bpm-berekening', 'POST', array('class' => 'form-horizontal')); ?>

                <div class="control-group">
                    <?= Form::label('soort', 'Soort auto', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?= Form::select('soort', array('personenauto' => 'Personenauto', 'motorfiets' => 'Motorfiets', 'bestelauto' => 'Bestelauto', 'kampeerauto' => 'Kampeerauto'), Input::get('soort')); ?>
                    </div>
                </div>

                <div class="control-group">
                    <?= Form::label('brandstof', 'Brandstof', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?= Form::select('brandstof', array('benzine' => 'Benzine', 'diesel' => 'Diesel'), Input::get('brandstof')); ?>
                    </div>
                </div>

                <div class="control-group">
                    <?= Form::label('euro6_norm', 'Dieselpersonenauto voldoet aan EURO6 norm?', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?= Form::checkbox('euro6_norm', 'ja', Input::get('euro6_norm')); ?>
                    </div>
                </div>

                <div class="control-group">
                    <?= Form::label('datum_eerste_ingebruikname', 'Datum eerste toelating', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?= Form::date('datum_eerste_ingebruikname', Input::get('datum_eerste_ingebruikname')); ?>
                        <small class="help-block">Bijv. 01-01-1970</small>
                    </div>
                </div>

                <div class="control-group">
                    <?= Form::label('datum_aangifte', 'Datum aangifte', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?= Form::date('datum_aangifte', date('Y-m-d') /*Input::get('datum_aangifte')*/); ?>
                        <small class="help-block">Bijv. 01-01-1970</small>
                    </div>
                </div>

                <div class="control-group">
                    <?= Form::label('co2_uitstoot', 'CO2-uitstoot', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?= Form::text('co2_uitstoot', Input::get('co2_uitstoot'), array('class' => 'input-small')); ?>
                        <span class="help-inline">gram / km</span>
                    </div>
                </div>

                <div class="control-group">
                    <?= Form::label('netto_catalogusprijs_eerste_ingebruikname', 'Netto-catalogusprijs bij eerste ingebruikname', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <div class="input-prepend input-append">
                            <span class="add-on">&euro;</span>
                            <?= Form::text('netto_catalogusprijs_eerste_ingebruikname', Input::get('netto_catalogusprijs_eerste_ingebruikname'), array('class' => 'input-small')); ?>
                            <span class="add-on">,00</span>
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <?= Form::label('consumentenprijs', 'Consumentenprijs', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <div class="input-prepend input-append">
                            <span class="add-on">&euro;</span>
                            <?= Form::text('consumentenprijs', Input::get('consumentenprijs'), array('class' => 'input-small')); ?>
                            <span class="add-on">,00</span>
                        </div>
                        <small class="help-block">Nieuwprijs in Nederland op datum eerste ingebruikname</small>
                    </div>
                </div>

                <div class="control-group">
                    <?= Form::label('inkoopwaarde', 'Inkoopwaarde op datum aangifte', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <div class="input-prepend input-append">
                            <span class="add-on">&euro;</span>
                            <?= Form::text('inkoopwaarde', Input::get('inkoopwaarde'), array('class' => 'input-small')); ?>
                            <span class="add-on">,00</span>
                        </div>
                        <small class="help-block">Volgens koerslijst of tegentaxatie</small>
                    </div>
                </div>

                <div class="form-actions">
                    <?= Form::submit('Nu berekenen!', array('class' => 'btn btn-primary')); ?>
                </div>

                <?= Form::close(); ?>
            </div>

        </div>
    </div>
    <footer>
        <p>Auto invoeren? Bereken hier snel de bpm! &ndash; Vragen of suggesties? <a href="mailto:info@snelbpmberekenen.nl">info@snelbpmberekenen.nl</a></p>

        <p><small>Hoewel de berekening geheel volgens de opgegeven berekening van de Belastingdienst wordt gedaan, kunnen hier geen
            rechten aan ontleend worden &ndash; Meer informatie over de opgave van de Belastingdienst? <a href="http://www.belastingdienst.nl/wps/wcm/connect/bldcontentnl/belastingdienst/prive/auto_en_vervoer/belastingen_op_auto_en_motor/belasting_van_personenautos_en_motorrijwielen_bpm/bereken_de_bpm/" title="Meer informatie over de bpm berekening volgens de Belastingdienst">Meer informatie over de bpm berekening volgens de Belastingdienst</a>.
        </small></p>
    </footer>
</div>

{{ HTML::script('http://code.jquery.com/jquery-1.8.1.min.js') }}
{{ HTML::script('js/bootstrap-modal.js') }}

<?php if (isset($berekening_uitgevoerd) && $berekening_uitgevoerd == true): ?>
    <div class="modal" id="myModal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Uw bpm berekening</h3>
        </div>
        <div class="modal-body">
            <div class="alert alert-info">
                Hoeveel bpm moet ik betalen? Zie hieronder het laagste netto bpm bedrag. Dat is de bpm die betaald moet worden.
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th>Forfaitairetabel</th>
                        <th>Koerslijst</th>
                        <th>Historisch bruto bpm bedrag</th>
                    </tr>
                </thead>
                <tr>
                    <th>Afschrijvingspercentage</th>
                    <td><?= $berekening['forfaitaire_tabel']['afschrijvingspercentage']; ?>%</td>
                    <td><?= $berekening['koerslijst']['afschrijvingspercentage']; ?>%</td>
                    <td><?= $berekening['historisch_bruto_bpm_bedrag']['afschrijvingspercentage']; ?>%</td>
                </tr>
                <tr>
                    <th>Bpm over CO<sub>2</sub>-uitstoot</th>
                    <td>&euro; <?= number_format($berekening['forfaitaire_tabel']['bpm_over_c02_uitstoot'], 0, ",", "."); ?>
                        ,-
                    </td>
                    <td>&euro; <?= number_format($berekening['koerslijst']['bpm_over_c02_uitstoot'], 0, ",", "."); ?>
                        ,-
                    </td>
                    <td>&euro; <?= number_format($berekening['historisch_bruto_bpm_bedrag']['bpm_over_c02_uitstoot'], 0, ",", "."); ?>
                        ,-
                    </td>
                </tr>
                <tr>
                    <th>Bruto bpm<br>
                        <small>op datum aangifte</small>
                    </th>
                    <td>&euro; <?= number_format($berekening['forfaitaire_tabel']['bruto_bpm'], 0, ",", "."); ?>,-
                    </td>
                    <td>&euro; <?= number_format($berekening['koerslijst']['bruto_bpm'], 0, ",", "."); ?>,-</td>
                    <td>&euro; <?= number_format($berekening['historisch_bruto_bpm_bedrag']['bruto_bpm'], 0, ",", "."); ?>
                        ,-
                    </td>
                </tr>
                <tr>
                    <th>EURO6-norm korting</th>
                    <td>&euro; <?= $berekening['forfaitaire_tabel']['euro6_norm_korting']; ?>,-</td>
                    <td>&euro; <?= $berekening['koerslijst']['euro6_norm_korting']; ?>,-</td>
                    <td>&euro; <?= $berekening['historisch_bruto_bpm_bedrag']['euro6_norm_korting']; ?>,-</td>
                </tr>
                <tr>
                    <th>Te betalen bpm<br>
                        <small>netto bpm</small>
                    </th>
                    <td>&euro; <?= number_format($berekening['forfaitaire_tabel']['netto_bpm'], 0, ",", "."); ?>,-
                    </td>
                    <td>&euro; <?= number_format($berekening['koerslijst']['netto_bpm'], 0, ",", "."); ?>,-</td>
                    <td>&euro; <?= number_format($berekening['historisch_bruto_bpm_bedrag']['netto_bpm'], 0, ",", "."); ?>
                        ,-
                    </td>
                </tr>
            </table>

        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Sluit</a>
        </div>
    </div>
    <script type="text/javascript">$('#myModal').modal('show');</script>
<?php endif; ?>
</body>
</html>
<?php 

return array(

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used
	| by the validator class. Some of the rules contain multiple versions,
	| such as the size (max, min, between) rules. These versions are used
	| for different input types such as strings and files.
	|
	| These language lines may be easily changed to provide custom error
	| messages in your application. Error messages for custom validation
	| rules may also be added to this file.
	|
	*/

	"accepted"       => "Het :attribute moet worden geaccepteerd.",
	"active_url"     => "Het :attribute is geen juiste URL.",
	"after"          => "Het :attribute moet een datum zijn na :date.",
	"alpha"          => "Het :attribute mag alleen uit letters bestaan.",
	"alpha_dash"     => "Het :attribute mag alleen bestaan uit letters, cijfers en streepjes.",
	"alpha_num"      => "Het :attribute mag alleen bestaan uit letters en cijfers.",
	"before"         => "Het :attribute moet een datum zijn voor :date.",
	"between"        => array(
		"numeric" => "Het :attribute moet vallen tussen :min - :max.",
		"file"    => "Het :attribute moet vallen tussen :min - :max kilobytes.",
		"string"  => "Het :attribute moet vallen tussen :min - :max karakters.",
	),
	"confirmed"      => "Het :attribute bevestiging komt niet overeen.",
	"different"      => "Het :attribute en :other mogen niet overeen komen.",
	"email"          => "Het :attribute formaat is onjuist.",
	"exists"         => "Het geselecteerde :attribute is onjuist.",
	"image"          => "Het :attribute moet een afbeelding zijn.",
	"in"             => "Het geselecteerde :attribute is onjuist.",
	"integer"        => "Het :attribute moet een getal zijn.",
	"ip"             => "Het :attribute moet een geldig IP adres zijn.",
	"match"          => "Het :attribute formaat is onjuist.",
	"max"            => array(
		"numeric" => "Het :attribute moet kleiner zijn dan :max.",
		"file"    => "Het :attribute moet kleiner zijn dan :max kilobytes.",
		"string"  => "Het :attribute moet kleiner zijn dan :max karakters.",
	),
	"mimes"          => "Het :attribute moet een bestand zijn van het type: :values.",
	"min"            => array(
		"numeric" => "Het :attribute moet tenminste :min zijn.",
		"file"    => "Het :attribute moet tenminste :min kilobytes zijn.",
		"string"  => "Het :attribute moet tenminste :min karakters zijn.",
	),
	"not_in"         => "Het geselecteerde :attribute is onjuist.",
	"numeric"        => "Het :attribute moet een getal zijn.",
	"required"       => "Het :attribute veld is verplicht.",
	"same"           => "Het :attribute en :other moeten overeenkomen.",
	"size"           => array(
		"numeric" => "Het :attribute moet :size zijn.",
		"file"    => "Het :attribute moet :size kilobyte zijn.",
		"string"  => "Het :attribute moet :size karakters zijn.",
	),
	"unique"         => "Het :attribute bestaat al.",
	"url"            => "Het :attribute formaat is onjuist.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute_rule" to name the lines. This helps keep your
	| custom validation clean and tidy.
	|
	| So, say you want to use a custom validation message when validating that
	| the "email" attribute is unique. Just add "email_unique" to this array
	| with your custom message. The Validator will handle the rest!
	|
	*/

	'custom' => array(),

	/*
	|--------------------------------------------------------------------------
	| Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as "E-Mail Address" instead
	| of "email". Your users will thank you.
	|
	| The Validator class will automatically search this array of lines it
	| is attempting to replace the :attribute place-holder in messages.
	| It's pretty slick. We think you'll like it.
	|
	*/

	'attributes' => array(),

);
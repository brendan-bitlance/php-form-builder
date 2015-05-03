<?php

namespace Form;

spl_autoload_register(function($fully_qualified_name) {
	$name = str_replace('\\', DIRECTORY_SEPARATOR, $fully_qualified_name);
	$path = dirname(__DIR__) . "/{$name}.php";
	if (is_file($path)) {
		include $path;
	}
});

?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo __FILE__ ?></title>
		<link rel="stylesheet" href="bootstrap.min.css">
		<link rel="stylesheet" href="form.css">
	</head>
	<body>
		<div class="col-lg-12">
<?php

$names = new Element\Fieldset(array(
	new Element\Group(array(new Element\Pair(new Element\Text(array('name' => 'name[0]')), 'First name:'))),
	new Element\Group(array(new Element\Pair(new Element\Text(array('name' => 'name[1]')), 'Last name:'))),
	new Element\Group(array(new Element\Pair(new Element\Text(array('name' => 'preferred')), 'Preferred name:')), 'Shown to all other users')
), 'Legend goes here');
$country = new Element\Group(array(new Element\Pair(new Element\Select(array(
	'AU' => 'Australia',
	'NZ' => 'New Zealand',
	'Rest of the World' => array(
		'R1' => 'Europe',
		'R2' => 'North America',
		'R3' => 'South America',
		'R4' => 'Give up'
	)
), 'NZ', array('name' => 'country')), 'Country:')));

$gender = new Element\Fieldset(array(
	new Element\Group(array(
		new Element\CheckablePair(new Element\Radio(array('name' => 'gender', 'value' => 'M')), 'Male'),
		new Element\CheckablePair(new Element\Radio(array('name' => 'gender', 'value' => 'F')), 'Female'),
))), new Element\Legend('Gender', array('class' => 'flush')));
/*$gender = new Element\Group(array(
	new Element\CheckablePair(new Element\Radio(array('name' => 'gender', 'value' => 'M')), 'Male'),
	new Element\CheckablePair(new Element\Radio(array('name' => 'gender', 'value' => 'F')), 'Female'),
));*/
$bio = new Element\Group(array(new Element\Pair(new Element\Textarea(array('name' => 'bio')), 'Biography')));
$subscribe = new Element\Group(array(new Element\CheckablePair(new Element\Checkbox(array('name' => 'subscribe')), 'Subscribe?')), 'Promise not to send too much junk');
$submit_group = new Element\Group(array(new Element\Pair(new Element\Submit())));
$submit_group->add_attribute('class', 'submit');

$form = new Element\Form();
$form->set_lines(array(
	$names,
	$country,
	$gender,
	$bio,
	$subscribe,
	$submit_group
));
$form->set_validation(array(
	'preferred' => array(
		new Validation\Required('We need to know who you are :/'),
		new Validation\Length(null, 2)
	),
	'country' => new Validation\Required(),
	'bio' => new Validation\Required()
));
if (!empty($_POST)) {
	$form->populate($_POST);
}
echo $form->generate(3);

?>

			<pre><?php print_r($_POST) ?></pre>
		</div>
	</body>
</html>

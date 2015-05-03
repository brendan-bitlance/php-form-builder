<?php

namespace Form;

include 'Builder.php';

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
			<h1>Registration</h1>
<?php

$form = new Builder();
$form->fieldset('Contact Info')
	->group()
		->pair(new Element\Text(array('name' => 'name[0]')), 'First name:')
	->group()
		->pair(new Element\Text(array('name' => 'name[1]')), 'Last name:')
	->group('Shown to all other users')
		->pair(new Element\Text(array('name' => 'preferred')), '*Preferred name:')
	->close_fieldset();
$form->group()
	->pair(new Element\Select(array(
		'AU' => 'Australia',
		'Rest of the World' => array(
			'R1' => 'Asia',
			'R2' => 'Africa',
			'R3' => 'North America',
			'R4' => 'South America',
			'R5' => 'Antarctica',
			'R6' => 'Europe'
		),
		'Other Planets' => array(
			'Very Funny' => 'Uranus'
		)
	), 'AU', array('name' => 'country')), '*Country:');
$form->group()
		->pair(new Element\Select(array('Lollipops', 'Chocolate', 'Milkshakes', 'Broccoli'), null, array('name' => 'interests[]', 'multiple')), 'Interests:');
$form->fieldset(new Element\Legend('Gender', array('class' => 'flush')))
	->group()
		->pair(new Element\Radio(array('name' => 'gender', 'value' => 'M')), 'Male')
		->pair(new Element\Radio(array('name' => 'gender', 'value' => 'F')), 'Female')
	->close_fieldset();
$form->group()
		->pair(new Element\Textarea(array('name' => 'bio', 'placeholder' => 'Tell us about yourself...')), 'Biography');
$form->group('We promise not to send too much junk...')
		->pair(new Element\Checkbox(array('name' => 'subscribe')), 'Subscribe?');
$form->submit();

$form->set_validation(array(
	'preferred' => array(
		new Validation\Required('We need to know who you are :/'),
		new Validation\Length(3, 16)
	),
	'country' => new Validation\Required()
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

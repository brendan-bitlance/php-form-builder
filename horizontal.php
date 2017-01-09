<?php

namespace Php\Form\Builder;

include 'Builder.php';

spl_autoload_register(function($class) {

    // project-specific namespace prefix
    $prefix = 'Php\\Form\\Builder\\';

    // base directory for the namespace prefix
    //$base_dir = __DIR__ . '/src/';
    $base_dir = '';

    // does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }

    // get the relative class name
    $relative_class = substr($class, $len);

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
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
        <div class="container">
            <h1>Registration</h1>
<?php
$form = new Theme\Horizontal();
$form->fieldset('Contact Info')
        ->group()
        ->pair(new Element\Text(array('name' => 'name[first]')), 'First name:')
        ->group()
        ->pair(new Element\Text(array('name' => 'name[last]')), 'Last name:')
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
        ->group_checkable()
        ->pair(new Element\Radio(array('name' => 'gender', 'value' => 'M')), 'Male')
        ->pair(new Element\Radio(array('name' => 'gender', 'value' => 'F')), 'Female')
        ->close_fieldset();
$form->group()
        ->pair(new Element\Textarea(array('name' => 'bio', 'placeholder' => 'Tell us about yourself...')), 'Biography');
$form->group()
        ->pair(new Element\DateTime(array('name' => 'time', 'value' => date('Y-m-d H:i:s'))), 'Got the date and time?');
$form->group_checkable('We promise not to send too much junk...')
        ->pair(new Element\Checkbox(array('name' => 'subscribe')), 'Subscribe?')
        ->pair(new Element\Checkbox(array('name' => 'subscribe2')), 'Subscribe Again?');
$form->group_checkable()
        ->pair(new Element\BitCheckbox(array('name' => 'should[be][easy]'), 'A'), 'A')
        ->pair(new Element\BitCheckbox(array('name' => 'should[be][tricky]'), 'B'), 'B');
$form->buttons(
        new Element\Button('Test A', ['name' => 'test', 'value' => 'a']),
        new Element\Button('Test B', ['name' => 'test', 'value' => 'b']),
        new Element\Button('Test Really Long Name', ['name' => 'test', 'value' => 'c']),
        new Element\Button('Test D', ['name' => 'test', 'value' => 'd']));

$form->set_validation(array(
    'name' => new Validation\Length(1),
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

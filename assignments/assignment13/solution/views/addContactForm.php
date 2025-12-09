<?php
// views/addContactForm.php
require_once 'includes/navigation.php';
require_once 'classes/StickyForm.php';
require_once 'classes/Pdo_methods.php';

// build sticky forum
function getContactFormConfig() {
    return [
        'masterStatus' => [
            'error' => false,
            'msg'   => ''
        ],

        'fname' => [
            'type' => 'text',
            'id' => 'fname',
            'name' => 'fname',
            'label' => 'First Name',
            'required' => true,
            'regex' => 'name',
            'value' => '',
            'errorMsg' => 'You must enter a valid first name',
            'error' => ''
        ],

        'lname' => [
            'type' => 'text',
            'id' => 'lname',
            'name' => 'lname',
            'label' => 'Last Name',
            'required' => true,
            'regex' => 'name',
            'value' => '',
            'errorMsg' => 'You must enter a valid last name',
            'error' => ''
        ],

        'address' => [
            'type' => 'text',
            'id' => 'address',
            'name' => 'address',
            'label' => 'Address',
            'required' => true,
            'regex' => 'address',
            'value' => '',
            'errorMsg' => 'You must enter a valid address.',
            'error' => ''
        ],

        'city' => [
            'type' => 'text',
            'id' => 'city',
            'name' => 'city',
            'label' => 'City',
            'required' => true,
            'regex' => 'city',
            'value' => '',
            'errorMsg' => 'You must enter a valid city.',
            'error' => ''
        ],

        'state' => [
            'type' => 'select',
            'id' => 'state',
            'name' => 'state',
            'label' => 'State',
            'required' => true, // must now be required (based on spec)
            'selected' => '0',
            'options' => [
                '0' => 'Please Select a State',
                'ca' => 'California',
                'tx' => 'Texas',
                'mi' => 'Michigan',
                'ny' => 'New York',
                'fl' => 'Florida'
            ],
            'errorMsg' => 'You must select a state.',
            'error' => ''
        ],

        'zip' => [
            'type' => 'text',
            'id' => 'zip',
            'name' => 'zip',
            'label' => 'Zip Code',
            'required' => true,
            'regex' => 'zip',
            'value' => '',
            'errorMsg' => 'You must enter a valid zip code.',
            'error' => ''
        ],

        'phone' => [
            'type' => 'text',
            'id' => 'phone',
            'name' => 'phone',
            'label' => 'Phone',
            'required' => true,
            'regex' => 'phone',
            'value' => '',
            'errorMsg' => 'You must enter a valid phone number.',
            'error' => ''
        ],

        'email' => [
            'type' => 'text',
            'id' => 'email',
            'name' => 'email',
            'label' => 'Email',
            'required' => true,
            'regex' => 'email',
            'value' => '',
            'errorMsg' => 'You must enter a valid email address.',
            'error' => ''
        ],

        'dob' => [
            'type' => 'text',
            'id' => 'dob',
            'name' => 'dob',
            'label' => 'Date of Birth',
            'required' => true,
            'regex' => 'dob',
            'value' => '',
            'errorMsg' => 'You must enter a valid date of birth',
            'error' => ''
        ],

        'age' => [
            'type' => 'radio',
            'id' => 'age',
            'name' => 'age',
            'label' => 'Choose an Age Range',
            'required' => true,
            'options' => [
                ['value' => '0-17', 'label' => '0-17', 'checked' => false],
                ['value' => '18-30', 'label' => '18-30', 'checked' => false],
                ['value' => '30-50', 'label' => '30-50', 'checked' => false],
                ['value' => '50+', 'label' => '50+', 'checked' => false],
            ],
            'errorMsg' => 'You must select an age range',
            'error' => ''
        ],

        'contact' => [
            'type' => 'checkbox',
            'id' => 'contact',
            'name' => 'contact',
            'label' => 'Select One or More Options',
            'options' => [
                ['value' => 'newsletter', 'label' => 'newsletter', 'checked' => false],
                ['value' => 'email', 'label' => 'email', 'checked' => false],
                ['value' => 'text', 'label' => 'text', 'checked' => false],
            ],
            'error' => ''
        ],


    ];
}

// build inner html form
function renderContactForm(StickyForm $sticky, $formConfig) {
    $html = '';

    $html .= '<div class="row">';
    $html .= '<div class="col-md-6">' . $sticky->renderInput($formConfig['fname'], 'mb-3') . '</div>';
    $html .= '<div class="col-md-6">' . $sticky->renderInput($formConfig['lname'], 'mb-3') . '</div>';
    $html .= '</div>';

    $html .= '<div class="row">';
    $html .= '<div class="col-md-12">' . $sticky->renderInput($formConfig['address'], 'mb-3') . '</div>';
    $html .= '</div>';

    $html .= '<div class="row">';
    $html .= '<div class="col-md-4">' . $sticky->renderInput($formConfig['city'], 'mb-3') . '</div>';
    $html .= '<div class="col-md-4">' . $sticky->renderSelect($formConfig['state'], 'mb-3') . '</div>';
    $html .= '<div class="col-md-4">' . $sticky->renderInput($formConfig['zip'], 'mb-3') . '</div>';
    $html .= '</div>';

    $html .= '<div class="row">';
    $html .= '<div class="col-md-4">' . $sticky->renderInput($formConfig['phone'], 'mb-3') . '</div>';
    $html .= '<div class="col-md-4">' . $sticky->renderInput($formConfig['email'], 'mb-3') . '</div>';
    $html .= '<div class="col-md-4">' . $sticky->renderInput($formConfig['dob'], 'mb-3') . '</div>';
    $html .= '</div>';

    $html .= '<div class="row">';
    $html .= '<div class="col-md-12">' . $sticky->renderRadio($formConfig['age'], 'mb-3', 'horizontal') . '</div>';
    $html .= '</div>';

    $html .= '<div class="row">';
    $html .= '<div class="col-md-12">' . $sticky->renderCheckboxGroup($formConfig['contact'], 'mb-3', 'horizontal') . '</div>';
    $html .= '</div>';

    return $html;
}


$sticky = new StickyForm();
$pdo = new PdoMethods();

$formConfig = getContactFormConfig();
$message = '&nbsp;';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // rebuild fresh config then run validation
    $formConfig = getContactFormConfig();

    $formConfig = $sticky->validateForm($_POST, $formConfig);

    if (!empty($formConfig['age']['error'])) {
        $formConfig['age']['error'] = 'You must select an age range';
        $formConfig['masterStatus']['error'] = true;
    }

    if ($formConfig['masterStatus']['error'] === false && !$sticky->hasErrors()) {
        $contacts = '';
        if (isset($_POST['contact']) && is_array($_POST['contact'])) {
            $contacts = implode(',', $_POST['contact']);
        }

        $sql = "INSERT INTO contacts
                (fname, lname, address, city, state, zip, phone, email, dob, contacts, age)
                VALUES
                (:fname, :lname, :address, :city, :state, :zip, :phone, :email, :dob, :contacts, :age)";

        $bindings = [
            [':fname', $_POST['fname'], 'str'],
            [':lname', $_POST['lname'], 'str'],
            [':address', $_POST['address'], 'str'],
            [':city', $_POST['city'], 'str'],
            [':state', $_POST['state'], 'str'],
            [':zip', $_POST['zip'], 'str'],
            [':phone', $_POST['phone'], 'str'],
            [':email', $_POST['email'], 'str'],
            [':dob', $_POST['dob'], 'str'],
            [':contacts', $contacts, 'str'],
            [':age', isset($_POST['age']) ? $_POST['age'] : '', 'str'],
        ];

        $result = $pdo->otherBinded($sql, $bindings);

        if ($result === 'noerror') {
            $message = '<p style="color:green">Contact Information Added</p>';
            $formConfig = getContactFormConfig();
        } else {
            $message = '<p style="color:red">There was an error adding the record</p>';
        }
    }
}

$formHtml = renderContactForm($sticky, $formConfig);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Final Project</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>

<body class="container">
    <?php echo $nav; ?>

    <div class="container">
        <h1>Add Contact</h1>
        <p><?php echo $message; ?></p>

        <form method="post" action="">
            <?php echo $formHtml; ?>
            <input type="submit" class="btn btn-primary" value="Add Contact">
        </form>
    </div>
</body>
</html>

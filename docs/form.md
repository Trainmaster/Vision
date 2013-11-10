# Form

## Controls

* `Vision\Control\Button`
* `Vision\Control\Checkbox`
* `Vision\Control\Color`
* `Vision\Control\Date`
* `Vision\Control\DateTime`
* `Vision\Control\DateTimeLocal`
* `Vision\Control\Email`
* `Vision\Control\File`
* `Vision\Control\Hidden`
* `Vision\Control\Image`
* `Vision\Control\Month`
* `Vision\Control\Number`
* `Vision\Control\Password`
* `Vision\Control\Radio`
* `Vision\Control\Range`
* `Vision\Control\Reset`
* `Vision\Control\Search`
* `Vision\Control\Select`
* `Vision\Control\Submit`
* `Vision\Control\Tel`
* `Vision\Control\Text`
* `Vision\Control\Textarea`
* `Vision\Control\Time`
* `Vision\Control\Url`
* `Vision\Control\Week`

## Usage

### Create a basic form

```php
use Vision\Form\Form;
use Vision\Form\Control\Email;
use Vision\Form\Control\Hidden;
use Vision\Form\Control\Text;
use Vision\Form\Control\Submit;

class ContactForm extends Form
{
    public function __construct($name)
    {
        parent::__construct($name);

        $firstName = new Text('firstName');

        $lastName = new Text('lastName');

        $email = new Email('email');

        $submit = new Submit('submit');
        $submit->setValue('Send');

        $this->addElements(array($firstName, $lastName, $email, $submit));
    }
}

// input array (f.ex. $_POST or $_GET)
$data = array(
    'firstName' => 'Foo',
    'lastName' => 'Bar',
    'email' => 'foo@bar.com',
)

$form = new ContactForm('contact-form');
$form->bindData($data);

if ($form->isValid()) {
    // get validated values (after validators/filters were applied)
    print_r ($form->getValues());
} else {
    // get errors
    print_r ($form->getErrors());
}
```

### Render a form
```php
echo $form->start()
     . '<fieldset>'
     . $form->getElement('firstName')
     . $form->getElement('lastName')
     . $form->getElement('email')
     . $form->getElement('submit')
     . '</fieldset>'
     . $form->end();
```

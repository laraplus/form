# Laraplus form

This package is currently in active development. No stable release is available yet.

## Examples

### Usage in Blade

You can create a form on-the-fly in Blade:

```html
{!! Form::open('login')->action('/login')->method('post') !!}
{!! Form::text('username')->label('Username') !!}
{!! Form::password('password')->label('Password') !!}
{!! Form::submit('submit')->text('Login') !!}
{!! Form::close() !!}
```

### Usage in Form Requests

Use the FormBuilder trait:

```php
use Illuminate\Foundation\Http\FormRequest;
use Laraplus\Form\Helpers\FormBuilder;

class LoginForm extends FormRequest
{
    use FormBuilder;
    
    public function rules()
    {
        return [
            'username' => 'required',
            'password' => 'required|login' // login is a custom rule
        ];
    }
    
    public function authorize()
    {
        return true;
    }
    
    public function form()
    {
        $form = $this->getFormBuilder();
        
        $form->open('login')->action('/login')->method('post');
        $form->text('username')->label('Username');
        $form->password('password')->label('Password');
        $form->submit('submit')->text('Login');
        $form->close();
        
        return $form;
    }
}
```

In your controller you can then pass the form to the view. The form request will not be validated for GET actions:

```php
public function index(LoginForm $form)
{
    return view('login', ['form' => $form->form()]);
}
```

In your view, you can output the entire form at once:

```html
{!! $form !!}
```

Or field by field:

```html
{!! $form->open !!}
{!! $form->username !!}
{!! $form->password !!}
{!! $form->submit !!}
{!! $form->close !!}
```

When outputting a field an entire form-group will be returned, but you can further fine tune the result:

```html
{!! $form->open !!}

{!! $form->username->label() !!}
{!! $form->username->field() !!}
{!! $form->username->error() !!}

{!! $form->password->label() !!}
{!! $form->password->field() !!}
{!! $form->password->error() !!}


{!! $form->submit->addClass('btn-primary') !!}

{!! $form->close !!}
```

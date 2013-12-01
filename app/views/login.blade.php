
<!doctype html>

<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>uCatalog</title>
    </head>
<body>
    <div>
        <p>
        <?php if (Session::has('message')) {
            $message = Session::get('message');
            echo $message;
        }?>
        </p>
        
        <p> {{ Form::open(array('action' => 'AutenticazioneController@doLogin')) }}</p> 
            <p>{{ Form::label('email') }}</p>
            <p>{{ Form::text('email', Input::old('email'), array('placeholder' => 'mail@example.com')) }}</p>
            <p>{{ $errors->first('email') }}</p>
            <p>{{ Form::label('password') }}</p>
            <p>{{ Form::password('password') }}</p>
            <p>{{ $errors->first('password') }}</p>
            <p>{{ Form::submit('login') }}</p>
        <p>{{ Form::close() }}</p>
    </div>
</body>
</html>

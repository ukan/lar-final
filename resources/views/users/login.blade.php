@extends("layouts.application")

@section("content")

  {!! Form::open(['url' => '/signin', 'class' => 'form-horizontal', 'role' => 'form']) !!}

    <div class="form-group">
      {!! Form::label('email', 'Email', array('class' => 'col-lg-3 control-label')) !!}
      <div class="col-lg-4">
        {!! Form::text('email', null, array('class' => 'form-control')) !!}
        {!! $errors->first('email') !!}
      </div>
      <div class="clear"></div>
    </div>

    <div class="form-group">
      {!! Form::label('password', 'Password', array('class' => 'col-lg-3 control-label')) !!}
      <div class="col-lg-4">
        {!! Form::password('password', array('class' => 'form-control')) !!}
        {!! $errors->first('password') !!}
      </div>
      <div class="clear"></div>
    </div>

    <div class="form-group">
      {!! Form::label('remember', 'Remember Me', array('class' => 'col-lg-3 control-label')) !!}
      <div class="col-lg-4">
        {!! Form::checkbox('remember', null, array('class' => 'form-control')) !!}
        <br><i>{!! link_to('reset-password/', 'Forgot Password') !!}</i>
      </div>
      <div class="clear"></div>
    </div>

    <div class="form-group">
      <div class="col-lg-3"></div>
      <div class="col-lg-4">
        {!! Form::submit('Login', array('class' => 'btn btn-primary')) !!}
      </div>
      <div class="clear"></div>
    </div>
  {!! Form::close() !!}
@stop
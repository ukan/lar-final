@extends('layouts.application')
@section('content')

<div class="section">
	<div class="row">
		<div class="col s12">
			<a href="{{ URL::to('downloadExcel/pdf', $tampilkan->id) }}"><button class="btn btn-success pull-right">Download Excel</button></a>
			<h1>{{ $tampilkan->title }}</h1>

            <div class="divider"></div>
            
            <p>{!! $tampilkan->content !!}</p>
            <i>By {!! $tampilkan->writer !!}</i>
            
            <!-- insert comment -->
            {!! Form::open(['url' => 'comments/', 'class' => 'form-horizontal', 'role' => 'form']) !!}
			    <i style="visibility: hidden"> {!! Form::text('idArt', $tampilkan->id) !!}</i>
			  <!-- Comments Form -->
			  <div class="form-group">
			    {!! Form::label('comment', 'Comment', array('class' => 'col-lg-1 control-label')) !!}
			    <div class="col-lg-11">
			      {!! Form::textarea('comment', null, array('class' => 'form-control', 'rows' => 3)) !!}
			      {!! $errors->first('comment') !!}
			    </div>
			    <div class="clear"></div>
			  </div>

			  <!-- Submit -->
			  <div class="form-group">
			    <div class="col-lg-1"></div>
			    <div class="col-lg-9">
			      {!! Form::submit('Send', array('class' => 'btn btn-primary')) !!}
			    </div>
			    <div class="clear"></div>
			  </div>
			{!! Form::close() !!}

			<h4>Comments</h4>

			<!-- show comment -->
			@foreach($komen as $comment)
				<div class="media">
				    <div class="media-left">
				      <img src="../assets/img_icon/avatar.png" class="media-object" style="width:60px">
				    </div>
				    <div class="media-body">
				      <h4 class="media-heading">{!! $comment->user->username !!} - <i class="">{!! $comment->created_at !!}</i></h4>
				      <br><p>{!! $comment->comment !!}</p>
				    </div>
				</div>				
			@endforeach
		</div>
	</div>

	<!-- Left-aligned media object -->
</div>

@endsection
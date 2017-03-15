<!-- @foreach ($articles as $article)
  <div>
    <h1>{!!$article->title!!}</h1>
    <p>{!!$article->content!!}</p>
    <i>By {!!$article->writer!!}</i>
    <div>
      {!!link_to('articles/'.$article->id, 'Show', array('class' => 'btn btn-info'))!!}
      {!!link_to('articles/'.$article->id.'/edit', 'Edit', array('class' => 'btn btn-warning'))!!}
      {!!link_to('articles/'.$article->id, 'Delete', array('class' => 'btn btn-danger', 'method' => 'DELETE', "onclick" => "return confirm('are you sure?')"))!!}
      {!! Form::open(array('route' => array('articles.destroy', $article->id), 'method' => 'delete')) !!}
        {!! Form::submit('Delete', array('class' => 'btn btn-danger', "onclick" => "return confirm('are you sure?')")) !!}
      {!! Form::close() !!}
    </div>
  </div>
  @endforeach -->
  
  <br>
  <table class="t-list table-bordered table-striped" data-toolbar="#custom-toolbar" data-toggle="table">
  <thead>
    <tr>
      <th class="col-sm-1 text-center"><a id="id">ID<i id="ic-direction"></i></a></th>
      <th class="text-center">TITLE</th>
      <th class="col-sm-3 text-center">ACTION</th>
    </tr>
  </thead>
  <tbody>
    @foreach($articles as $article)
      <tr>
        <td class="text-center">{!! $article->id !!}</td>
        <td class="text-center">{!! $article->title !!}</td>
        <td>
          <a class="btn btn-info btn-xs" title="Show"
              href="articles/{{$article->id}}">
                <i class="glyphicon glyphicon-eye-open"></i> Show
          </a>
          <a class="btn btn-primary btn-xs" title="Edit"
              href="articles/{{$article->id}}/edit">
                <i class="glyphicon glyphicon-edit"></i> Edit
          </a>
          <a class="btn btn-danger btn-xs" title="Delete"
              href="{{ url('articles/delete', $article->id) }}" onclick="return confirm('Yakin mau hapus data ini sob?')">
                <i class="glyphicon glyphicon-trash"></i> Delete
          </a>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
<div>
  {!! $articles->render() !!}
</div>
@extends("layouts.application")
@section("content")

  <div class="section">
    <a href="{{ url('articles/create') }}" class="btn btn-primary">Write Article </a>
    <a href="{{ URL::to('downloadExcel/xlsx') }}"><button class="btn btn-success">Download Excel</button></a>    
    <div style="padding-top:10px;" class="row">
      <div class="col-md-15 search">
        <div class="col-md-3">
          <div class="input-group input-group-sm">
            <input type="text" class="form-control" id="keywords" placeholder="Keywords">
            <span class="input-group-btn">
            <button id="search" class="btn btn-info btn-flat" type="button">
              Go!
            </button>
            </span>
          </div>
          <!-- /input-group -->
        </div>
      </div>
     </div>
     <div id="articles-list">
      
 @foreach($datas as $data)

  <div class="row">
    <div class="col s12">

      <h1>{!! $data->title !!}</h1>

            <div class="divider"></div>
            
            <p>{!!substr($data->content,0,200)!!}...</p>      
            <i>By {!! $data->writer !!}</i>          
            <br>
            <a href="{{ url('articles', $data->id) }}"  class="btn btn-primary">Readmore</a>            
            <a href="{{ url('articles/edit', $data->id) }}" class="btn btn-primary">Edit </a>
            <a href="{{ url('articles/delete', $data->id) }}" onclick="return confirm('Yakin mau hapus data ini sob?')" class="btn btn-danger">Delete</a>
    </div>
  </div>
  @endforeach
     </div>
	
   
</div>


{{ $datas->render() }}
    <script>
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
        $('#search').on('click', function(){
          $.ajax({
            url : '/articles',
            type : 'GET',
            dataType : 'json',
            data : {
              'keywords' : $('#keywords').val()
            },
            success : function(data) {
              $('#articles-list').html(data['view']);
            },
            error : function(xhr, status) {
              console.log(xhr.error + " ERROR STATUS : " + status);
            },
            complete : function() {
              alreadyloading = false;
            }
          });
        });
    </script>
@stop
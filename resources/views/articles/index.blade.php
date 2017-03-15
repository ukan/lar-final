@extends("layouts.application")
@section("content")
  <div>
        <a href="articles/create" class="btn btn-success pull-right">
          <i class="glyphicon glyphicon-plus-sign"></i> Write Article
        </a>
  </div>

  <div class="row">
  <div class="col-lg-12" id="enrolls-list">
    <h1>Articles Data</h1>
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

    <table class="t-list table-bordered table-striped" data-toolbar="#custom-toolbar" data-toggle="table">
      <thead>
        <tr>
          <th class="col-sm-1 text-center"><a id="id">ID<i id="ic-direction"></i></a></th>
          <th class="text-center">TITLE</th>
          <th class="col-sm-3 text-center">ACTION</th>
        </tr>
      </thead>
      <tbody>
        @foreach($datas as $article)
          <tr>
            <td>{!! $article->id !!}</td>
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
    
  </div>
  <input id="direction" type="hidden" value="asc" />
</div>

<!-- start sorting method -->
<script>
$(document).ready(function() {
  $(document).on('click', '#id', function(e) {
    sort_articles();
    e.preventDefault();
  });
});
function sort_articles() {
  $('#id').on('click', function() {
    $.ajax({
      url : '/articles',
      typs : 'GET',
      dataType : 'json',
      data : {
        "direction" : $('#direction').val()
      },
      success : function(data) {
        $('#articles-list').html(data['view']);
        $('#direction').val(data['direction']);
        if(data['direction'] == 'asc') {
          $('#ic-direction').attr({class: "fa fa-arrow-up"});
        } else {
          $('#ic-direction').attr({class: "fa fa-arrow-down"});
        }
      },
      error : function(xhr, status, error) {
        console.log(xhr.error + "\n ERROR STATUS : " + status + "\n" + error);
      },
      complete : function() {
        alreadyloading = false;
      }
    });
  });
}
</script>
<!-- end sorting method -->

<!-- start Searching method -->
<script>
      /*$.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });*/
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
<!-- end Searching method -->
@stop
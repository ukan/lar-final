<!DOCTYPE html>
  <html>
    <head>
      <meta charset="utf-8">
      <meta httpequiv="XUACompatible" content="IE=edge">
      <title>Laravel Final</title>
      @include('includes.cssList')
    </head>
    <body style="padding-top:60px;">
      <!--bagian navigation-->
      @include('includes.head_nav')
      <!-- Bagian Content -->
      <div class="container clearfix">
        <div class="row row-offcanvas row-offcanvas-left ">
          <!--Bagian Kiri-->
          @include("includes.left_nav")

          <!--Bagian Kanan-->
          <div id="main-content" class="col-xs-12 col-sm-9 main pull-right">
            <div class="panel-body">
              @if (Session::has('error'))
                <div class="session-flash alert-danger">
                    {{Session::get('error')}}
                </div>
              @endif
              @if (Session::has('notice'))
                <div class="session-flash alert-info">
                    {{Session::get('notice')}}
                </div>
              @endif
              @yield("content")
            </div>
          </div>
        </div>
      </div>
      @include('includes.jsList')        
    </body>
  </html>

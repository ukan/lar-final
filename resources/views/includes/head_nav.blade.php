<div class="navbar navbar-fixed-top navbar-default" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <a href="#" class = "navbar-brand">Laravel Project</a>
      <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
      </div>
    </div>
    <div class="navbar-collapse collapse">
    <ul class="nav navbar-nav navbar-right">
      <li>{!! link_to('/', 'Home') !!}</li>
      @if (Sentinel::check())
        <li>{!! link_to('#', 'Galery') !!}</li>
        <li>{!! link_to('articles', 'Article') !!}</li>
      @else
        <li>{!! link_to('signup', 'Sign up') !!}</li>
      @endif
      
      @if (Sentinel::check())
        <li>{!! link_to('logout', 'Logout') !!}</li>
      @else
        <li>{!! link_to('login', 'Login') !!}</li>
      @endif
    </ul>
    </div>
  </div>
</div>
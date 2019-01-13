<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Tableau de bord</title>

        <!-- Bootstrap core CSS -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    </head>

    <body>
        <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
	        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">BMC Security</a>
	        <input class="form-control form-control-dark w-100" type="text" placeholder="Rechercher" aria-label="Search">
	        <ul class="navbar-nav px-3">
	            <a class="nav-link" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                            {{ __('Déconnexion') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                	@csrf
                </form>
	        </ul>
	    </nav>

	    <div class="container-fluid">
	        <div class="row">
	            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
	                <div class="sidebar-sticky">
	                    <ul class="nav flex-column">
	                        <li class="nav-item">
	                            <a class="nav-link{{ $pageCode === 'dashboard' ? ' active' : '' }}" href="{{ route('dashboard') }}">
	                                <span data-feather="home"></span>Tableau de bord
	                            </a>
	                        </li>
	                        
	                        <li class="nav-item">
	                            <a class="nav-link{{ $pageCode === 'device' ? ' active' : '' }}" href="{{ route('dashboard-device') }}">
	                                <span data-feather="box"></span>Dispositifs
	                            </a>
	                        </li>
	                        
	                        <li class="nav-item">
	                            <a class="nav-link{{ $pageCode === 'vehicle' ? ' active' : '' }}" href="{{ route('dashboard-vehicle') }}">
	                                <span data-feather="truck"></span>Véhicules
	                            </a>
	                        </li>
	                        
	                        <li class="nav-item">
	                            <a class="nav-link{{ $pageCode === 'activity' ? ' active' : '' }}" href="{{ route('dashboard-activity') }}">
	                                <span data-feather="activity"></span>Activité
	                            </a>
	                        </li>
	                        
	                        <li class="nav-item">
	                            <a class="nav-link{{ $pageCode === 'photo' ? ' active' : '' }}" href="{{ route('dashboard-photo') }}">
	                                <span data-feather="camera"></span>Photos
	                            </a>
	                        </li>
	                    </ul>
	                </div>
	            </nav>

	        	<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
		            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
		                <h2>{{ $pageTitle }}</h2>
		            </div>

		            @yield('content')
	        	</main>
	     	</div>
		</div>

	    <!-- Bootstrap core JavaScript
	    ================================================== -->
	    <!-- Placed at the end of the document so the pages load faster -->
	    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

	    <!-- Icons -->
	    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
	    <script>
	      feather.replace()
	    </script>
	</body>
</html>

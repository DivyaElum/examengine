	@section('header')
		@include('partials._header')
	@show

	@yield('content')
	
	@section('footer')
		@include('partials._footer')
	@show
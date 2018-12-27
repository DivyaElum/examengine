	@section('header')
		@include('front.partials._header')
	@show
	
	@yield('content')

	@section('footer')
		@include('front.partials._footer')
	@show
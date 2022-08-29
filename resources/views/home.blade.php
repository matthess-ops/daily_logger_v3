@extends('web.layout.navbar')

@section('content')
<div class="container">
   <h3>home page</h3>
   {{Auth::user()}}

</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
	@foreach($products as $product)
	@if($loop->index % 4 ==0)
		<div class="row">
	@endif
	<div class="col-md-3  panel panel-default">{{$product->title}}</div>
	@if($loop->index % 4 ==3)
		</div>
	@endif
@endforeach
</div>
<div class="text-center">
        {{ $products->links() }}
</div>

@endsection

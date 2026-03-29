@extends('layouts.app')

@section('content')
<div class="py-12">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
      <div class="p-6 text-gray-900">
        <h1 class="text-3xl font-bold mb-6">Coffee Shop Products (Nongki)</h1>
        @if($products->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          @foreach($products as $product)
          <div class="bg-gray-50 p-6 rounded-lg shadow">
            <h3 class="text-xl font-semibold">{{ $product->name }}</h3>
            <p>{{ $product->description }}</p>
            <p class="text-2xl font-bold text-green-600">Rp {{ number_format($product->price) }}</p>
            <p>Stock: {{ $product->stock }}</p>
          </div>
          @endforeach
        </div>
        @else
        <p>No products available. Run php artisan db:seed to populate.</p>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
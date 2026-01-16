@extends('layout.app')

@section('content')
    <div class="flex justify-between items-center mb-5">
        <h1 class="text-2xl font-bold">Top Brands Around You Available Till Year End</h1>
        <b>
            Explore the top brands from around the world. Click on a brand to view more details, or use the search bar to
            find specific brands.
            Discover exclusive offers and promotions available only for a limited time. Each brand card provides essential
            information to help you make informed choices.
        </b>
        <div class="w-full flex justify-center my-6">
            <br>
            <a id="add-brand-btn" href="{{ url('/brands/create') }}" class="add-brand-btn hidden">Add Brand +</a>
            <br>
        </div>
    </div>

    <div class="my-5">
        <br>
        @include('components.search-bar')
    </div>

    <div id="brand-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-3">
        <!-- Brand cards will be inserted here by JS -->
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/brands/index.js') }}"></script>
@endpush

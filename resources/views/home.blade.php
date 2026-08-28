@extends('layouts.app')
@section('title', 'Welcome')

@section('content')
    @include('partials.hero')
    @include('partials.features')
    @include('partials.how-it-works')
    @include('partials.testimonials')
    @include('partials.footer')
    @include('partials.modals')
@endsection

@push('scripts')
<script>
    @if($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            openModal('loginModal');
        });
    @endif
</script>
@endpush
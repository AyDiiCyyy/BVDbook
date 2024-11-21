@extends('client.layouts')

@section('title', 'Liên hệ với chúng tôi')

@section('content')
    <div class="container">
        <h2>Liên hệ với chúng tôi</h2>

        <!-- Bao gồm phần contact từ partials/client -->
        @include('client.partials.lienhe')
    </div>
@endsection

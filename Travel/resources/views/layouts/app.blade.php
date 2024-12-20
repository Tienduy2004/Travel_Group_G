<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>TRAVELER - Free Travel Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link href="{{asset('img/favicon.ico')}}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{asset ('lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css')}}" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.css" rel="stylesheet">
    


    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset ('css/style.css') }}" rel="stylesheet">
    <link href="{{asset ('css/profile.css') }}" rel="stylesheet">
    <link href="{{asset ('css/detail.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tailwind/tailwind.min.css') }}" rel="stylesheet">
    <link href="{{asset ('css/khuyenmai.css') }}" rel="stylesheet">
    <link href="{{asset ('css/danhsachkhuyenmai.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('css/tours.css') }}" rel="stylesheet"> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
   


    <!-- Livewire Styles -->
    {{-- @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    
    
 
    
</head>

<body>
    @include('includes.header')
    @yield('content')
    @include('includes.footer')
    
    <!-- Livewire Scripts -->
    {{-- @livewireScripts --}}

    
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>
<script src="{{ asset('js/create_post.js') }}"></script>

</body>

</html>


<!DOCTYPE html>
<html lang="en">

<head>

    @include('layout.backend.components.guest.head')

</head>

<body class="">

    <div class="main-wrapper" style="background-image: url({{ asset('assets/backend/img/login.jpg') }}); background-repeat: no-repeat; background-size: cover;">

        <section class="main main-wrapper">
            @yield('content')
        </section>

        @include('layout.backend.components.guest.script')

    </div>

</body>

</html>

@props(['bodyClass' => 'g-sidenav-show bg-gray-200 full-height'])

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets') }}/img/favicon-BD.png">
    <link rel="icon" type="image/png" href="{{ asset('assets') }}/img/favicon-BD.png">
    <title>DBMS</title>

    <!-- Fonts and Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <link href="{{ asset('assets') }}/css/nucleo-icons.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/nucleo-svg.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous" defer></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

    <!-- Main CSS -->
    <link id="pagestyle" href="{{ asset('assets') }}/css/material-dashboard.css?v=3.0.0" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />

    <!-- Inline Styles -->
    <style>
        .full-height {
            height: 100vh;
        }

        .botts {
            position: absolute;
            width: 100%;
        }

        .botdash {
            position: absolute;
            bottom: 0;
            width: 100%;
        }
    </style>

    @stack('styles')
</head>

<body class="{{ $bodyClass }}">

    {{ $slot }}

    <!-- Core JS -->
    <script src="{{ asset('assets') }}/js/core/popper.min.js" defer></script>
    <script src="{{ asset('assets') }}/js/core/bootstrap.min.js" defer></script>
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js" defer></script>
    <script src="{{ asset('assets') }}/js/plugins/smooth-scrollbar.min.js" defer></script>

    <!-- Material Dashboard JS -->
    <script src="{{ asset('assets') }}/js/material-dashboard.min.js?v=3.0.0" defer></script>

    <!-- Build Assets -->
    <script src="{{ asset('build/assets/app-BISr5N8G.css') }}" defer></script>
    <script src="{{ asset('build/assets/app-DCrXoRMQ.js') }}" defer></script>
    <script src="{{ asset('build/assets/app-g6dgYUiZ.css') }}" defer></script>
    <script src="{{ asset('build/assets/app-DXvZ2WrF.css') }}" defer></script>
    <script src="{{ asset('build/assets/app-Ke9dhrTl.css') }}" defer></script>
    <script src="{{ asset('build/assets/main-B_SY1GJM.css') }}" defer></script>

    <!-- Vite Assets -->
    @vite(['resources/js/app.js', 'resources/css/main.css'])

    @stack('js')
    @stack('scripts')

    <!-- Scrollbar Initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            var win = navigator.platform.indexOf('Win') > -1;
            var scrollbarElement = document.querySelector('#sidenav-scrollbar');
            if (win && scrollbarElement) {
                Scrollbar.init(scrollbarElement, { damping: '0.5' });
            }
        });
    </script>

    <!-- Github Buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>

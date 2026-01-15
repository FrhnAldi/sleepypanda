<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Sleepy Panda</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #20223F;
            color: #ffffff;
            overflow-x: hidden;
        }

         html,
        body {
            scroll-behavior: smooth;
            overflow-y: auto;
            overflow-x: hidden;
        }

        body::-webkit-scrollbar {
            display: none;
        }

        .container {
            padding: 40px;
            max-width: 1600px;
            margin: 0 auto;
        }

        @media (max-width: 1200px) {
            .container {
                padding: 30px;
            }
        }

        @media (max-width: 640px) {
            .container {
                padding: 20px;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    @include('components.header')

    <div class="container">
        @yield('content')
    </div>

</div> <!-- Close main-content wrapper from header -->

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

@yield('scripts')
</body>
</html>
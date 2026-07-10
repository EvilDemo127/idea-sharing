<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

        @routes
        @vite(['resources/css/app.css', 'resources/js/app.js'])

  
        <x-inertia::head />
    </head>
    <body>
        <x-inertia::app />

    </body>
</html>
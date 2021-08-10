<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Product Management System</title>

        <link rel="stylesheet" href="/css/app.css">

        <script>

            (function (){
                window.Laravel = {
                    csrfToken: '{{ csrf_token() }}'
                };
            })();
        
        </script>
    
    </head>
    <body class="antialiased">
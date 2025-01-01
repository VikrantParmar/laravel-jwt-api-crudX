<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 5px;
            overflow: hidden;
            color:#0A0F24;
        }
        .header {
            background-color: #0A0F24;
            padding: 20px;
            text-align: center;
            color: #FAE3CF;
        }
        .body {
            padding: 20px;
        }
        .footer {
            padding: 20px;
            text-align: center;
            background-color: #f4f4f4;
            color: #777;
            font-size: 12px;
        }
        .button {
            display: inline-block;
            padding: 12px 20px;
            margin: 20px 0;
            background-color: #0A0F24;
            color: #FAE3CF !important;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }
        @media only screen and (max-width: 600px) {
            .body {
                padding: 10px;
            }
            .button {
                width: 100%;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Header -->
    <div class="header">
        @include('emails.layouts.header')
    </div>

    <!-- Body -->
    <div class="body">
        @yield('content')
    </div>

    <!-- Footer -->
    <div class="footer">
        @include('emails.layouts.footer')
    </div>
</div>
</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DASHMIN - Welcome</title>
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <!-- Customized Bootstrap Stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #009CFF;
            --light: #F3F6F9;
            --dark: #191C24;
        }
        body {
            background-color: var(--light);
            font-family: 'Heebo', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .welcome-card {
            background: #fff;
            padding: 3rem;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="welcome-card">
        <h1 class="text-primary mb-4"><i class="fa fa-hashtag me-2"></i>DASHMIN</h1>
        <h2 class="mb-4">Modern Laravel Admin Panel</h2>
        <p class="text-muted mb-4">A powerful and responsive admin dashboard built with Laravel, Blade, and Bootstrap.</p>
        
        <div class="d-grid gap-2 d-md-block">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-lg px-4 me-md-2">Go to Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-4 me-md-2">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg px-4">Register</a>
                    @endif
                @endauth
            @endif
        </div>
    </div>
</body>
</html>

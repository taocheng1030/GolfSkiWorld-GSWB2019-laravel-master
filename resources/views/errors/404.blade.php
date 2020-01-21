<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body class="error-page">
    <div class="container">
        <main class="error-container">
            <h1 class="error-code">404</h1>
            <p class="error-info">
                @if($exception->getMessage()) {{ $exception->getMessage() }}
                @else Opps, it seems that this page does not exist.
                @endif
            </p>
            <a href="{{ url('/') }}" class="btn btn-inverse">
                Go back to panel
            </a>
        </main>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>JME Traffic Solutions</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }
        .container-fluid {
            height: 100vh;
            display: flex;
            align-items: center;
            padding: 0;
        }
        .left-section {
            background-color: #ffffff;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 50px;
            position: relative;
        }
        .right-section {
            background-image: url('/images/image2.png');
            background-size: cover;
            background-position: center;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .right-section img {
            max-width: 100%;
            height: auto;
        }
        h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            line-height: 1.2;
        }
        p {
            font-size: 1rem;
            color: #666;
            margin: 20px 0;
        }
        .btn {
            padding: 10px 30px;
            font-size: 1rem;
            margin-right: 15px;
            border-radius: 25px;
            text-transform: uppercase;
            font-weight: 500;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-outline-primary {
            border-color: #007bff;
            color: #007bff;
        }
        .btn-primary:hover, .btn-outline-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
            color: white;
        }
        .form-label {
            font-weight: 500;
        }
        .form-control {
            border-radius: 10px;
        }
        .form-check {
            text-align: left;
            margin: 15px 0;
        }
        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 5px;
        }
        .success-message {
            color: #28a745;
            font-size: 0.875rem;
            margin-bottom: 20px;
            background-color: #e6f4ea;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }
        .loading-container {
            display: none;
            text-align: center;
            margin-top: 20px;
        }
        .spinner-border {
            width: 2rem;
            height: 2rem;
            margin-right: 10px;
        }
        .loading-text {
            font-size: 1rem;
            color: #007bff;
            font-weight: 500;
        }
        .validation-errors {
            display: none;
            color: #dc3545;
            font-size: 0.875rem;
            margin-bottom: 15px;
            background-color: #f8d7da;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="col-md-6 left-section">
            @if (session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="error-message">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <h1>JME Traffic Solutions – A Vehicle Violation Monitoring System</h1>
            <p>Enhancing road safety by detecting and reporting violations in real-time, reducing manual enforcement.</p>
            <div>
                <a href="{{ route('register') }}" class="btn btn-primary">Sign Up</a>
                <a href="{{ route('login') }}" class="btn btn-outline-primary">Log In</a>
            </div>
        </div>
        <div class="col-md-6 right-section">
            <img src="{{ asset('/images/image1.png') }}" alt="Car">
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
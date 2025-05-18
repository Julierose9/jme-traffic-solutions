<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign Up - JME Traffic Solutions</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa; /* Light background for better contrast */
        }
        .container-fluid {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0;
        }
        .modal-content {
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            width: 90%;
            max-width: 700px; /* Wider for two columns */
        }
        .modal-header, .modal-footer {
            border: none;
        }
        .modal-header {
            padding: 1rem;
            border-bottom: 1px solid #dee2e6;
            background-color: #007bff; /* Header background color */
            color: white; /* Header text color */
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
        .modal-title {
            font-size: 1.5rem;
            font-weight: 600;
        }
        .btn-close {
            filter: invert(1); /* White close button */
        }
        .modal-body {
            padding: 20px;
        }
        .form-label {
            font-weight: 600;
            color: #495057;
        }
        .form-control {
            border-radius: 8px;
            padding: 0.375rem 0.75rem;
            font-size: 0.9rem;
            line-height: 1.5;
            border: 1px solid #ced4da;
            transition: border-color 0.3s;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        .form-control.is-invalid {
            border-color: #dc3545;
        }
        .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875rem;
            color: #dc3545;
        }
        .form-control.is-invalid ~ .invalid-feedback {
            display: block;
        }
        .form-check {
            text-align: left;
            margin: 10px 0;
        }
        .form-check-input {
            margin-top: 0.3rem;
            margin-left: -1.5rem;
        }
        .form-check-label {
            margin-left: 1.5rem;
        }
        .btn {
            padding: 10px 20px;
            font-size: 0.9rem;
            border-radius: 20px;
            text-transform: uppercase;
            font-weight: 600;
            background-color: #007bff; /* Button background color */
            color: white; /* Button text color */
            border: none; /* Remove border */
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
        .validation-errors {
            color: #dc3545;
            font-size: 1rem;
            font-weight: 500;
            margin-bottom: 15px;
            background-color: #f8d7da;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #dc3545;
            box-shadow: 0 2px 10px rgba(220, 53, 69, 0.1);
        }
        .success-message {
            color: #28a745;
            font-size: 1rem;
            font-weight: 500;
            margin-bottom: 15px;
            background-color: #d4edda;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #28a745;
            box-shadow: 0 2px 10px rgba(40, 167, 69, 0.1);
        }
        .password-strength {
            margin-top: 5px;
            font-size: 0.875rem;
        }
        .password-strength.weak {
            color: #dc3545;
        }
        .password-strength.medium {
            color: #ffc107;
        }
        .password-strength.strong {
            color: #28a745;
        }
    </style>
</head>
<body>
    <div class="container-fluid d-flex justify-content-center align-items-center">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sign Up</h5>
                <a href="{{ route('welcome') }}" class="btn-close" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                @if (session('success'))
                    <div class="success-message">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="validation-errors">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="signupForm" method="POST" action="{{ route('register.submit') }}" novalidate>
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                                <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" required>
                                    <option value="" disabled selected>Select Role</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="officer" {{ old('role') == 'officer' ? 'selected' : '' }}>Officer</option>
                                    <option value="guest" {{ old('role') == 'guest' ? 'selected' : '' }}>Guest</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="fname" class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('fname') is-invalid @enderror" id="fname" name="fname" value="{{ old('fname') }}" required>
                                @error('fname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="mname" class="form-label">Middle Name</label>
                                <input type="text" class="form-control @error('mname') is-invalid @enderror" id="mname" name="mname" value="{{ old('mname') }}">
                                @error('mname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="lname" class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('lname') is-invalid @enderror" id="lname" name="lname" value="{{ old('lname') }}" required>
                                @error('lname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div id="officerFields" style="display: none;">
                                <div class="mb-3">
                                    <label for="rank" class="form-label">Rank <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('rank') is-invalid @enderror" id="rank" name="rank" value="{{ old('rank') }}">
                                    @error('rank')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="contact_num" class="form-label">Contact Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('contact_num') is-invalid @enderror" id="contact_num" name="contact_num" value="{{ old('contact_num') }}">
                                    @error('contact_num')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}" required>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                                <div id="passwordStrength" class="password-strength"></div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" required>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                </form>
                <p class="mt-3 text-center">Already have an account? <a href="{{ route('login') }}">Log In</a></p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#password').on('input', function() {
                const password = $(this).val();
                const strength = checkPasswordStrength(password);
                $('# passwordStrength').text(strength.text).removeClass('weak medium strong').addClass(strength.class);
            });

            function checkPasswordStrength(password) {
                if (password.length < 6) {
                    return { text: 'Weak (minimum 6 characters)', class: 'weak' };
                } else if (password.length < 10) {
                    return { text: 'Medium', class: 'medium' };
                }
                return { text: 'Strong', class: 'strong' };
            }
        });

        document.getElementById('role').addEventListener('change', function() {
            const officerFields = document.getElementById('officerFields');
            if (this.value === 'officer') {
                officerFields.style.display = 'block';
                document.getElementById('rank').required = true;
                document.getElementById('contact_num').required = true;
            } else {
                officerFields.style.display = 'none';
                document.getElementById('rank').required = false;
                document.getElementById('contact_num').required = false;
            }
        });

        // Show/hide fields on page load if role is pre-selected
        window.addEventListener('load', function() {
            const roleSelect = document.getElementById('role');
            if (roleSelect.value === 'officer') {
                document.getElementById('officerFields').style.display = 'block';
                document.getElementById('rank').required = true;
                document.getElementById('contact_num').required = true;
            }
        });
    </script>
</body>
</html>
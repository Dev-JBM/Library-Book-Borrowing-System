<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #0f4c81;
            --bg-gradient: linear-gradient(135deg, #0f4c81, #1e90ff);
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-gradient);
            font-family: "Poppins", sans-serif;
        }

        /* Glassmorphism */
        .glass-card {
            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 18px;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            animation: fadeIn 0.8s ease-out;
        }

        /* Heading animation */
        .card-title {
            animation: slideDown 0.7s ease forwards;
            opacity: 0;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-14px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(.96);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Inputs */
        input.form-control {
            border-radius: 10px;
            height: 46px;
            transition: 0.3s;
        }

        input.form-control:hover {
            transform: scale(1.02);
            box-shadow: 0 0 0 4px rgba(15, 76, 129, 0.1);
        }

        /* Button */
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            border-radius: 12px;
            height: 48px;
            font-weight: 500;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background-color: #0c3f6c;
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(15, 76, 129, 0.35);
        }

        a {
            color: #fff;
        }

        /* Floating card effect */
        .floating {
            animation: float 3.5s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-8px);
            }
            100% {
                transform: translateY(0px);
            }
        }
    </style>
</head>

<body>

    <div class="container floating">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="glass-card">

                    <h3 class="card-title mb-4 text-center text-white fw-semibold">Create an Account</h3>

                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ url('/register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label text-white">Full Name</label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name') }}"
                                   required autofocus>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label text-white">Email Address</label>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label text-white">Password</label>
                            <input type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   id="password"
                                   name="password"
                                   required>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label text-white">Confirm Password</label>
                            <input type="password"
                                   class="form-control"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   required>
                        </div>

                        <div class="mb-3 form-check text-white">
                            <input type="checkbox" class="form-check-input" id="show_password_toggle">
                            <label class="form-check-label" for="show_password_toggle">Show password</label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </form>

                    <hr class="border-light">

                    <p class="text-center text-white mb-0">
                        Already have an account?
                        <a href="{{ url('/login') }}" class="fw-bold">Login</a>
                    </p>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('show_password_toggle')?.addEventListener('change', function () {
            const p = document.getElementById('password');
            const pc = document.getElementById('password_confirmation');

            p.type = this.checked ? 'text' : 'password';
            pc.type = this.checked ? 'text' : 'password';
        });
    </script>

</body>
</html>

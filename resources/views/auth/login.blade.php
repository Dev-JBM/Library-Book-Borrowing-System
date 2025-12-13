<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #62B6FF;            /* Light blue */
            --primary-dark: #3A8FD1;       /* Hover shade */
            --bg-light: #F1F5F9;           /* Soft gray */
            --card-bg: rgba(255, 255, 255, 0.28);
            --border-light: rgba(255, 255, 255, 0.4);
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-light);
            background: linear-gradient(135deg, #E3F2FF, #F1F5F9);
            font-family: "Poppins", sans-serif;
        }

        /* Glassmorphism card */
        .glass-card {
            background: var(--card-bg);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-radius: 18px;
            padding: 30px;
            border: 1px solid var(--border-light);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
            animation: fadeIn 0.8s ease-out;
        }

        /* Heading animation */
        .card-title {
            animation: slideDown 0.7s ease forwards;
            opacity: 0;
            color: #1E293B;
            font-weight: 600;
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
            border: 1px solid #d0d7df;
        }

        input.form-control:hover {
            transform: scale(1.02);
            box-shadow: 0 0 0 4px rgba(98, 182, 255, 0.25);
        }

        input.form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(98, 182, 255, 0.4);
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
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(98, 182, 255, 0.4);
        }

        a {
            color: var(--primary-dark);
            font-weight: 500;
            transition: 0.2s;
        }

        a:hover {
            color: var(--primary);
        }

        /* Floating subtle animation */
        .floating {
            animation: float 3.5s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>

<body>

    <div class="container floating">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="glass-card">

                    <h3 class="card-title mb-4 text-center">Welcome Back</h3>

                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ url('/login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label text-dark">Email</label>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required autofocus>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label text-dark">Password</label>
                            <input type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   id="password"
                                   name="password"
                                   required>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check text-dark">
                            <input type="checkbox" class="form-check-input" id="show_password_toggle">
                            <label class="form-check-label" for="show_password_toggle">Show password</label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>

                    <hr>

                    <p class="text-center text-dark mb-0">
                        Don't have an account?
                        <a href="{{ url('/register') }}">Register</a>
                    </p>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('show_password_toggle')?.addEventListener('change', function () {
            const pass = document.getElementById('password');
            pass.type = this.checked ? 'text' : 'password';
        });
    </script>

</body>

</html>

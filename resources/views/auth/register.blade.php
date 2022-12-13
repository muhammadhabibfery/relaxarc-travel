<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Assistant:wght@200;300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <style>
        html,
        body {
            background-image: url('http://getwallpapers.com/wallpaper/full/5/b/1/162593.jpg#.YDdC40uB1yY.link');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            height: 100%;
            font-family: "Assistant", sans-serif;

        }

        .container {
            height: 100%;
            align-content: center;
        }

        .card {
            height: 520px;
            margin-top: auto;
            margin-bottom: auto;
            width: 400px;
            background-color: rgba(0, 0, 0, 0.5) !important;
        }

        .social_icon span {
            font-size: 60px;
            margin-left: 10px;
            color: #FFC312;
        }

        .social_icon span:hover {
            color: white;
            cursor: pointer;
        }

        .card-header h3 {
            color: white;
        }

        .social_icon {
            position: absolute;
            right: 20px;
            top: -45px;
        }

        .input-group-prepend label {
            width: 50px;
            background-color: #FFC312;
            color: black;
            border: 0 !important;
        }

        input:focus {
            outline: 0 0 0 0 !important;
            box-shadow: 0 0 0 0 !important;

        }

        .login_btn {
            color: black;
            font-weight: bold;
            background-color: #FFC312;
            width: 155px;
        }

        .login_btn:hover {
            color: black;
            background-color: white;
        }

        .links {
            color: white;
        }

        .links a {
            margin-left: 4px;
        }

        .card-footer .links a {
            color: #FFC312;
        }

        .card-footer .links a:hover {
            color: #ff9e53;
        }

        .card-footer .links-terms a {
            color: #b1b1b1;
            text-shadow: 0 0 0.3px #fff;

        }

        .card-footer .links-terms a:hover {
            text-decoration: none;
            cursor: default;
        }

        .card-footer .links-terms .terms-text {
            text-decoration: underline;
            color: #fff;
        }

        .card-footer .links-terms .terms-text:hover {
            cursor: pointer;
            font-style: italic;
        }

        .error-background {
            background-color: #fff;
            padding: 2px;
        }
    </style>

    <title>{{ __('RelaxArc Register') }}</title>
</head>

<body>
    <div class="container">
        <div class="d-flex justify-content-center h-100">
            <div class="card">
                <div class="card-header">
                    <h3>{{ __('Register') }}</h3>
                    <div class="d-flex justify-content-end social_icon">
                        <span><i class="fab fa-facebook-square"></i></span>
                        <span><i class="fab fa-google-plus-square"></i></span>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('register') }}" method="POST" id="myfr">
                        @csrf
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="name"><i class="fas fa-user"></i></label>
                            </div>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror" placeholder="{{ __('Name') }}"
                                id="name">
                            @error('name')
                            <span class="invalid-feedback error-background" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="username"><i class="fas fa-user-edit"></i></label>
                            </div>
                            <input type="text" name="username"
                                class="form-control @error('username') is-invalid @enderror" id="username"
                                value="{{ old('username') }}" placeholder="Username">
                            @error('username')
                            <span class="invalid-feedback error-background" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="email"><i class="fas fa-envelope"></i></label>
                            </div>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="{{ __('Email') }}" id="email">
                            @error('email')
                            <span class="invalid-feedback error-background" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="password"><i class="fas fa-key"></i></label>
                            </div>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="{{ __('Password') }}" id="password">
                            @error('password')
                            <span class="invalid-feedback error-background" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="password_confirmation"><i
                                        class="fas fa-key"></i></label>
                            </div>
                            <input type="password" name="password_confirmation"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                placeholder="{{ __('Password Confimation') }}" id="password_confirmation">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn float-right login_btn" id="btnfr">{{ __('Register')
                                }}</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-center links">
                        {{ __('Already have an account?') }}<a href="{{ route('login') }}">{{ __('Login') }}</a>
                    </div>
                    <div class="d-flex justify-content-center text-center links-terms">
                        <!-- Dengan mendaftar anda setuju dengan syarat dan ketentuan kami -->
                        <a href="{{ route('terms-conditions') }}">{{ __('By registering you agree with') }} &nbsp;<span
                                class="terms-text">{{ __('our terms and conditions') }}</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('assets/frontend/libraries/jquery/jquery-3.3.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>

    <!-- Font Awesome library -->
    <script src="https://kit.fontawesome.com/efd43ec33f.js" crossorigin="anonymous"></script>

    <script>
        document.addEventListener('click', function(e){
            if(e.target.id == 'btnfr'){
                const form = document.querySelector('#myfr');
                form.addEventListener('submit', function(ev){
                    const btn = document.querySelector('#btnfr');
                    btn.innerHTML = "{{ __('Please Wait ...') }}";
                    btn.style.fontWeight = 'bold';
                    btn.style.color = 'black';
                    btn.style.cursor = 'not-allowed';
                    btn.setAttribute('disable', 'disable');
                    return true;
                });
            }
        });
    </script>

    <script>
        const inputNameElement = document.querySelector('#name');
        const inputUsernameElement = document.querySelector('#username');

        inputNameElement.addEventListener('change', function(){
            const inputNameValue = inputNameElement.value;

            fetch("{{ route('users.generate-username') }}", {
                method: 'POST',
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-Token": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    "name": inputNameValue
                })
            })
            .then(response => response.json())
            .then(data => inputUsernameElement.value = data.username)
            .catch(error => {
                alert("500 internal server error, {{ __('Refresh the page') }}");
                location.reload();
            });
        });
    </script>

</body>

</html>

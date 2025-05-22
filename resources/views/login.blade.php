<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BERR | LOGIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{asset('/public/images/icons/icon-2.webp')}}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="{{asset('public/css/loginPage.css')}}">
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <h1>Create Account</h1>

                <input type="text" name="name" placeholder="Name" value="{{ old('name') }}">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <input type="email" name="email" placeholder="Email" autocomplete="username" value="{{ old('email') }}">
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <input type="tel" name="mobileNumber" placeholder="Mobile Number" autocomplete="tel"
                    value="{{ old('phone') }}">
                @error('mobileNumber')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <input type="password" name="password" placeholder="Password" autocomplete="new-password">
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <input type="password" name="password_confirmation" placeholder="Confirm Password"
                    autocomplete="new-password">
                <input type="hidden" name="_form" value="signup">

                <button type="submit">Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <h1>Sign in</h1>

                <input type="email" name="email" placeholder="Email" autocomplete="username" value="{{ old('email') }}">
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <input type="password" name="password" placeholder="Password" autocomplete="current-password">
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <input type="hidden" name="_form" value="signin">

                <a href="#">Forgot your password?</a>
                <button type="submit">Sign In</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                    <button class="ghost mt-1 backHomeBtn">Back to Home</button>

                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Enter your personal details and start journey with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                    <button class="ghost mt-1 backHomeBtn">Back to Home</button>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.3.1/js/dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('.backHomeBtn').on('click', function () {
            window.location.href = "{{ route('home') }}";
        });

        const container = $('#container');

        $('#signUp').on('click', function () {
            container.addClass('right-panel-active');
        });

        $('#signIn').on('click', function () {
            container.removeClass('right-panel-active');
        });

        @if(old('_form') === 'signup')
            container.addClass('right-panel-active');
        @else
            container.removeClass('right-panel-active');
        @endif

        $('#signUp, #signIn').on('click', function () {
            $('.text-danger').text(''); // Clear the error message text
        });
    });
</script>

</html>
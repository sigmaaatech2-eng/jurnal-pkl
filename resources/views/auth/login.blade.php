<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Jurnal PKL Digital</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="w-full max-w-md rounded-xl bg-white p-8 shadow-lg">

            <h1 class="mb-6 text-center text-2xl font-bold">
                Login Jurnal PKL Digital
            </h1>

            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-100 p-3 text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.attempt') }}">
                @csrf

                <div class="mb-4">
                    <label class="mb-2 block">Email</label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="w-full rounded-lg border px-4 py-2"
                    >
                </div>

                <div class="mb-6">
                    <label class="mb-2 block">Password</label>

                    <input
                        type="password"
                        name="password"
                        required
                        class="w-full rounded-lg border px-4 py-2"
                    >
                </div>

                <button
                    type="submit"
                    class="w-full rounded-lg bg-blue-600 py-2 text-white"
                >
                    Login
                </button>
            </form>

            <p class="mt-6 text-center text-sm">
                Belum punya akun?

                <a
                    href="{{ route('register') }}"
                    class="text-blue-600"
                >
                    Daftar
                </a>
            </p>

        </div>
    </div>

</body>
</html>
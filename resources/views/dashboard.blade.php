<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - Jurnal PKL Digital</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    <div class="min-h-screen p-8">
        <div class="mx-auto max-w-4xl">

            <h1 class="text-3xl font-bold">
                Dashboard Jurnal PKL Digital
            </h1>

            <div class="mt-6 rounded-xl bg-white p-6 shadow">

                <h2 class="text-xl font-semibold">
                    Selamat datang, {{ auth()->user()->name }}
                </h2>

                <div class="mt-4">
                    <p>
                        <strong>Email:</strong>
                        {{ auth()->user()->email }}
                    </p>

                    <p class="mt-2">
                        <strong>Role:</strong>
                        {{ auth()->user()->getRoleNames()->first() ?? 'Belum memiliki role' }}
                    </p>
                </div>

            </div>
            <form method="POST" action="{{ route('logout') }}" class="mt-6">
    @csrf

    <button
        type="submit"
        class="rounded-lg bg-red-600 px-4 py-2 text-white"
    >
        Logout
    </button>
</form>

        </div>
    </div>

</body>
</html>
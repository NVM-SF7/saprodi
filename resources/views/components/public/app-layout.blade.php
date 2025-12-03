<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Usaha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/guest/app.css') }}">
    <link rel="icon" href="{{ asset('images/welcome/Logo-removebg-preview.png') }}" type="image/x-icon">
    @stack('style')

</head>

<body>

    <x-public.nav></x-public.nav>

    <div class="wrapper">
        {{ $slot }}
    </div>

    <x-public.footer></x-public.footer>

    @stack('script')
</body>

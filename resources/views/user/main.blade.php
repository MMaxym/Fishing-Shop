<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Welcome</title>
</head>

<body>
<h1>Головна сторінка для користувача</h1>
<span class="mr-3" style="font-size: 22px; color: #04396E;">{{ Auth::user()->login }}</span>
<form action="{{ route('logout') }}" method="POST" style="display: inline;">
    @csrf
    <button type="submit" class="btn btn-outline-light px-3 py-2" style="border: none; background: transparent;">
        <i class="fas fa-sign-out-alt" style="font-size: 1.3rem; color: #04396E;"></i>
    </button>
</form>
</body>
</html>

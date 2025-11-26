@props(['type'])
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
    <style>
        .bg-cover-section {
            background-image: url('{{ asset('images/milkyway.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            width: 100vw;
            height: 100vh;
        }
    </style>
</head>

<body class="bg-cover-section w3-display-container w3-center"> {{-- Title --}} <div
        class="w3-container w3-display-middle w3-animate-opacity">
        <div class="w3-col w3-center">
            <h1 class="w3-row w3-xxxlarge w3-bold s12 m12 l12">Ynetwork</h1>
            <h2 class="w3-row w3-xxlarge w3-bold s12 m12 l12">{{ $type }}</h2> {{$slot}}
        </div>
    </div>
    <footer class="w3-display-bottomleft w3-text-white w3-small">
        <p>&copy;2025 Ynetwork | Contact: y@network.com</p>
    </footer>

</body>

</html>
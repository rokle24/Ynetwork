<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>For you page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="../images/Logo2.png">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/SearchStyle.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Transparent search button hover effect */
        button.w3-transparent i {
            color: #888;
        }

        button.w3-transparent:hover i {
            color: #000;
        }

        button.w3-transparent,
        button.w3-transparent:hover,
        button.w3-transparent:active,
        button.w3-transparent:focus {
            background-color: transparent !important;
            box-shadow: none;
        }

        /* Main content spacing to avoid overlap with header */
        .main-content {
            margin-top: 100px;
            /* adjust to header height */
            padding: 20px;
        }

        /* Optional: footer styling */
        footer {
            margin-top: 40px;
            text-align: center;
            color: #555;
        }
    </style>
</head>

<header class="w3-light-blue w3-padding-small w3-card w3-top w3-bottombar w3-border-black">
    <div class="w3-cell-row" style="height:60px;">
        <div class="w3-cell w3-cell-middle w3-left-align">
            <a href="{{ route('user.for-you') }}" class="w3-hover-opacity">
                <img src="{{ asset('images/Logo2.png') }}" alt="Logo" class="w3-image w3-hover-opacity logo-hover"
                   style="height:80px; object-fit:cover; vertical-align:middle;">
            </a>

        </div>

        <div class="w3-cell w3-cell-middle">
            <form class="w3-container" style="position:relative; display:flex; align-items:center; margin:auto;">
                <input class="w3-input w3-border w3-border-black w3-round-xxlarge" type="text" autocomplete="off"
                    placeholder="Search users..." style="width:100%;" id="search">
                <button type="submit" class="w3-button w3-transparent" aria-label="Search"
                    style="position:absolute; right:10px; background:none; border:none; cursor:pointer; color:#000;">
                    <i class="fa fa-search"></i>
                </button>
                <div id="search-results" class="dropdown-menu show" style="width: 100%; display: none;"></div>

            </form>
        </div>


        <div class="w3-cell w3-cell-middle w3-right-align" style="width:25%;">
            <div class="w3-dropdown-hover w3-right w3-transparent">
                <img data-user-id="{{ auth()->user()->id }}" src="{{ auth()->user()->profile_picture }}"
                    alt="User profile" class="w3-image w3-circle"
                    style="height:60px; object-fit:cover; vertical-align:middle;">
                <div class="w3-dropdown-content w3-bar-block w3-border w3-border-black w3-round-xxlarge w3-animate-zoom"
                    style="right:0">
                    <a href="{{ route('user.profile') }}"
                        class="w3-bar-item w3-button w3-transparent w3-round-xxlarge">Profile</a>
                    <a href="{{ route('logout') }}"
                        class="w3-bar-item w3-button w3-transparent w3-round-xxlarge">Logout</a>
                </div>
            </div>
            <div class="w3-clear"></div>
        </div>
    </div>
    <div id="search-results" class="dropdown-menu show" style="width: 100%; display: none;"></div>

    <script src="{{ asset('js/get-user-avatar.js') }}"></script>
    <script src="{{ asset('js/search-users.js') }}"></script>
</header>

<body class="w3-paper">

    <!-- Sticky Header -->


    <!-- Main Content -->
    <div class="main-content w3-animate-opacity">
        <div class="w3-container w3-center" style="max-width:800px; margin:auto;">
            <h1 class="w3-xxxlarge w3-bold">For you page</h1>

            <div class="w3-container">
                @foreach ($posts as $post)
                    <x-post-structure :post="$post" :showActions="false" />
                @endforeach
            </div>
        </div>
    </div>



    @include('components.chat-bar')

    <!-- Footer -->


    <script src="../Scripts/LogoutPopup.js"></script>
</body>

<footer>
    <p>&copy; 2025 Ynetwork | Contact: y@network.com</p>
</footer>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="../images/Logo2.png">
    <link rel="stylesheet" href="{{ asset('css/Utils.css') }}">
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
                <input class="w3-input w3-border w3-border-black w3-round-xxlarge" type="text"
                    placeholder="Search Profile" style="width:100%;" id="search" autocomplete="off">
                <button type="submit" class="w3-button w3-transparent" aria-label="Search"
                    style="position:absolute; right:10px; background:none; border:none; cursor:pointer; color:#000;">
                    <i class="fa fa-search"></i>
                </button>
                <div id="search-results" class="dropdown-menu show" style=" display: none; "></div>

            </form>
        </div>

        <div class="w3-cell w3-cell-middle w3-right-align" style="width:25%;">
            <div class="w3-dropdown-hover w3-right w3-transparent">
                <img data-user-id="{{ auth()->user()->id }}" src="{{ asset(auth()->user()->profile_picture) }}"
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

    <script src="{{ asset('js/get-user-avatar.js') }}"></script>
    <script src="{{ asset('js/search-users.js') }}"></script>
</header>


<body>


    <div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">

        <div class="w3-row w3-margin-top ">

        @if (auth()->user()->id === $profiledata->id)
            <div class="w3-col l3 m6 s12">
        @else
            <div class="w3-col l12 m12 s12 center" style="margin: auto;">
         @endif

            <x-profile-structure :profiledata="$profiledata"></x-profile-structure>

            </div>
            @if (auth()->user()->id === $profiledata->id)
                <div class="w3-col l6 m6 s12">
                    <div class="w3-col w3-center">
                        <div class="w3-container w3-padding-small">
                            <div class="w3-container w3-card w3-white w3-round-xlarge w3-margin"><br>
                                <img src="{{ asset(auth()->user()->profile_picture) }}" alt="Avatar"
                                    class="w3-left w3-circle   w3-margin-right" style="width:60px">
                                <h4 class="w3-left ">{{ $profiledata->first_name }} {{ $profiledata->last_name }}</h4>
                                <br><br>
                                <hr class="w3-clear">
                                <form action="{{ route('posts.store') }}" method="post">
                                    @csrf

                                    <input
                                        class="w3-input w3-bold w3-round-xxlarge w3-padding-large w3-border-black w3-border"
                                        type="text" placeholder="Post Title" id="title" name="title" required><br>
                                    <textarea class="w3-input w3-round-xxlarge w3-padding-large w3-border-black w3-border"
                                        name="body" id="body" rows="3" required
                                        placeholder="What do you wanna post about?"></textarea><br>
                                    <button
                                        class="w3-button w3-black w3-round-xxlarge w3-padding-large w3-block w3-margin-bottom"
                                        type="submit">Post</button>
                                </form>
                            </div><br>
                        </div>
                    </div>
                </div>
            @endif

            @if (auth()->user()->id === $profiledata->id)
                <div class="w3-col l3 m12 s12">
                    <div class="w3-col w3-center">
                        <div class="w3-container w3-padding-small">
                            <!-- Chats Card -->
                            <div class="w3-container w3-card w3-white w3-round-xlarge w3-margin" id="chats-card"><br>
                                <h4 class="w3-bold">Chats</h4>
                                <div id="unread-summary">
                                    <!-- Unread info will be inserted here -->
                                    <p>Loading...</p>
                                </div>
                            </div>

                            <!-- Friend Requests Card -->
                            <div class="w3-container w3-card w3-white w3-round-xlarge w3-margin"><br>
                                <h4 class="w3-bold">Friend Requests</h4>

                                @php
                                    $friendRequests = \App\Models\Friendship::where('friend_id', auth()->user()->id)
                                                    ->where('status', 'pending')
                                                    ->with('sender')
                                                    ->get();
                                @endphp

                                @forelse($friendRequests as $request)
                                    <div class="w3-card w3-light-grey w3-round w3-margin-bottom w3-padding-small">
                                        <span>{{ $request->sender->first_name }} {{ $request->sender->last_name }}</span>
                                        <div class="w3-margin-top">
                                            <img src="{{ asset($request->sender->profile_picture) }}" alt="Avatar" class="w3-circle w3-margin-right"
                                                style="width:48px; height:48px; object-fit:cover;">
                                            <form action="{{ route('friend.accept', $request->sender->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button class="w3-button w3-green w3-round-xxlarge w3-small">Accept</button>
                                            </form>
                                            <form action="{{ route('friend.remove', $request->sender->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="w3-button w3-red w3-round-xxlarge w3-small">Deny</button>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <p>No friend requests at the moment.</p>
                                @endforelse
                            </div>

                            <!-- Friends Card -->
                            <div class="w3-container w3-card w3-white w3-round-xlarge w3-margin"><br>
                                <h4 class="w3-bold">Friends</h4>

                                @foreach (auth()->user()->friends() as $friend)
                                    <div class="w3-container w3-card w3-round-xlarge w3-padding-small w3-border-bottom w3-flex w3-margin-bottom" style="display:flex; align-items:center; gap:12px;">

                                        <!-- Avatar -->
                                        <img src="{{ asset($friend->profile_picture) }}"
                                            alt="Avatar"
                                            class="w3-circle"
                                            style="width:48px; height:48px; object-fit:cover;">

                                        <!-- Name -->
                                        <a href="{{ route('users.show', ['id' => $friend->id]) }}"
                                        class="w3-text-black"
                                        style="text-decoration:none; font-weight:600; font-size:15px;">
                                            {{ $friend->first_name }} {{ $friend->last_name }}
                                        </a>

                                    </div>
                                @endforeach

                                @if ($profiledata->friends()->count() === 0)
                                    <p class="w3-small w3-text-grey">No friends yet.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (auth()->user()->id === $profiledata->id)
                <div class="w3-col l12 m12 s12 center" >
            @else
                    <div class="w3-col l12 m12 s12 center" >

                @endif
                <div class="w3-col w3-center" style="max-width:800px; margin:auto;">
                    <div class="w3-container w3-padding-small"></div>
                    @if (auth()->user()->id === $profiledata->id)
                        <h1 class="w3-xxxlarge w3-bold">Your Posts</h1>
                    @else
                        <h1 class="w3-xxxlarge w3-bold">{{ $profiledata->first_name }}'s Posts</h1>
                    @endif
                    @foreach ($posts as $post)
                        <x-post-structure :post="$post" :showActions="auth()->user()->id === $profiledata->id" />
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const summaryContainer = document.getElementById('unread-summary');

                fetch('/api/chat/unread-summary', {
                    headers: {
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                })
                    .then(response => {
                        if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                        return response.json();
                    })
                    .then(data => {
                        if (!data.senders || data.senders.length === 0) {
                            summaryContainer.innerHTML = '<p>No unread messages.</p>';
                            return;
                        }

                        let html = `<p><strong>Total unread messages:</strong> ${data.total_unread}</p>`;
                        html += '<ul class="w3-ul">';
                        data.senders.forEach(sender => {
                            html += `<li>${sender.full_name} (${sender.unread_count} unread)</li>`;
                        });
                        html += '</ul>';
                        summaryContainer.innerHTML = html;
                    })
                    .catch(err => {
                        console.error('Fetch error:', err);
                        summaryContainer.innerHTML = '<p>Failed to load unread messages.</p>';
                    });
            });
        </script>


</body>

<footer>
    <p>&copy; 2025 Ynetwork | Contact: y@network.com</p>
</footer>

@include('components.chat-bar')

</html>

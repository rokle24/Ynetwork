<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;

Route::post('/mobile-login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid email or password',
        ], 401);
    }

    // Create a token
    $token = $user->createToken('mobile-token')->plainTextToken;

    return response()->json([
        'success' => true,
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ],
        'token' => $token,
    ]);
});

Route::prefix('mobile')->middleware('auth:sanctum')->group(function () {
    Route::get('/messages', [MessageController::class, 'fetchMessages']);
    Route::post('/messages/send', [MessageController::class, 'sendMessage']);
    Route::get('/chat/history', [MessageController::class, 'getChatHistory']);
    Route::get('/friends/list', [MessageController::class, 'getFriends']);
    Route::get('/chat/unread-summary', [MessageController::class, 'getUnreadSummary']);
});


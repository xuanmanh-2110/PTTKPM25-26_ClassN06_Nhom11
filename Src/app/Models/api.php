<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeminiController;

Route::post('/chat-gemini', [GeminiController::class, 'chat']);

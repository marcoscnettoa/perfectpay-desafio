<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;

Route::get('/', [ CheckoutController::class, 'index' ]);
Route::post('/checkout/payment', [ CheckoutController::class, 'payment' ]);

// !* Teste View - Retorno Metodo Pagamento
Route::post('/checkout/payment/method_return/{hash}', [ CheckoutController::class, 'method_return' ]);

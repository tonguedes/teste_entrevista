<?php

use App\Http\Controllers\ProdutoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Route to get the currently authenticated user.
 * Uses the Sanctum middleware to ensure the request is authenticated via API tokens.
 *
 * GET /user
 */
Route::get('/user', function (Request $request) {
    return $request->user(); // Returns the authenticated user
})->middleware('auth:sanctum');

/**
 * Registers a full set of API routes for "produtos" using a RESTful controller.
 * This includes:
 * - GET /produtos        → index
 * - GET /produtos/{id}   → show
 * - POST /produtos       → store
 * - PUT/PATCH /produtos/{id} → update
 * - DELETE /produtos/{id} → destroy
 */
Route::apiResource('produtos', ProdutoController::class);

/**
 * Route for exporting products as a PDF.
 * Calls the exportPdf method of the ProdutoController.
 *
 * GET /produtos-export-pdf
 */
Route::get('produtos-export-pdf', [ProdutoController::class, 'exportPdf']);

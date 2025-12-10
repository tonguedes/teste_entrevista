<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ProdutoService;
use App\Http\Requests\StoreProdutoRequest;
use App\Http\Requests\UpdateProdutoRequest;
use App\Http\Resources\ProdutoResource;
use Illuminate\Http\Response;

/**
 * Controller responsible for handling HTTP/API requests for products.
 * It delegates business logic to ProdutoService and formats responses
 * using API Resources.
 */
class ProdutoController extends Controller
{
    // Service layer instance that handles all product-related operations
    protected ProdutoService $service;

    /**
     * Injects the ProdutoService via dependency injection.
     * This keeps the controller thin and focused only on handling HTTP requests.
     */
    public function __construct(ProdutoService $service)
    {
        $this->service = $service;
    }

    /**
     * Returns a collection of all products.
     * Each product is transformed using ProdutoResource.
     *
     * GET /produtos
     */
    public function index()
    {
        return ProdutoResource::collection($this->service->list());
    }

    /**
     * Stores a new product using validated data.
     * Uses StoreProdutoRequest for validation.
     * Returns HTTP 201 (Created) with the created product.
     *
     * POST /produtos
     */
    public function store(StoreProdutoRequest $request)
    {
        // Creates the product using validated input
        $produto = $this->service->create($request->validated());

        // Returns response with created product and status 201
        return (new ProdutoResource($produto))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Shows a single product based on the given ID.
     * If the product doesn't exist, the service throws an exception.
     *
     * GET /produtos/{id}
     */
    public function show($id)
    {
        $produto = $this->service->get($id);
        return new ProdutoResource($produto);
    }

    /**
     * Updates an existing product with validated input data.
     * Uses UpdateProdutoRequest to ensure data integrity.
     *
     * PUT or PATCH /produtos/{id}
     */
    public function update(UpdateProdutoRequest $request, $id)
    {
        $produto = $this->service->update($id, $request->validated());
        return new ProdutoResource($produto);
    }

    /**
     * Deletes the product by ID.
     * Returns an empty response with HTTP 204 (No Content).
     *
     * DELETE /produtos/{id}
     */
    public function destroy($id)
    {
        $this->service->delete($id);
        return response()->noContent();
    }

    /**
     * Generates a PDF file containing all products.
     * Renders a Blade view into a PDF using a PDF library (e.g. DOMPDF).
     * Sends the file as a downloadable response.
     *
     * GET /produtos/export/pdf
     */
    public function exportPdf()
    {
        // Load all products
        $produtos = $this->service->list();

        // Generate PDF using Blade template
        $pdf = \PDF::loadView('produtos.pdf', compact('produtos'));

        // Download the generated PDF
        return $pdf->download('produtos.pdf');
    }
}

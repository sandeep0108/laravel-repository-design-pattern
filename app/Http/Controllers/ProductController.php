<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;


class ProductController extends Controller
{
    public function __construct(
        private readonly ProductRepository $productRepository
    ) {

    }

    public function index(): JsonResponse
    {
        return response()->json([
            'data' => $this->productRepository->getAllProducts()
        ]);
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        return response()->json(
            [
                'data' => $this->productRepository->createProduct($request->validated())
            ],
            Response::HTTP_CREATED
        );
    }

    public function show(Product $product): JsonResponse
    {
        return response()->json([
            'data' => $this->productRepository->getProductById($product->id)
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        return response()->json([
            'data' => $this->productRepository->updateProduct($product->id, $request->validated())
        ]);
    }

    public function destroy(Product $product): JsonResponse
    {
        $this->productRepository->deleteProduct($product->id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}

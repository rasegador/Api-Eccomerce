<?php

namespace App\Http\Controllers;

use App\Http\Services\OrderProductService;
use App\Http\Services\OrderService;
use App\Http\Services\PaymentService;
use App\Http\Services\ProductService;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

Class OrderController extends BaseController {

    protected $createRules = [
        'payment.method'        => 'required|string',
        'products.*.product_id'   => 'required|numeric',
        'products.*.quantity'     => 'required|numeric'
    ];

    public function __construct(
        Request $request,
        OrderService $orderService,
        ProductService $productService,
        OrderProductService $orderProductService,
        PaymentService $paymentService
        )
    {
        $this->paymentService = $paymentService;
        $this->serviceInstance = $orderService;
        $this->request = $request;
        $this->productService = $productService;
        $this->orderProductService = $orderProductService;
    }

    public function get($userId = null): JsonResponse
    {
        $data = $this->serviceInstance->get($userId);

        return response()->json([
            'error' => false,
            'data'  => $data
        ], 200);
    }

    public function create(): JsonResponse
    {
        $validator = Validator::make($this->request->all(), $this->createRules);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'data' => $validator->errors()], 422);
        }

        $products = $this->request->input('products');

        $payment = $this->request->input('payment');

        $data = $this->serviceInstance->create(auth()->user()->id, $products, $payment);

        return response()->json([
            'error'     => false,
            'message'   => 'Pedido feito com sucesso, aguardando pagamento.',
            'data'      => $data
        ], 200);
    }
}

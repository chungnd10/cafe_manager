<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Repositories\Order\OrderRepository;
use App\Repositories\OrderStatus\OrderStatusRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Table\TableRepository;
use Exception;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $orderRepository;
    protected $productRepository;
    protected $tableRepository;
    protected $orderStatusRepository;

    public function __construct(
        OrderRepository $orderRepository,
        OrderStatusRepository $orderStatusRepository,
        ProductRepository $productRepository,
        TableRepository $tableRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderStatusRepository = $orderStatusRepository;
        $this->productRepository = $productRepository;
        $this->tableRepository = $tableRepository;
    }


    public function index()
    {
        $orders = $this->orderRepository->getAll();
        $tables = $this->tableRepository->getAll();
        $products = $this->productRepository->getAll();
        $order_status = $this->orderStatusRepository->getAll();
        if (request()->ajax()) {
            return datatables()->of($orders)
                ->addColumn('action', 'admin.order.datatables.action')
                ->make(true);
        }

        return view('admin.order.index', compact('products', 'tables', 'order_status'));
    }


    public function store(OrderRequest $request)
    {
        $created_by = Auth::user()->id;
        $products_id = $request->input('products_id');
        $quantity = $request->input('quantity');

        $form_data = [
            'table_id' => $request->input('table_id'),
            'created_by' => $created_by,
        ];
        $order = $this->orderRepository->create($form_data);

        $extra = array_map(function ($quantity) {
            return ['quantity' => $quantity];
        }, $quantity);

        $data = array_combine($products_id, $extra);

        $order->products()->sync($data);

        $data = ['success' => 'Thêm thành công'];

        return $data;
    }


    public function edit($id, Order $order)
    {
        $this->authorize('edit', $order);
        $product = $this->orderRepository->find($id);
        return $product;
    }


    public function update(OrderRequest $request)
    {
        $id = $request->input('hidden_id');

        $order = $this->orderRepository->find($id);

        $this->authorize('update', $order);

        $products_id = $request->input('products_id');
        $quantity = $request->input('quantity');
        $order_status = $request->input('order_status_id');

        $form_data = [
            'table_id' => $request->input('table_id'),
        ];

        $processing_status = config('constants.ORDER_STATUS_PROCESSING');
        $complete_status = config('constants.ORDER_STATUS_COMPLETE');

        if ($order_status == $processing_status || $order_status == $complete_status) {
            $user_id = Auth::user()->id;
            $form_data['bartender_id'] = $user_id;
            $form_data['order_status_id'] = $order_status;
        }

        $order = $this->orderRepository->update($id, $form_data);

        $extra = array_map(function ($quantity) {
            return ['quantity' => $quantity];
        }, $quantity);

        $data = array_combine($products_id, $extra);
        $order->products()->sync($data);

        $data = ['success' => 'Cập nhật thành công'];
        return $data;
    }


    public function destroy($id)
    {
        $order = $this->orderRepository->find($id);

        $this->authorize('update', $order);

        try {
            $order->delete();
        } catch (Exception $exception) {
            $data = [
                'errors' => 'Xoá không thành công.'
            ];
            return $data;
        }

        $data = [
            'success' => 'Xóa thành công.'
        ];

        return $data;
    }
}

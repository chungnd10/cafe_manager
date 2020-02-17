<?php

namespace App\Http\Controllers;

use App\Repositories\User\UserRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Table\TableRepository;

class HomeController extends Controller
{
    protected $userRepository;
    protected $productRepository;
    protected $categoryRepository;
    protected $tableRepository;

    public function __construct(UserRepository $userRepository,
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        TableRepository $tableRepository
    ) {
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tableRepository = $tableRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = $this->categoryRepository->count();
        $products = $this->productRepository->count();
        $tables = $this->tableRepository->count();
        $users = $this->userRepository->count();

        return view('admin.index', compact('categories', 'products', 'tables', 'users'));
    }
}

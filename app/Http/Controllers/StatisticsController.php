<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\TshirtImage;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function index()
    {
        $totalUsers = User::count('id');
        $totalCustomers = User::query()->where('user_type', 'C')->count('id');
        $totalFuncionarios = User::query()->where('user_type', 'E')->count('id');
        $totalAdmins = User::query()->where('user_type', 'A')->count('id');
        $totalOrders = Order::count('id');
        $totalOrdersPending = Order::query()->where('status', 'pending')->count('id');
        $totalOrdersClosed = Order::query()->where('status', 'closed')->count('id');
        $totalOrdersCanceled = Order::query()->where('status', 'canceled')->count('id');
        $totalOrdersPaid = Order::query()->where('status', 'paid')->count('id');
        $totalOderItems = OrderItem::count('id');
        $totalOrdersItemsXs = OrderItem::query()->where('size', 'XS')->count('id');
        $totalOrdersItemsS = OrderItem::query()->where('size', 'S')->count('id');
        $totalOrdersItemsM = OrderItem::query()->where('size', 'M')->count('id');
        $totalOrdersItemsL = OrderItem::query()->where('size', 'L')->count('id');
        $totalOrdersItemsXl = OrderItem::query()->where('size', 'XL')->count('id');
        $totalTshirtImages = TshirtImage::count('id');
        $totalTshirtImagesPublic = TshirtImage::query()->whereNull('customer_id')->count('id');
        $totalTshirtImagesPrivate = $totalTshirtImages - $totalTshirtImagesPublic;
        $totalCategory = Category::count('id');
        $categories = Category::all();
        return view('statistics', compact('totalOrders', 'totalUsers', 'totalOderItems', 'totalTshirtImages', 'totalCategory', 'totalFuncionarios', 'totalAdmins',
            'totalCustomers', 'totalOrdersPending', 'totalOrdersClosed', 'totalOrdersCanceled', 'totalOrdersPaid',
            'totalOrdersItemsXs', 'totalOrdersItemsS', 'totalOrdersItemsM', 'totalOrdersItemsL', 'totalOrdersItemsXl',
            'totalTshirtImagesPublic', 'totalTshirtImagesPrivate', 'categories'));
    }
}

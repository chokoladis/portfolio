<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\FilterRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    const ENTITIES = [
        'Example_work', 'Workers', 'Feedback'
    ];

    public function index(FilterRequest $request)
    {
        $perPage = $request->per_page ?? 10;
        $sortBy = $request->sort_by ?? 'id';
        $sortType = $request->sort_type ?? 'desc';

        $categories = Category::query()
            ->orderBy($sortBy, $sortType)
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::all();
        $entities = self::ENTITIES;

        return view('admin.category.create', compact('categories', 'entities'));
    }

    public function store()
    {

    }
}

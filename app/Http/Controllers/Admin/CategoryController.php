<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\FilterRequest;
use App\Http\Requests\Category\StoreRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

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

    public function store(StoreRequest $request)
    {
        $data = $request->validationData();
        dd($data);
    }

    public function getByEntity(Request $request)
    {
        $data = $request->validate([
            'entity_code' => 'required|in:' . implode(',', array_keys(self::ENTITIES)),
            'return_json' => 'boolean'
        ]);
        dd($data);

        $returnJson = $data['return_json'];

        $data = CategoryService::getList([
            'entity_code' => $data['entity_code'],
            'active' => true
        ]);

        return $returnJson ? json_encode($data, JSON_UNESCAPED_UNICODE) : $data;
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\FilterRequest;
use App\Http\Requests\Category\StoreRequest;
use App\Models\Category;
use App\Services\CategoryService;
use App\Traits\Errors;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    use Errors;

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
        try {
            $validData = $request->validate([
                'code' => ['required', Rule::in(self::ENTITIES)],
                'return_json' => 'boolean'
            ]);

            $returnJson = isset($validData['return_json']) ? $validData['return_json'] : false;

            $data = CategoryService::getList([
                'entity_code' => $validData['code'],
                'active' => true
            ]);

            return responseJson(true, $data);
        } catch (\Throwable $th) {
            return responseJson(false, error: [$this->compileError($th->getCode(), $th->getMessage())]);
        }
    }
}

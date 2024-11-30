<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\FilterRequest;
use App\Http\Requests\Category\StoreRequest;
use App\Models\Category;
use App\Services\CategoryService;
use App\Services\FileService;
use App\Services\TableService;
use App\Traits\Errors;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    use Errors;

    const ENTITIES = [
        'Example_work', 'Workers', 'Feedback'
    ];

    public TableService $tableService;

    function __construct()
    {
        $this->tableService = new TableService(new Category);
    }


    public function index(FilterRequest $request)
    {
        $perPage = $request->per_page ?? 10;
        $sortBy = $request->sort_by ?? 'id';
        $sortType = $request->sort_type ?? 'desc';

        $categories = Category::query()
            ->orderBy($sortBy, $sortType)
            ->paginate($perPage)
            ->withQueryString();

        foreach ($categories as &$category) {
            if ($category->preview_id){
                $category->preview_src = config('filesystems.clients.Category') . FileService::getById($category->preview_id)->path;
            }
        }

        $table = $this->tableService->getTable($categories);

        return view('admin.category.index', compact('categories', 'table'));
    }

    public function create()
    {
        $categories = Category::all(['id', 'name']);
        $entities = self::ENTITIES;

        return view('admin.category.create', compact('categories', 'entities'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validationData();

        $fileService = new FileService($data, 'preview', 'Category');
        [$previewId, $errors] = $fileService->handlerFiles();

        if (CategoryService::isRowExists($data)){
            return redirect()->route('admin.categories.create')->withErrors(['Такая запись уже есть, смените название']);
        }

        $data['preview_id'] = !empty($previewId) ? $previewId[0] : null;

        $dataSave = [
            'entity_code' => $data['entity_code'],
            'parent_id' => $data['parent_id'] ?? null,
            'name' => $data['name'],
            'code' => $data['code'],
            'active' => $data['active'] ?? true,
            'sort' => $data['sort'] ?? 100,
            'preview_id' => $data['preview_id'],
        ];

        $result = Category::create($dataSave);

         if ($result){
             return redirect()->to(route('admin.categories.index'))->with('session', 'success');
         } else {
             return redirect()->to(route('admin.categories.create'))->with(['Ошибка добавления записи']);
         }
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
            ])->toArray();

            return responseJson(true, $data);
        } catch (\Throwable $th) {
            return responseJson(false, error: [$this->compileError($th->getCode(), $th->getMessage())]);
        }
    }
}

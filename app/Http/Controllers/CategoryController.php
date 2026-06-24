<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::query()
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->withCount('menus')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('categories.index', compact('categories'));
    }

    public function create(): View
    {
        $assignableMenus = Menu::with('category')->orderBy('name')->get();

        return view('categories.create', compact('assignableMenus'));
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        $category = Category::create($request->safe()->only(['name', 'description', 'is_active']));

        $this->syncMenus($category, $request->input('menu_ids', []));

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category): View
    {
        $category->load('menus');

        $assignableMenus = Menu::with('category')
            ->where('category_id', '!=', $category->id)
            ->orderBy('name')
            ->get();

        return view('categories.edit', compact('category', 'assignableMenus'));
    }

    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->safe()->only(['name', 'description', 'is_active']));

        $this->syncMenus($category, $request->input('menu_ids', []));

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Move the selected menus into this category.
     */
    private function syncMenus(Category $category, array $menuIds): void
    {
        $menuIds = array_filter($menuIds);

        if (! empty($menuIds)) {
            Menu::whereIn('id', $menuIds)->update(['category_id' => $category->id]);
        }
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->menus()->exists()) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki menu.');
        }

        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}

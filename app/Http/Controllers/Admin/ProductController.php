<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Tag;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct(protected MediaService $media)
    {
    }

    public function index(Request $request)
    {
        $products = Product::with('category')
            ->when($request->filled('search'), fn ($q) => $q->where('name', 'like', '%'.$request->string('search').'%'))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->ordered()
            ->paginate(12)
            ->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.form', [
            'product' => new Product(['status' => 'draft']),
            'categories' => Category::orderBy('display_order')->get(),
        ]);
    }

    public function store(ProductRequest $request)
    {
        $product = Product::create($this->payload($request));
        $this->syncTags($product, $request);
        $this->storeGallery($product, $request);

        return redirect()->route('admin.products.edit', $product)
            ->with('success', 'Product created.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.form', [
            'product' => $product->load('tags', 'images'),
            'categories' => Category::orderBy('display_order')->get(),
        ]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product->update($this->payload($request, $product));
        $this->syncTags($product, $request);
        $this->storeGallery($product, $request);

        return redirect()->route('admin.products.edit', $product)
            ->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted.');
    }

    public function destroyImage(Product $product, ProductImage $image)
    {
        abort_unless($image->product_id === $product->id, 404);
        $image->delete();

        return back()->with('success', 'Image removed.');
    }

    /** Build the persistable attribute array from the validated request. */
    protected function payload(ProductRequest $request, ?Product $product = null): array
    {
        $data = $request->safe()->except([
            'logo_file', 'cover_image_file', 'hero_image_file', 'gallery_files', 'tags', 'features', 'tech_stack',
        ]);

        $data['features'] = $this->linesToArray($request->input('features'));
        $data['tech_stack'] = $this->linesToArray($request->input('tech_stack'));

        foreach (['logo' => 'logo_file', 'cover_image' => 'cover_image_file', 'hero_image' => 'hero_image_file'] as $field => $input) {
            if ($request->hasFile($input)) {
                $media = $this->media->store($request->file($input), 'products');
                $data[$field] = $media->path;
            }
        }

        if (($data['status'] ?? null) === 'published' && empty($data['published_at']) && ! $product?->published_at) {
            $data['published_at'] = now();
        }

        return $data;
    }

    protected function syncTags(Product $product, ProductRequest $request): void
    {
        $names = collect(explode(',', (string) $request->input('tags')))
            ->map(fn ($name) => trim($name))
            ->filter()
            ->unique();

        $ids = $names->map(fn ($name) => Tag::firstOrCreate(
            ['slug' => Str::slug($name)],
            ['name' => $name]
        )->id);

        $product->tags()->sync($ids);
    }

    protected function storeGallery(Product $product, ProductRequest $request): void
    {
        foreach ($request->file('gallery_files', []) as $file) {
            $media = $this->media->store($file, 'products');
            $product->images()->create([
                'path' => $media->path,
                'alt' => $product->name,
                'display_order' => ($product->images()->max('display_order') ?? 0) + 1,
            ]);
        }
    }

    /** @return array<int, string> */
    protected function linesToArray(?string $text): array
    {
        return collect(preg_split('/\r\n|\r|\n/', (string) $text))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();
    }
}

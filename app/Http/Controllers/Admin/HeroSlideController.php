<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HeroSlideRequest;
use App\Models\HeroSlide;
use App\Models\Product;
use App\Services\MediaService;
use App\Services\Settings;
use Illuminate\Http\Request;

class HeroSlideController extends Controller
{
    public function __construct(protected MediaService $media)
    {
    }

    public function index()
    {
        return view('admin.slides.index', [
            'slides' => HeroSlide::ordered()->with('product')->get(),
            'autoplayDelay' => Settings::get('slideshow_autoplay_delay', '6000'),
            'transitionDuration' => Settings::get('slideshow_transition_duration', '900'),
        ]);
    }

    public function create()
    {
        return view('admin.slides.form', [
            'slide' => new HeroSlide(['animation' => 'fade', 'is_active' => true]),
            'products' => Product::ordered()->get(),
        ]);
    }

    public function store(HeroSlideRequest $request)
    {
        $slide = HeroSlide::create($this->payload($request));

        return redirect()->route('admin.slides.index')->with('success', 'Slide created.');
    }

    public function edit(HeroSlide $slide)
    {
        return view('admin.slides.form', [
            'slide' => $slide,
            'products' => Product::ordered()->get(),
        ]);
    }

    public function update(HeroSlideRequest $request, HeroSlide $slide)
    {
        $slide->update($this->payload($request));

        return redirect()->route('admin.slides.index')->with('success', 'Slide updated.');
    }

    public function destroy(HeroSlide $slide)
    {
        $slide->delete();

        return redirect()->route('admin.slides.index')->with('success', 'Slide deleted.');
    }

    public function toggle(HeroSlide $slide)
    {
        $slide->update(['is_active' => ! $slide->is_active]);

        return back()->with('success', $slide->is_active ? 'Slide enabled.' : 'Slide disabled.');
    }

    /** Persist drag-and-drop ordering: expects {order: [id, id, ...]}. */
    public function reorder(Request $request)
    {
        $request->validate(['order' => ['required', 'array'], 'order.*' => ['integer']]);

        foreach ($request->input('order') as $position => $id) {
            HeroSlide::where('id', $id)->update(['display_order' => $position + 1]);
        }

        return response()->json(['ok' => true]);
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'slideshow_autoplay_delay' => ['required', 'integer', 'min:2000', 'max:20000'],
            'slideshow_transition_duration' => ['required', 'integer', 'min:200', 'max:3000'],
        ]);

        foreach ($validated as $key => $value) {
            Settings::set($key, (string) $value, 'slideshow');
        }

        return back()->with('success', 'Slideshow settings saved.');
    }

    protected function payload(HeroSlideRequest $request): array
    {
        $data = $request->safe()->except(['image_file', 'logo_file', 'badges']);

        $data['badges'] = collect(explode(',', (string) $request->input('badges')))
            ->map(fn ($badge) => trim($badge))
            ->filter()
            ->values()
            ->all();

        foreach (['image' => 'image_file', 'logo' => 'logo_file'] as $field => $input) {
            if ($request->hasFile($input)) {
                $media = $this->media->store($request->file($input), 'slides');
                $data[$field] = $media->path;
            }
        }

        return $data;
    }
}

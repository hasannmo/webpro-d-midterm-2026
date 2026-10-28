@extends('layouts.admin')

@section('title', 'Admin Edit Product — ' . $product->name)

@section('admin-content')
    <section class="w-full rounded-2xl border border-sand bg-white p-6 shadow-[0_4px_20px_rgb(43_36_32/0.06)] md:p-9 max-w-2xl">
        <div class="flex items-center gap-4 border-b border-sand pb-4">
            <a href="{{ route('admin.product') }}" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-cream-dark text-ink transition hover:bg-brand hover:text-white" aria-label="Back">
                <x-icon name="arrow-left" :size="20" />
            </a>
            <h1 class="text-[32px] font-bold leading-tight text-black">Edit Product</h1>
        </div>

        @if ($errors->any())
            <div class="mt-6 rounded-lg bg-red-50 p-4 text-sm text-red-600 border border-red-200">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.product.update', ['productName' => $product->slug]) }}" enctype="multipart/form-data" class="mt-6 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-base font-medium text-ink">Product Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                       class="mt-2 w-full rounded-xl border border-sand bg-cream px-4 py-3 text-base text-ink outline-none transition focus:border-brand focus:bg-white">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="price" class="block text-base font-medium text-ink">Price (IDR)</label>
                    <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" required min="0" step="1000"
                           class="mt-2 w-full rounded-xl border border-sand bg-cream px-4 py-3 text-base text-ink outline-none transition focus:border-brand focus:bg-white">
                </div>

                <div>
                    <label for="category" class="block text-base font-medium text-ink">Category</label>
                    <select name="category" id="category"
                            class="mt-2 w-full rounded-xl border border-sand bg-cream px-4 py-3 text-base text-ink outline-none transition focus:border-brand focus:bg-white">
                        <option value="top" {{ old('category', $product->category) === 'top' ? 'selected' : '' }}>Top Wear</option>
                        <option value="outer" {{ old('category', $product->category) === 'outer' ? 'selected' : '' }}>Outer Wear</option>
                        <option value="bottom" {{ old('category', $product->category) === 'bottom' ? 'selected' : '' }}>Bottom Wear</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-base font-medium text-ink">Current Image</label>
                <div class="mt-2 flex items-center gap-4">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-20 w-20 rounded-lg bg-cream-dark object-contain p-1 border border-sand">
                    <span class="text-sm text-muted break-all">{{ $product->image }}</span>
                </div>
            </div>

            <div>
                <label for="image_file" class="block text-base font-medium text-ink">Replace Image (Upload File)</label>
                <input type="file" name="image_file" id="image_file" accept="image/*"
                       class="mt-2 w-full rounded-xl border border-sand bg-cream px-4 py-3 text-base text-ink file:mr-4 file:rounded-lg file:border-0 file:bg-brand file:px-4 file:py-2 file:text-sm file:text-white hover:file:bg-brand-dark">
                <p class="mt-1 text-xs text-muted">Or enter existing filename in public/images/ below:</p>
                <input type="text" name="image_name" id="image_name" value="{{ old('image_name', $product->image) }}"
                       class="mt-1.5 w-full rounded-xl border border-sand bg-cream px-4 py-2.5 text-sm text-ink outline-none transition focus:border-brand focus:bg-white">
            </div>

            <div>
                <label for="description" class="block text-base font-medium text-ink">Description</label>
                <textarea name="description" id="description" rows="4"
                          class="mt-2 w-full rounded-xl border border-sand bg-cream px-4 py-3 text-base text-ink outline-none transition focus:border-brand focus:bg-white">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="flex items-center gap-4 pt-4">
                <button type="submit"
                        class="inline-flex h-[53px] items-center justify-center rounded-lg bg-warning px-8 text-[20px] font-light text-white transition duration-200 hover:brightness-95 focus-visible:brightness-95 outline-none">
                    Update Product
                </button>
                <a href="{{ route('admin.product') }}" class="text-base text-muted hover:text-ink">Cancel</a>
            </div>
        </form>
    </section>
@endsection


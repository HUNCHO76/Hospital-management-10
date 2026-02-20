<div>
    <label class="block text-sm font-medium text-gray-700">Test Name</label>
    <input type="text" name="test_name" value="{{ old('test_name', $labTest?->test_name) }}" class="mt-1 block w-full border border-gray-300 rounded-md py-2 px-3" required>
    @error('test_name')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Short Name</label>
    <input type="text" name="short_name" value="{{ old('short_name', $labTest?->short_name) }}" class="mt-1 block w-full border border-gray-300 rounded-md py-2 px-3">
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Category</label>
    <input type="text" name="category" value="{{ old('category', $labTest?->category) }}" class="mt-1 block w-full border border-gray-300 rounded-md py-2 px-3">
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Reference Range</label>
    <textarea name="reference_range" rows="2" class="mt-1 block w-full border border-gray-300 rounded-md py-2 px-3">{{ old('reference_range', $labTest?->reference_range) }}</textarea>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Unit</label>
        <input type="text" name="unit" value="{{ old('unit', $labTest?->unit) }}" class="mt-1 block w-full border border-gray-300 rounded-md py-2 px-3">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Price</label>
        <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $labTest?->price) }}" class="mt-1 block w-full border border-gray-300 rounded-md py-2 px-3">
    </div>
</div>

<div class="flex items-center gap-2">
    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $labTest?->is_active ?? true))>
    <label class="text-sm text-gray-700">Active</label>
</div>

<div class="flex justify-end gap-3 mt-4">
    <a href="{{ route('admin.lab-tests.index') }}" class="px-4 py-2 bg-gray-200 rounded-md text-sm font-semibold">Cancel</a>
    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-semibold uppercase">Save</button>
</div>

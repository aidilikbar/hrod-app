<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Position') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <form method="POST" action="{{ route('positions.update', $position->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 text-sm font-bold mb-2">
                            Title
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title', $position->title) }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               required>
                        @error('title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="department_id" class="block text-gray-700 text-sm font-bold mb-2">
                            Department
                        </label>
                        <select name="department_id" id="department_id"
                                class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required>
                            <option value="">Select Department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ old('department_id', $position->department_id) == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="category" class="block text-gray-700 text-sm font-bold mb-2">
                            Category
                        </label>
                        <select name="category" id="category"
                                class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required>
                            <option value="">Select Category</option>
                            @foreach(['Core', 'Leaning Core', 'Leaning Non Core'] as $cat)
                                <option value="{{ $cat }}" {{ old('category', $position->category) == $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="parent_id" class="block text-gray-700 text-sm font-bold mb-2">
                            Reports To (Parent Position)
                        </label>
                        <select name="parent_id" id="parent_id"
                                class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">None</option>
                            @foreach($positions as $pos)
                                <option value="{{ $pos->id }}" {{ old('parent_id', $position->parent_id) == $pos->id ? 'selected' : '' }}>
                                    {{ $pos->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('parent_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit"
                                class="bg-green-600 hover:bg-green-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Update Position
                        </button>
                        <a href="{{ route('positions.index') }}"
                           class="inline-block align-baseline font-bold text-sm text-gray-500 hover:text-gray-800">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
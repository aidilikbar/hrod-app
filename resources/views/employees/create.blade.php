<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Employee') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Name --}}
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" id="name" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" />
                    </div>

                    {{-- Email --}}
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" />
                    </div>

                    {{-- Position --}}
                    <div class="mb-4">
                        <label for="position_id" class="block text-sm font-medium text-gray-700">Position</label>
                        <select name="position_id" id="position_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                            <option value="">-- Select Position --</option>
                            @foreach ($positions as $position)
                                <option value="{{ $position->id }}" data-department="{{ $position->department->name ?? '' }}">
                                    {{ $position->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Department (auto-filled, disabled) --}}
                    <div class="mb-4">
                        <label for="photo" class="block text-sm font-medium text-gray-700">Department</label>
                        <input type="text" name="department_name" id="department_name"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" disabled/>
                    </div>

                    {{-- Photo --}}
                    <div class="mb-4">
                        <label for="photo" class="block text-sm font-medium text-gray-700">Photo</label>
                        <input type="file" name="photo" id="photo"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" />
                    </div>

                    {{-- Submit --}}
                    <div class="flex justify-end">
                        <a href="{{ route('employees.index') }}"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md mr-2">Cancel</a>
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Save</button>
                    </div>
                </form>

                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        const positionSelect = document.getElementById('position_id');
                        const departmentInput = document.getElementById('department_name');

                        positionSelect.addEventListener('change', function () {
                            const selectedOption = this.options[this.selectedIndex];
                            const department = selectedOption.getAttribute('data-department');
                            departmentInput.value = department ?? '';
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</x-app-layout>
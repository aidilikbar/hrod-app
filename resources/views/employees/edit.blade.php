<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Employee
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if ($errors->any())
                    <div class="mb-4 text-red-600">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="block font-medium">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $employee->name) }}" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block font-medium">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $employee->email) }}" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label for="position_id" class="block font-medium">Position</label>
                        <select name="position_id" id="position_id" class="w-full border rounded px-3 py-2" required>
                            <option value="">-- Select Position --</option>
                            @foreach($positions as $position)
                                <option value="{{ $position->id }}"
                                    {{ ($employee->positions->first()->id ?? '') == $position->id ? 'selected' : '' }}>
                                    {{ $position->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="photo" class="block font-medium">Photo</label>
                        <input type="file" name="photo" id="photo" class="w-full border rounded px-3 py-2">
                        @if ($employee->photo)
                            <p class="mt-2">Current: <img src="{{ asset('storage/' . $employee->photo) }}" alt="Photo" width="80"></p>
                        @endif
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">
                            Update Employee
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
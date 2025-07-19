<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Employee</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('employees.update', $employee) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Name --}}
                    <div class="mb-4">
                        <label for="name" class="block font-medium text-sm text-gray-700">Name</label>
                        <input id="name" name="name" type="text" class="form-input w-full mt-1" value="{{ old('name', $employee->name) }}" required autofocus>
                    </div>

                    {{-- Email --}}
                    <div class="mb-4">
                        <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                        <input id="email" name="email" type="email" class="form-input w-full mt-1" value="{{ old('email', $employee->email) }}" required>
                    </div>

                    {{-- Employee Number --}}
                    <div class="mb-4">
                        <label for="employee_number" class="block font-medium text-sm text-gray-700">Employee Number</label>
                        <input id="employee_number" name="employee_number" type="text" class="form-input w-full mt-1" value="{{ old('employee_number', $employee->employee_number) }}">
                    </div>

                    {{-- Talent Mapping --}}
                    <div class="mb-4">
                        <label for="talent_mapping" class="block font-medium text-sm text-gray-700">Talent Mapping</label>
                        <select id="talent_mapping" name="talent_mapping" class="form-select w-full mt-1">
                            <option value="">-- Select --</option>
                            @foreach (['High Potiential', 'Mediocre', 'Deadwood'] as $option)
                                <option value="{{ $option }}" {{ old('talent_mapping', $employee->talent_mapping) === $option ? 'selected' : '' }}>
                                    {{ $option }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="mb-4">
                        <label for="status" class="block font-medium text-sm text-gray-700">Status</label>
                        <select id="status" name="status" class="form-select w-full mt-1">
                            <option value="">-- Select --</option>
                            @foreach (['Permanent', 'Contract', 'Konpro', 'Freelance'] as $option)
                                <option value="{{ $option }}" {{ old('status', $employee->status) === $option ? 'selected' : '' }}>
                                    {{ $option }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Company --}}
                    <div class="mb-4">
                        <label for="company" class="block font-medium text-sm text-gray-700">Company</label>
                        <select id="company" name="company" class="form-select w-full mt-1">
                            <option value="">-- Select --</option>
                            @foreach (['KCM', 'UB', 'AIN', 'KIN', 'VCBL', 'KMN', 'Gramedia', 'Others'] as $option)
                                <option value="{{ $option }}" {{ old('company', $employee->company) === $option ? 'selected' : '' }}>
                                    {{ $option }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Photo --}}
                    <div class="mb-6">
                        <label for="photo" class="block font-medium text-sm text-gray-700">Photo</label>
                        <input id="photo" name="photo" type="file" class="form-input w-full mt-1">
                        @if ($employee->photo)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $employee->photo) }}" alt="Employee Photo" class="h-20 rounded">
                            </div>
                        @endif
                    </div>

                    {{-- Buttons --}}
                    <div class="flex items-center space-x-3">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
                        <a href="{{ route('employees.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
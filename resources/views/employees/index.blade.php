<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Employees
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('employees.create') }}"
               class="mb-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                + Add Employee
            </a>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="text-left border-b">
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Position</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $employee->name }}</td>
                                <td class="px-4 py-2">{{ $employee->email }}</td>
                                <td class="px-4 py-2">
                                    @php
                                        $primaryPosition = $employee->positions->firstWhere('pivot.is_primary', 1);
                                    @endphp
                                    {{ $primaryPosition ? $primaryPosition->title : 'N/A' }}
                                </td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('employees.edit', $employee) }}"
                                       class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                    <form action="{{ route('employees.destroy', $employee) }}"
                                          method="POST" class="inline-block"
                                          onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
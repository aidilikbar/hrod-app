<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Employees
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-4">
                <form method="GET" action="{{ route('employees.index') }}" class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="border border-gray-300 rounded px-3 py-1"
                        placeholder="Search by name or email" />
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700">Search</button>
                </form>
                <a href="{{ route('employees.create') }}"
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">+ Add New</a>
            </div>

            <div class="bg-white shadow overflow-x-auto sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <tr>
                            <th class="px-4 py-3 text-left">#</th>
                            <th class="px-4 py-3 text-left">Name</th>
                            <th class="px-4 py-3 text-left">Email</th>
                            <th class="px-4 py-3 text-left">Employee No.</th>
                            <th class="px-4 py-3 text-left">Talent Mapping</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Company</th>
                            <th class="px-4 py-3 text-left">Position</th>
                            <th class="px-4 py-3 text-left">Department</th>
                            <th class="px-4 py-3 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-sm">
                        @foreach ($employees as $index => $employee)
                            <tr>
                                <td class="px-4 py-2">{{ $loop->iteration + ($employees->currentPage() - 1) * $employees->perPage() }}</td>
                                <td class="px-4 py-2">{{ $employee->name }}</td>
                                <td class="px-4 py-2">{{ $employee->email }}</td>
                                <td class="px-4 py-2">{{ $employee->employee_number ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $employee->talent_mapping ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $employee->status ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $employee->company ?? '-' }}</td>
                                <td class="px-4 py-2">
                                    {{ optional($employee->positions->first())->title ?? '-' }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ optional($employee->positions->first()?->department)->name ?? '-' }}
                                </td>
                                <td class="px-4 py-2 flex gap-2">
                                    <a href="{{ route('employees.edit', $employee->id) }}"
                                    class="text-blue-600 hover:underline">Edit</a>

                                    <form method="POST" action="{{ route('employees.destroy', $employee->id) }}"
                                        onsubmit="return confirm('Are you sure you want to delete this employee?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="p-4">
                    {{ $employees->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
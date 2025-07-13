<x-app-layout>
    <div class="py-6 px-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Employees</h2>

        {{-- Search Form --}}
        <form method="GET" action="{{ route('employees.index') }}" class="flex flex-wrap items-center gap-3 mb-6">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search by name or email"
                class="flex-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none"
            />
            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2 rounded-md shadow-sm transition">
                Search
            </button>
            <a href="{{ route('employees.create') }}"
               class="ml-auto bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-md font-medium shadow-sm">
                + Add Employee
            </a>
        </form>

        {{-- Table --}}
        <div class="overflow-x-auto rounded shadow bg-white">
            @php
                function sortLink($column, $label) {
                    $direction = request('sort') === $column && request('direction') === 'asc' ? 'desc' : 'asc';
                    $arrow = request('sort') === $column ? (request('direction') === 'asc' ? '↑' : '↓') : '';
                    return '<a href="?'.http_build_query(array_merge(request()->all(), ['sort' => $column, 'direction' => $direction])).'" class="hover:underline">'.$label.' '.$arrow.'</a>';
                }
            @endphp
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{!! sortLink('name', 'Name') !!}</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{!! sortLink('email', 'Email') !!}</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{!! sortLink('position_id', 'Position') !!}</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{!! sortLink('department_id', 'Department') !!}</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($employees as $employee)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3">{{ $employee->name }}</td>
                            <td class="px-6 py-3">{{ $employee->email }}</td>
                            <td class="px-6 py-3">
                                {{ $employee->positions->first()?->title ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-3">
                                {{ $employee->department_name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-3 space-x-3">
                                <a href="{{ route('employees.edit', $employee) }}" class="text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('employees.destroy', $employee) }}" method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">No employees found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="p-4 border-t bg-gray-50">
                {{ $employees->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
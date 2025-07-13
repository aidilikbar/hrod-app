<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Departments') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-4">
                <form method="GET" action="{{ route('departments.index') }}" class="flex">
                    <input type="text" name="search" placeholder="Search by name..." value="{{ request('search') }}"
                           class="px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring">
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-r-md hover:bg-blue-700">Search</button>
                </form>
                <a href="{{ route('departments.create') }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">+ Add Department</a>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    @php
                        function sortLink($column, $label) {
                            $sort = request('sort');
                            $direction = request('direction') === 'asc' ? 'desc' : 'asc';
                            $arrow = request('sort') === $column
                                ? (request('direction') === 'asc' ? '↑' : '↓')
                                : '';
                            $query = array_merge(request()->except('page'), [
                                'sort' => $column,
                                'direction' => $direction,
                            ]);
                            $url = url()->current() . '?' . http_build_query($query);
                            return '<a href="' . $url . '" class="hover:underline">' . e($label) . ' ' . $arrow . '</a>';
                        }
                    @endphp
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">
                                {!! sortLink('name', 'Name') !!}
                            </th>
                            <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($departments as $department)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $department->name }}</td>
                                <td class="px-6 py-4 text-right text-sm">
                                    <a href="{{ route('departments.edit', $department) }}"
                                       class="text-blue-600 hover:underline">Edit</a>
                                    <form action="{{ route('departments.destroy', $department) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:underline ml-2"
                                                onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-sm text-gray-500 text-center">No departments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">
                    {{ $departments->appends(request()->only(['search', 'sort', 'direction']))->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
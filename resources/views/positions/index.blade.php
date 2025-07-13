<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold">Positions</h2>
                        <a href="{{ route('positions.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">+ Add Position</a>
                    </div>

                    <form method="GET" action="{{ route('positions.index') }}" class="mb-4">
                        <div class="flex">
                            <input type="text" name="search" placeholder="Search by title..." value="{{ request('search') }}"
                                   class="w-full rounded-l border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-r hover:bg-blue-700">Search</button>
                        </div>
                    </form>

                    <div class="overflow-x-auto">
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
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{!! sortLink('title', 'Title') !!}</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{!! sortLink('department_id', 'Department') !!}</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{!! sortLink('parent_id', 'Parent') !!}</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($positions as $position)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $position->title }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $position->department->name ?? '—' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $position->parent->title ?? '—' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('positions.edit', $position) }}" class="text-indigo-600 hover:underline">Edit</a>
                                            <form action="{{ route('positions.destroy', $position) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-red-600 hover:underline ml-2" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $positions->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
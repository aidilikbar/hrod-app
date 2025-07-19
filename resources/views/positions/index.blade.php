<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Positions') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex justify-between items-center">
                <form method="GET" action="{{ route('positions.index') }}" class="flex items-center">
                    <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}"
                           class="border border-gray-300 rounded px-4 py-2 mr-2">
                    <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">Search</button>
                </form>
                <a href="{{ route('positions.create') }}"
                   class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    + Create New Position
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                <a href="{{ route('positions.index', ['sort' => 'title', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'] + request()->except('page')) }}">
                                    Title
                                </a>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                <a href="{{ route('positions.index', ['sort' => 'department', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'] + request()->except('page')) }}">
                                    Department
                                </a>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                <a href="{{ route('positions.index', ['sort' => 'category', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'] + request()->except('page')) }}">
                                    Category
                                </a>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($positions as $position)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $position->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $position->department->name ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $position->category ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('positions.edit', $position) }}"
                                       class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <form action="{{ route('positions.destroy', $position) }}" method="POST"
                                          class="inline-block" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 ml-2">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="px-6 py-4">
                    {{ $positions->appends(request()->except('page'))->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
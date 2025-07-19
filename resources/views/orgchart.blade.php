<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Organization Chart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div id="orgchart" class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4"></div>
        </div>
    </div>

    @push('scripts')
    <script src="https://balkan.app/js/OrgChart.js"></script>
    <script>
        const chart = new OrgChart(document.getElementById("orgchart"), {
            template: "ula",
            enableSearch: true,
            nodeBinding: {
                field_0: "name",
                field_1: "title"
            },
            nodes: @json($nodes)
        });
    </script>
    @endpush
</x-app-layout>
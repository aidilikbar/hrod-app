{{-- resources/views/orgchart.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Organizational Chart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-bold mb-4">Organizational Chart</h3>
                    <div id="orgchart"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Your OrgChart JavaScript --}}
    <script src="https://balkan.app/js/OrgChart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetch('/api/orgchart')
                .then(response => response.json())
                .then(data => {
                    new OrgChart(document.getElementById("orgchart"), {
                        nodes: data,
                        nodeBinding: {
                            field_0: "name",
                            field_1: "title"
                        }
                    });
                });
        });
    </script>
</x-app-layout>
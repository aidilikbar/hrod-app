<x-app-layout>
    <div class="p-6">
        <h2 class="text-lg font-semibold mb-4">Organizational Chart</h2>
        <div id="orgchart-wrapper"></div>

        <script src="https://balkan.app/js/OrgChart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                fetch("/api/orgchart") // Correct route
                    .then(response => response.json())
                    .then(data => {
                        if (!data || data.length === 0) {
                            document.getElementById("orgchart-wrapper").innerHTML = "<p>No organizational data found.</p>";
                            return;
                        }

                        // Group nodes by root parent (nodes with pid == null)
                        const roots = data.filter(node => node.pid === null);

                        roots.forEach((root, index) => {
                            const containerId = `orgchart-${index}`;
                            const container = document.createElement("div");
                            container.id = containerId;
                            container.classList.add("mb-10");
                            document.getElementById("orgchart-wrapper").appendChild(container);

                            new OrgChart(document.getElementById(containerId), {
                                nodes: data,
                                nodeBinding: {
                                    field_0: "title",
                                    field_1: "name",
                                },
                                rootId: root.id,
                            });
                        });
                    })
                    .catch(error => {
                        document.getElementById("orgchart-wrapper").innerHTML = "<p>Error loading chart data.</p>";
                        console.error("Error fetching chart data:", error);
                    });
            });
        </script>
    </div>
</x-app-layout>
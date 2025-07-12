<!DOCTYPE html>
<html>
<head>
    <title>Organizational Chart</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://balkan.app/js/orgchart.js"></script>
    <style>
        #orgchart {
            width: 100%;
            height: 800px;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Organizational Chart</h2>
    <div id="orgchart"></div>

    <script>
        const chart = new OrgChart(document.getElementById("orgchart"), {
            nodeBinding: {
                field_0: "name",
                field_1: "title"
            },
            enableDragDrop: true
        });

        fetch('/api/orgchart')
            .then(response => response.json())
            .then(data => chart.load(data))
            .catch(error => console.error("Failed to load org chart data", error));
    </script>
</body>
</html>
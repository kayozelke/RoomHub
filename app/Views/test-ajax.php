<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <title>Room List</title>
</head>

<body>

    <label for="building_id">Building ID:</label>
    <input type="text" name="building_id" id="building_id" value="">

    <label for="roomInput">Select Room:</label>
    <select id="roomInput" class="form-select">
    </select>


    <input style="width:200px; height:30px;" list="colors_data">
    <datalist id="colors_data">
        <option value="red">The color of apple</option>
        <option value="orange">The color of sun</option>
        <option value="green">The color of grass</option>
        <option value="blue">The color of the sky</option>
    </datalist>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var buildingSelect = document.getElementById('building_id');
            var roomSelect = document.getElementById('roomInput');

            buildingSelect.addEventListener('change', function() {
                var selectedBuildingId = this.value;

                // Wykonaj żądanie AJAX po zmianie building_id
                fetch('/get_rooms_of_building/' + selectedBuildingId)
                    .then(response => response.json())
                    .then(data => {
                        // Wyczyść istniejące opcje w roomSelect
                        roomSelect.innerHTML = '';

                        // Dodaj nowe opcje do roomSelect na podstawie otrzymanych danych
                        data.forEach(room => {
                            var option = document.createElement('option');
                            option.value = room.id; // Zakładam, że dane zawierają pole "id"
                            option.textContent = room.number; // Zakładam, że dane zawierają pole "name"
                            roomSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Błąd podczas pobierania pokoi:', error);
                    });
            });
        });
    </script>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</html>
<!DOCTYPE html>
<html>
<head>
    <title>Detalles de orden</title>
    <link href="{{ asset('material') }}/css/pdf.css" rel="stylesheet" />
    <script>
        const systems = {!! json_encode($order->curtains) !!}; // Your systems data
        console.log(systems);
        const maxColumnsPerTable = 6; // Maximum number of columns per table
        const tablesContainer = document.getElementById('tables-container');

        // Function to create a new table and populate it with data
        function createTable(data) {
            const table = document.createElement('table');
            const tbody = document.createElement('tbody');

            // Create table header row
            const thead = document.createElement('thead');
            const headerRow = document.createElement('tr');
            const headers = ['Header 1', 'Header 2', 'Header 3', 'Header 4', 'Header 5', 'Header 6'];

            headers.forEach(headerText => {
                const th = document.createElement('th');
                th.textContent = headerText;
                headerRow.appendChild(th);
            });

            thead.appendChild(headerRow);
            table.appendChild(thead);

            // Create table body rows
            data.forEach(curtain => {
                const row = document.createElement('tr');

                // Sample data for each column
                const columnsData = [
                    curtain.quantity,
                    curtain.model.name,
                    curtain.mechanism.name,
                    curtain.width + ' m',
                    curtain.height + ' m',
                    curtain.cover.id,
                ];

                columnsData.forEach(cellData => {
                    const td = document.createElement('td');
                    td.textContent = cellData;
                    row.appendChild(td);
                });

                tbody.appendChild(row);
            });

            table.appendChild(tbody);
            tablesContainer.appendChild(table);
        }

        let currentTableData = [];
        systems.forEach((curtain, index) => {
            currentTableData.push(curtain);

            // Create a new table every 6 systems or at the end of the data
            if ((index + 1) % maxColumnsPerTable === 0 || index === systems.length - 1) {
                createTable(currentTableData);
                currentTableData = []; // Reset the data for the next table
            }
        });
    </script>
</head>
<body>
<div class="pdf-layout">
    <div class="pdf-section company-logo">
        <!-- Insert company logo here -->
        <img src="{{ asset('material') }}/img/logosolair.png" alt="Company Logo" width="200">
    </div>
    <div class="pdf-section client-data">
        @if($order->activity == 'Oferta')
            <h1 class="text-center">Oferta {{ $order->id }}</h1>
        @else
            <h1 class="text-center">Pedido{{ $order->id }}</h1>
        @endif
        <h3>{{ $order->project }}</h3>
        <!-- Insert client data here -->
        Contacto: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $order->user->name }}<br>
        Socio: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $order->user->partner->description }}<br>
        Email: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $order->user->email }}<br>
        Teléfono: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $order->user->phone }}<br>
    </div>
    <table class="pdf-table">
        <thead>
            <tr>
                <th class="border-right">Datos de sistema:</th>
                @for($i = 1; $i <= sizeof($order->curtains); $i++)
                    <th class="border-bottom">Sistema {{$i}}:</th>
                @endfor
            </tr>
        </thead>
        <tbody>
        <tr>
            <td class="border-right">Cantidad</td>
            @foreach($order->curtains as $curtain)
                <td class="text-right">{{$curtain->quantity}}</td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right">Modelo</td>
            @foreach($order->curtains as $curtain)
                <td class="text-right">{{$curtain->model->name}}</td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right">Mecanismo</td>
            @foreach($order->curtains as $curtain)
                <td class="text-right">{{$curtain->mechanism->name}}</td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right">Ancho</td>
            @foreach($order->curtains as $curtain)
                <td class="text-right">{{$curtain->width}} m</td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right">Caída</td>
            @foreach($order->curtains as $curtain)
                <td class="text-right">{{$curtain->height}} m</td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right"></td>
            @foreach($order->curtains as $curtain)
                <td class="text-right">{{$curtain->cover->id}}</td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right">Cubierta</td>
            @foreach($order->curtains as $curtain)
                <td class="text-right">{{$curtain->cover->name}}</td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right fixed-height-cell"></td>
            @foreach($order->curtains as $curtain)
                <td></td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right">Manivela</td>
            @foreach($order->curtains as $curtain)
                @if($curtain->handle_id != 9999 && $curtain->handle_id != 999)
                    <td class="text-right">{{$curtain->handle->measure}} m ({{$curtain->handle_quantity}})</td>
                @else
                    <td></td>
                @endif
            @endforeach
        </tr>
        <tr>
            <td class="border-right">Control</td>
            @foreach($order->curtains as $curtain)
                @if($curtain->control_id != 9999 && $curtain->control_id != 999)
                    <td class="text-right">{{$curtain->control->name}} ({{$curtain->control_quantity}})</td>
                @else
                    <td></td>
                @endif
            @endforeach
        </tr>
        <tr>
            <td class="border-right">Control voz</td>
            @foreach($order->curtains as $curtain)
                @if($curtain->voice_id != 9999 && $curtain->voice_id != 999)
                    <td class="text-right">{{$curtain->voice->name}} ({{$curtain->voice_quantity}})</td>
                @else
                    <td></td>
                @endif
            @endforeach
        </tr>
        <tr>
            <td class="border-right">Tejadillo</td>
            @foreach($order->curtains as $curtain)
                @if($curtain->canopy == 1)
                    <td class="text-right">Si</td>
                @else
                    <td></td>
                @endif
            @endforeach
        </tr>
        <tr>
            <td class="border-right fixed-height-cell"></td>
            @foreach($order->curtains as $curtain)
                <td></td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right">Instalación</td>
            @foreach($order->curtains as $curtain)
                <td class="text-right">{{$curtain->installation_type}}</td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right">Lado del mecanismo</td>
            @foreach($order->curtains as $curtain)
                <td class="text-right">{{$curtain->mechanism_side}}</td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right">Precio</td>
            @foreach($order->curtains as $curtain)
                <td bgcolor="#d3d3d3" class="text-center">${{number_format($curtain->price,2)}}</td>
            @endforeach
        </tr>
        </tbody>
    </table>
    <div id="tables-container">
        <!-- Tables will be dynamically added here -->
    </div>
</div>
</body>
</html>


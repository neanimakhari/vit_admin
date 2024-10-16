<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Incomes</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>
<body>
    <h1>Vehicle Incomes</h1>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Vehicle</th>
                <th>Driver</th>
                <th>Income</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vehicleIncomes as $income)
                <tr>
                    <td>{{ $income->logged_on->format('Y-m-d') }}</td>
                    <td>{{ $income->vehicle }}</td>
                    <td>{{ $income->driver_name }}</td>
                    <td>{{ number_format($income->income, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

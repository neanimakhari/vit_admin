<!-- ... other HTML ... -->
<table class="min-w-full bg-white">
    <thead class="bg-gray-100">
        <tr>
            <th>Vehicle</th>
            <th>Date</th>
            <th>Income</th>
            <th>Expense</th>
            <!-- ... other headers ... -->
        </tr>
    </thead>
    <tbody>
        @foreach($vehicleIncomes as $income)
        <tr>
            <td>{{ $income->vehicle }}</td>
            <td>{{ $income->date }}</td>
            <td>R {{ number_format($income->income, 2) }}</td>
            <td>R {{ number_format($income->expense, 2) }}</td>
            <!-- ... other columns ... -->
        </tr>
        @endforeach
    </tbody>
</table>
<!-- ... other HTML ... -->

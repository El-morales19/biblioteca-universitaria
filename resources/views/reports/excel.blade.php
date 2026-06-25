<table>
    <thead>
        <tr>
            <th colspan="7" style="font-weight: bold; text-align: center;">Reporte y Estadísticas - Biblioteca Universitaria</th>
        </tr>
        <tr>
            <th colspan="7" style="text-align: center;">Fecha: {{ now()->format('d/m/Y H:i') }}</th>
        </tr>
        <tr></tr>
        <tr>
            <th colspan="6" style="font-weight: bold;">Resumen General</th>
        </tr>
        <tr>
            @if(!$isStudentReport)
                <th>Total Libros</th>
            @endif
            <th>Préstamos Activos</th>
            <th>{{ $isStudentReport ? 'Libros en Préstamo Activo' : 'Libros Prestados' }}</th>
            <th>Total Préstamos</th>
            @if(!$isStudentReport)
                <th>Libros Disponibles</th>
            @endif
            <th>Préstamos Finalizados</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            @if(!$isStudentReport)
                <td>{{ $totalActiveBooks }}</td>
            @endif
            <td>{{ $activeLoans }}</td>
            <td>{{ $unavailableBooks }}</td>
            <td>{{ $totalLoans }}</td>
            @if(!$isStudentReport)
                <td>{{ $availableBooks }}</td>
            @endif
            <td>{{ $returnedLoans }}</td>
        </tr>
        <tr></tr>
        <tr>
            <th colspan="7" style="font-weight: bold;">Últimos 10 Préstamos</th>
        </tr>
        <tr>
            <th>Usuario</th>
            <th>Email</th>
            <th>Libro</th>
            <th>ISBN</th>
            <th>Fecha Salida</th>
            <th>Fecha Retorno</th>
            <th>Estado</th>
        </tr>
        @foreach($recentLoans as $loan)
        <tr>
            <td>{{ $loan->user->name }}</td>
            <td>{{ $loan->user->email }}</td>
            <td>{{ $loan->book->title }}</td>
            <td>{{ $loan->book->isbn }}</td>
            <td>{{ \Carbon\Carbon::parse($loan->loan_date)->format('d/m/Y') }}</td>
            <td>{{ $loan->return_date ? \Carbon\Carbon::parse($loan->return_date)->format('d/m/Y') : 'Pendiente' }}</td>
            <td>{{ ucfirst($loan->status) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

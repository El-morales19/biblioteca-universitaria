<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte Biblioteca</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 30px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Reporte y Estadísticas - Biblioteca Universitaria</h2>
        <p>Fecha: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <h3>Resumen General</h3>
    <table>
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
    </table>

    <h3>Últimos 10 Préstamos</h3>
    <table>
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Email</th>
                <th>Libro (ISBN)</th>
                <th>Fecha Salida</th>
                <th>Fecha Retorno</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentLoans as $loan)
            <tr>
                <td>{{ $loan->user->name }}</td>
                <td>{{ $loan->user->email }}</td>
                <td>{{ $loan->book->title }} ({{ $loan->book->isbn }})</td>
                <td>{{ \Carbon\Carbon::parse($loan->loan_date)->format('d/m/Y') }}</td>
                <td>{{ $loan->return_date ? \Carbon\Carbon::parse($loan->return_date)->format('d/m/Y') : 'Pendiente' }}</td>
                <td>{{ ucfirst($loan->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Transactions Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }
        span.red {
            color: red;
        }
    </style>
</head>

<body>
    <h1>収支報告書</h1>
    <table>
        <thead>
            <tr>
                <th>日付</th>
                <th>種別</th>
                <th>科目</th>
                <th>金額</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactionRecords as $transaction)
                <tr>
                    <td>{{ $transaction->transaction_date->format('Y.n.j') }}</td>
                    <td>{{ $transaction->type_name }}</td>
                    <td>{{ $transaction->purpose }}</td>
                    <td>
                        @if ($transaction->type === 'deposit')
                            {{ number_format($transaction->amount) }}円
                        @else
                            <span class="red">
                            - {{ number_format($transaction->amount) }}円
                            </span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"><strong>合計金額</strong></td>
                <td><strong>{{ number_format($totalAmount) }}円</strong></td>
            </tr>
        </tfoot>
    </table>
</body>

</html>

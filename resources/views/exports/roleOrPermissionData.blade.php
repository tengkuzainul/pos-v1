<!DOCTYPE html>
<html>

<head>
    <title>Point Of Sales - v1.0 | Data Role | {{ date('d F Y') }}</title>

    <style>
        * {
            margin: 15px 15px 5px;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
        }

        h1 {
            margin: 10px 0;
            text-align: center;
            font-weight: 900;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border-bottom: 1px solid black;
            border-top: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        tbody tr:nth-child(odd) {
            background-color: #c7c4c4c2;
        }

        tbody tr:nth-child(even) {
            background-color: #00c8ff70;
        }

        thead th {
            color: black;
            font-weight: 600;
        }

        /* Optional: Styling for hover effect is not supported in PDF */
    </style>
</head>

<body>
    <h1>{{ $title }}</h1>
    <table>
        <thead>
            <tr>
                <th style="width: 50px">No</th>
                <th>Role Name</th>
                <th>Guard Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $role)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->guard_name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>

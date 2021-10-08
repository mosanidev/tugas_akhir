<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form method="POST" action="{{ route('order_rates') }}">
        @csrf

        @php 
        $request = "{
            'origin_postal_code': 10110,
            'destination_postal_code': 12330,
            'couriers': 'jne,gojek,grab,jet,sicepat',
            'items': [
                {
                'name': 'Book',
                'description': 'Zero to One',
                'length': 10,
                'width': 25,
                'height': 20,
                'weight': 1000,
                'quantity': 2,
                'value': 149000,
                }
            ]
        }";
        @endphp
        <input type="text" name="parameters" value="djsahd">
        <button type="submit">submit</button>
    </form>
</body>
</html>
<body>
<h3>New Request</h3>
<ul>
    <li>Origin City: <b>{{ $from['city'] }}</b></li>
    <li>Origin State: <b>{{ $from['state_id'] }}</b></li>
    <li>Origin Zip: <b>{{ $from['zip'] }}</b></li>
    <li></li>
    <li>Destination City: <b>{{ $to['city'] }}</b></li>
    <li>Destination State: <b>{{ $to['state_id'] }}</b></li>
    <li>Destination Zip: <b>{{ $to['zip'] }}</b></li>
    <li></li>
    <li>
        Vehicle:
        <ul>
            @foreach($vehicles as $vehicle)
                <li>Vehicle {{$loop->index+1}} Year: <b>{{$vehicle['year']}}</b></li>
                <li>Vehicle {{$loop->index+1}} Make: <b>{{$vehicle['make']}}</b></li>
                <li>Vehicle {{$loop->index+1}} Model: <b>{{$vehicle['model']}}</b></li>
                <li>Vehicle {{$loop->index+1}} Runs: <b>{{$vehicle['run']}}</b></li>
            @endforeach
        </ul>
    </li>
    <li></li>
    <li>Trailer Type: <b>{{ $trailer_type }}</b></li>
    <li>Move Date: <b>{{ $date }}</b></li>
    <li></li>
    <li>Customer Name: <b>{{$name}}</b></li>
    <li>Customer Email: <b>{{$email}}</b></li>
    <li>Customer Phone: <b>{{$phone}}</b></li>
</ul>
</body>
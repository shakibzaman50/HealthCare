<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>report</title>
</head>
<body>
@if($bloodPressures->isNotEmpty())
    <table>
    <thead>
    <tr><td></td></tr>
    <tr><td></td></tr>
    <tr><td></td></tr>
    <tr><td></td></tr>
    <tr>
        <td></td>
        <td></td>
        <th><b>Date</b></th>
        <th><b>Time</b></th>
        <th><b>Reading</b></th>
        <th><b>Systolic (Upper)</b></th>
        <th><b>Diastolic (Lower)</b></th>
        <th><b>Avg (S-D)</b></th>
        <th><b>Status</b></th>
        <th><b>Note</b></th>
    </tr>
    </thead>
    <tbody>
    @foreach($bloodPressures as $bp)
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>{{ $bp['time1'] }}</td>
            <td>1</td>
            <td>{{ $bp['systolic1'] }}</td>
            <td>{{ $bp['diastolic1'] }}</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>{{ \Carbon\Carbon::create($bp['date'])->format('d-M,Y') }}</td>
            <td>{{ $bp['time2'] }}</td>
            <td>2</td>
            <td>{{ $bp['systolic2'] }}</td>
            <td>{{ $bp['diastolic2'] }}</td>
            <td>{{ $bp['avg'] }}</td>
            <td>{{ $bp['status'] }}</td>
            <td>{{ $bp['note'] }}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>{{ $bp['time3'] }}</td>
            <td>3</td>
            <td>{{ $bp['systolic3'] }}</td>
            <td>{{ $bp['diastolic3'] }}</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    @endforeach
    </tbody>
  </table>
@endif

@if($bloodSugars->isNotEmpty())
    <table>
    <thead>
    <tr><td></td></tr>
    <tr><td></td></tr>
    <tr><td></td></tr>
    <tr><td></td></tr>
    <tr>
        <td></td>
        <td></td>
        <th><b>Date</b></th>
        <th><b>Time</b></th>
        <th><b>Period</b></th>
        <th><b>BG (mg/dL)</b></th>
        <th><b>Status</b></th>
        <th><b>Note</b></th>
    </tr>
    </thead>
    <tbody>
    @foreach($bloodSugars as $date => $group)
        @foreach($group['entries'] as $j => $entry)
            <tr>
              <td></td>
              <td></td>
              @if ($j === 0)
                <td>{{ \Carbon\Carbon::create($date)->format('d-M,Y') }}</td>
              @else
                <td></td>
              @endif

              <td>{{ $entry['time'] }}</td>
              <td>{{ $entry['type'] }}</td>
              <td>{{ $entry['value'] }}</td>
              <td>{{ $entry['status'] }}</td>
              <td>{{ $entry['note'] }}</td>
            </tr>
        @endforeach
    @endforeach
    </tbody>
  </table>
@endif

</body>
</html>

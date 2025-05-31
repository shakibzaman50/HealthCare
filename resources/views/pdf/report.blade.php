<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Doctor Report</title>
</head>
<body style="margin: 0; font-family: Arial, sans-serif; position: relative;">

<div style="position: relative; z-index: 1; line-height: 1.2;">
    @if($heartRates->isNotEmpty())
        @isset($header)
            <div style="page-break-before: always; display: flex; justify-content: space-between; align-items: center;">
              <table width="100%">
                <tr>
                  <!-- Avatar -->
                  <td width="20%" style="text-align: center;">
                    <div style="width: 100px; height: 100px; border-radius: 50%; overflow: hidden; display: inline-block;">
                      <img src="{{ $user->avatar ? public_path($user->avatar) : public_path('blank.jpg') }}" style="width: 100px; height: 100px; object-fit: cover;" />
                    </div>
                  </td>

                  <!-- User Info -->
                  <td width="35%" style="text-align: left; vertical-align: top;">
                    <table width="100%">
                      <tr>
                        <td style="padding: 4px 0; font-size: 18px;"><strong>{{ $user->name }}</strong></td>
                      </tr>
                      <tr>
                        <td style="padding: 3px 0; font-size: 14px;">Age: {{ $user->birthdate ? floor(\Carbon\Carbon::create($user->birthdate)->diffInYears(\Carbon\Carbon::today())).' Years' : '' }}</td>
                      </tr>
                      <tr>
                        <td style="padding: 3px 0; font-size: 14px;">Status: {{ $user->sugar_status }}</td>
                      </tr>
                    </table>
                  </td>

                  <!-- QR Code -->
                  <td width="15%" style="text-align: center;">
                    <img src="{{ public_path('qr.png') }}" style="width: 80px; height: auto" alt="QR"/>
                  </td>

                  <!-- Date Info -->
                  <td width="30%" style="text-align: right; vertical-align: top;">
                    <table width="100%">
                      <tr>
                        <td style="padding: 4px 0; font-size: 15px;">Generated: {{ \Carbon\Carbon::today()->format('d-M,Y') }}</td>
                      </tr>
                      <tr>
                        <td style="padding: 3px 0; font-size: 14px;">From: {{ $fromDate->format('d-M,Y') }}</td>
                      </tr>
                      <tr>
                        <td style="padding: 3px 0; font-size: 14px;">To: {{ $toDate->format('d-M,Y') }}</td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
              <hr>
            </div>
            <div></div>
            <h4 style="margin-top: 15px;">Blood Sugar - {{ $days }}</h4>
        @endisset
        <table style="width: 100%; font-size: 13px; border-collapse: collapse; margin-top: 10px;">
            <tr>
              <td width="50%" style="padding: 6px 5px 0">Avg Blood Sugar <strong>85 mg/dL</strong></td>
              <td width="50%" style="text-align: right">1 Hour Postprandial Blood Sugar Normal <strong>85 - 95 mg/dL</strong></td>
            </tr>
            <tr>
              <td>Fasting Blood Sugar Normal <strong>70 - 90 mg/dL</strong></td>
              <td style="text-align: right">1 Hour Postprandial Blood Sugar Normal  <strong>85 - 95 mg/dL</strong></td>
            </tr>
        </table>
        <hr>
        <table style="width: 100%; font-size: 13px; border-collapse: collapse; margin-top: 15px;">
            <thead>
            <tr>
              <th style="border: 1px solid #000; padding: 6px 5px; text-align: center;">Date</th>
              <th style="border: 1px solid #000; padding: 6px 5px; text-align: center;">Time</th>
              <th style="border: 1px solid #000; padding: 6px 5px; text-align: center;">Heart Rate</th>
              <th style="border: 1px solid #000; padding: 6px 5px; text-align: center;">Status</th>
              <th style="border: 1px solid #000; padding: 6px 5px; text-align: center;">HRV</th>
              <th style="border: 1px solid #000; padding: 6px 5px; text-align: center;">HRV Status</th>
              <th style="border: 1px solid #000; padding: 6px 5px; text-align: center;">Stress</th>
            </tr>
            </thead>
            <tbody>
            @foreach($heartRates as $date => $group)
                @foreach($group['entries'] as $j => $entry)
                <tr>
                    @if ($j === 0)
                      <td rowspan="{{ count($group['entries']) }}" style="border: 1px solid #000; padding: 6px 5px; text-align: center;">{{ \Carbon\Carbon::create($date)->format('d-M,Y') }}</td>
                    @endif

                    <td style="border: 1px solid #000; padding: 6px 5px; text-align: center;">{{ $entry['time'] }}</td>
                    <td style="border: 1px solid #000; padding: 6px 5px; text-align: center;">{{ $entry['heart_rate'] }}</td>
                    <td style="border: 1px solid #000; padding: 6px 5px; text-align: center;">{{ $entry['status'] }}</td>
                    <td style="border: 1px solid #000; padding: 6px 5px; text-align: center;">{{ $entry['hrv'] }}</td>
                    <td style="border: 1px solid #000; padding: 6px 5px; text-align: center;">{{ $entry['hrv_status'] }}</td>
                    <td style="border: 1px solid #000; padding: 6px 5px; text-align: center;">{{ $entry['stress'] }}</td>
                </tr>
              @endforeach
            @endforeach
            </tbody>
        </table>
    @endif

    @if($bloodPressures->isNotEmpty())
        @isset($header)
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <table width="100%">
                <tr>
                <!-- Avatar -->
                <td width="20%" style="text-align: center;">
                    <div style="width: 100px; height: 100px; border-radius: 50%; overflow: hidden; display: inline-block;">
                        <img src="{{ $user->avatar ? public_path($user->avatar) : public_path('blank.jpg') }}" style="width: 100px; height: 100px; object-fit: cover;" />
                    </div>
                </td>

                <!-- User Info -->
                <td width="35%" style="text-align: left; vertical-align: top;">
                    <table width="100%">
                        <tr>
                            <td style="padding: 4px 0; font-size: 18px;"><strong>{{ $user->name }}</strong></td>
                        </tr>
                        <tr>
                            <td style="padding: 3px 0; font-size: 14px;">Age: {{ $user->birthdate ? floor(\Carbon\Carbon::create($user->birthdate)->diffInYears(\Carbon\Carbon::today())).' Years' : '' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 3px 0; font-size: 14px;">Status: {{ $user->bp_status }}</td>
                        </tr>
                    </table>
                </td>

                <!-- QR Code -->
                <td width="15%" style="text-align: center;">
                   <img src="{{ public_path('qr.png') }}" style="width: 80px; height: auto" alt="QR"/>
                </td>

                <!-- Date Info -->
                <td width="30%" style="text-align: right; vertical-align: top;">
                    <table width="100%">
                        <tr>
                            <td style="padding: 4px 0; font-size: 15px;">Generated: {{ \Carbon\Carbon::today()->format('d-M,Y') }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 3px 0; font-size: 14px;">From: {{ $fromDate->format('d-M,Y') }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 3px 0; font-size: 14px;">To: {{ $toDate->format('d-M,Y') }}</td>
                        </tr>
                    </table>
                </td>
              </tr>
            </table>
            <hr>
        </div>
        <h4 style="margin-top: 15px;">Blood Pressure - {{ $days }}</h4>
        @endisset
        <table style="width: 100%; font-size: 13px; border-collapse: collapse; margin-top: 10px;">
            <tr>
                <td width="33%" style="padding: 6px 5px 0">Avg BP <strong>120 / 85 mmHg</strong></td>
                <td width="30%">BP Normal <strong>120 / 80 mmHg</strong></td>
                <td width="37%" style="text-align: right">BP Elevated <strong>121-139/81-89 mmHg</strong></td>
            </tr>
            <tr>
                <td>Avg State <strong>Normal BP</strong></td>
                <td>BP Low <strong>90 / 60</strong></td>
                <td style="text-align: right">BP Hypertensive <strong>140/90 mmHg</strong></td>
            </tr>
        </table>
        <hr>
        <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
        <thead>
        <tr>
            <th style="border: 1px solid #000; padding: 6px 5px; text-align: center; font-size: 13px;">Date</th>
            <th style="border: 1px solid #000; padding: 6px 5px; text-align: center; font-size: 13px;">Time</th>
            <th style="border: 1px solid #000; padding: 6px 5px; text-align: center; font-size: 13px;">Systolic<br>(Upper)</th>
            <th style="border: 1px solid #000; padding: 6px 5px; text-align: center; font-size: 13px;">Diastolic<br>(Lower)</th>
            <th style="border: 1px solid #000; padding: 6px 5px; text-align: center; font-size: 13px;">Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach($bloodPressures as $date => $group)
            @foreach($group['entries'] as $j => $entry)
                <tr>
                    @if ($j === 0)
                      <td rowspan="{{ count($group['entries']) }}" style="border: 1px solid #000; padding: 6px 5px; text-align: center;">{{ \Carbon\Carbon::create($date)->format('d-M,Y') }}</td>
                    @endif
                    <td style="border: 1px solid #000; padding: 6px 5px; text-align: center; font-size: 13px;">{{ $entry['time'] }}</td>
                    <td style="border: 1px solid #000; padding: 6px 5px; text-align: center; font-size: 13px;">{{ $entry['systolic'] }}</td>
                    <td style="border: 1px solid #000; padding: 6px 5px; text-align: center; font-size: 13px;">{{ $entry['diastolic'] }}</td>
                    <td style="border: 1px solid #000; padding: 6px 5px; text-align: center; font-size: 13px;">{{ $entry['status'] }}</td>
                </tr>
            @endforeach
        @endforeach
        </tbody>
      </table>
    @endif

    @if($bloodSugars->isNotEmpty())
        @isset($header)
        <div style="page-break-before: always; display: flex; justify-content: space-between; align-items: center;">
            <table width="100%">
                <tr>
                <!-- Avatar -->
                <td width="20%" style="text-align: center;">
                    <div style="width: 100px; height: 100px; border-radius: 50%; overflow: hidden; display: inline-block;">
                        <img src="{{ $user->avatar ? public_path($user->avatar) : public_path('blank.jpg') }}" style="width: 100px; height: 100px; object-fit: cover;" />
                    </div>
                </td>

                <!-- User Info -->
                <td width="35%" style="text-align: left; vertical-align: top;">
                    <table width="100%">
                        <tr>
                            <td style="padding: 4px 0; font-size: 18px;"><strong>{{ $user->name }}</strong></td>
                        </tr>
                        <tr>
                            <td style="padding: 3px 0; font-size: 14px;">Age: {{ $user->birthdate ? floor(\Carbon\Carbon::create($user->birthdate)->diffInYears(\Carbon\Carbon::today())).' Years' : '' }}</td>
                        </tr>
                        <tr>
                           <td style="padding: 3px 0; font-size: 14px;">Status: {{ $user->sugar_status }}</td>
                        </tr>
                    </table>
                </td>

                <!-- QR Code -->
                <td width="15%" style="text-align: center;">
                    <img src="{{ public_path('qr.png') }}" style="width: 80px; height: auto" alt="QR"/>
                </td>

                <!-- Date Info -->
                <td width="30%" style="text-align: right; vertical-align: top;">
                    <table width="100%">
                        <tr>
                            <td style="padding: 4px 0; font-size: 15px;">Generated: {{ \Carbon\Carbon::today()->format('d-M,Y') }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 3px 0; font-size: 14px;">From: {{ $fromDate->format('d-M,Y') }}</td>
                        </tr>
                        <tr>
                           <td style="padding: 3px 0; font-size: 14px;">To: {{ $toDate->format('d-M,Y') }}</td>
                        </tr>
                    </table>
                </td>
                </tr>
            </table>
            <hr>
        </div>
        <div></div>
        <h4 style="margin-top: 15px;">Blood Sugar - {{ $days }}</h4>
        @endisset
        <table style="width: 100%; font-size: 13px; border-collapse: collapse; margin-top: 10px;">
            <tr>
                <td width="50%" style="padding: 6px 5px 0">Avg Blood Sugar <strong>85 mg/dL</strong></td>
                <td width="50%" style="text-align: right">1 Hour Postprandial Blood Sugar Normal <strong>85 - 95 mg/dL</strong></td>
            </tr>
            <tr>
                <td>Fasting Blood Sugar Normal <strong>70 - 90 mg/dL</strong></td>
                <td style="text-align: right">1 Hour Postprandial Blood Sugar Normal  <strong>85 - 95 mg/dL</strong></td>
            </tr>
        </table>
        <hr>
        <table style="width: 100%; font-size: 13px; border-collapse: collapse; margin-top: 15px;">
            <thead>
            <tr>
                <th style="border: 1px solid #000; padding: 6px 5px; text-align: center;">Date</th>
                <th style="border: 1px solid #000; padding: 6px 5px; text-align: center;">Time</th>
                <th style="border: 1px solid #000; padding: 6px 5px; text-align: center;">Schedule</th>
                <th style="border: 1px solid #000; padding: 6px 5px; text-align: center;">BG</th>
                <th style="border: 1px solid #000; padding: 6px 5px; text-align: center;">Status</th>
            </tr>
            </thead>
            <tbody>
                @foreach($bloodSugars as $date => $group)
                    @foreach($group['entries'] as $j => $entry)
                        <tr>
                            @if ($j === 0)
                                <td rowspan="{{ count($group['entries']) }}" style="border: 1px solid #000; padding: 6px 5px; text-align: center;">{{ \Carbon\Carbon::create($date)->format('d-M,Y') }}</td>
                            @endif
                            <td style="border: 1px solid #000; padding: 6px 5px; text-align: center;">{{ $entry['time'] }}</td>
                            <td style="border: 1px solid #000; padding: 6px 5px; text-align: center;">{{ $entry['schedule'] }}</td>
                            <td style="border: 1px solid #000; padding: 6px 5px; text-align: center;">{{ $entry['level'] }}</td>
                            <td style="border: 1px solid #000; padding: 6px 5px; text-align: center;">{{ $entry['status'] }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    @endif

    @if($bloodOxygens->isNotEmpty())
        @isset($header)
            <div style="display: flex; justify-content: space-between; align-items: center;">
              <table width="100%">
                <tr>
                  <!-- Avatar -->
                  <td width="20%" style="text-align: center;">
                    <div style="width: 100px; height: 100px; border-radius: 50%; overflow: hidden; display: inline-block;">
                      <img src="{{ $user->avatar ? public_path($user->avatar) : public_path('blank.jpg') }}" style="width: 100px; height: 100px; object-fit: cover;" />
                    </div>
                  </td>

                  <!-- User Info -->
                  <td width="35%" style="text-align: left; vertical-align: top;">
                    <table width="100%">
                      <tr>
                        <td style="padding: 4px 0; font-size: 18px;"><strong>{{ $user->name }}</strong></td>
                      </tr>
                      <tr>
                        <td style="padding: 3px 0; font-size: 14px;">Age: {{ $user->birthdate ? floor(\Carbon\Carbon::create($user->birthdate)->diffInYears(\Carbon\Carbon::today())).' Years' : '' }}</td>
                      </tr>
                      <tr>
                        <td style="padding: 3px 0; font-size: 14px;">Status: {{ $user->bp_status }}</td>
                      </tr>
                    </table>
                  </td>

                  <!-- QR Code -->
                  <td width="15%" style="text-align: center;">
                    <img src="{{ public_path('qr.png') }}" style="width: 80px; height: auto" alt="QR"/>
                  </td>

                  <!-- Date Info -->
                  <td width="30%" style="text-align: right; vertical-align: top;">
                    <table width="100%">
                      <tr>
                        <td style="padding: 4px 0; font-size: 15px;">Generated: {{ \Carbon\Carbon::today()->format('d-M,Y') }}</td>
                      </tr>
                      <tr>
                        <td style="padding: 3px 0; font-size: 14px;">From: {{ $fromDate->format('d-M,Y') }}</td>
                      </tr>
                      <tr>
                        <td style="padding: 3px 0; font-size: 14px;">To: {{ $toDate->format('d-M,Y') }}</td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
              <hr>
            </div>
            <h4 style="margin-top: 15px;">Blood Pressure - {{ $days }}</h4>
        @endisset
        <table style="width: 100%; font-size: 13px; border-collapse: collapse; margin-top: 10px;">
            <tr>
                <td width="33%" style="padding: 6px 5px 0">Avg BP <strong>120 / 85 mmHg</strong></td>
                <td width="30%">BP Normal <strong>120 / 80 mmHg</strong></td>
                <td width="37%" style="text-align: right">BP Elevated <strong>121-139/81-89 mmHg</strong></td>
            </tr>
            <tr>
                <td>Avg State <strong>Normal BP</strong></td>
                <td>BP Low <strong>90 / 60</strong></td>
                <td style="text-align: right">BP Hypertensive <strong>140/90 mmHg</strong></td>
            </tr>
        </table>
        <hr>
        <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
            <thead>
            <tr>
                <th style="border: 1px solid #000; padding: 6px 5px; text-align: center; font-size: 13px;">Date</th>
                <th style="border: 1px solid #000; padding: 6px 5px; text-align: center; font-size: 13px;">Time</th>
                <th style="border: 1px solid #000; padding: 6px 5px; text-align: center; font-size: 13px;">Oxygen Level</th>
                <th style="border: 1px solid #000; padding: 6px 5px; text-align: center; font-size: 13px;">Status</th>
            </tr>
            </thead>
            <tbody>
            @foreach($bloodOxygens as $date => $group)
                @foreach($group['entries'] as $j => $entry)
                    <tr>
                        @if ($j === 0)
                            <td rowspan="{{ count($group['entries']) }}" style="border: 1px solid #000; padding: 6px 5px; text-align: center;">{{ \Carbon\Carbon::create($date)->format('d-M,Y') }}</td>
                        @endif
                        <td style="border: 1px solid #000; padding: 6px 5px; text-align: center; font-size: 13px;">{{ $entry['time'] }}</td>
                        <td style="border: 1px solid #000; padding: 6px 5px; text-align: center; font-size: 13px;">{{ $entry['oxygen_level'] }}</td>
                        <td style="border: 1px solid #000; padding: 6px 5px; text-align: center; font-size: 13px;">{{ $entry['status'] }}</td>
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
    @endif

    @if($waterIntakes->isNotEmpty())
        @isset($header)
          <div style="display: flex; justify-content: space-between; align-items: center;">
            <table width="100%">
              <tr>
                <!-- Avatar -->
                <td width="20%" style="text-align: center;">
                  <div style="width: 100px; height: 100px; border-radius: 50%; overflow: hidden; display: inline-block;">
                    <img src="{{ $user->avatar ? public_path($user->avatar) : public_path('blank.jpg') }}" style="width: 100px; height: 100px; object-fit: cover;" />
                  </div>
                </td>

                <!-- User Info -->
                <td width="35%" style="text-align: left; vertical-align: top;">
                  <table width="100%">
                    <tr>
                      <td style="padding: 4px 0; font-size: 18px;"><strong>{{ $user->name }}</strong></td>
                    </tr>
                    <tr>
                      <td style="padding: 3px 0; font-size: 14px;">Age: {{ $user->birthdate ? floor(\Carbon\Carbon::create($user->birthdate)->diffInYears(\Carbon\Carbon::today())).' Years' : '' }}</td>
                    </tr>
                    <tr>
                      <td style="padding: 3px 0; font-size: 14px;">Status: {{ $user->bp_status }}</td>
                    </tr>
                  </table>
                </td>

                <!-- QR Code -->
                <td width="15%" style="text-align: center;">
                  <img src="{{ public_path('qr.png') }}" style="width: 80px; height: auto" alt="QR"/>
                </td>

                <!-- Date Info -->
                <td width="30%" style="text-align: right; vertical-align: top;">
                  <table width="100%">
                    <tr>
                      <td style="padding: 4px 0; font-size: 15px;">Generated: {{ \Carbon\Carbon::today()->format('d-M,Y') }}</td>
                    </tr>
                    <tr>
                      <td style="padding: 3px 0; font-size: 14px;">From: {{ $fromDate->format('d-M,Y') }}</td>
                    </tr>
                    <tr>
                      <td style="padding: 3px 0; font-size: 14px;">To: {{ $toDate->format('d-M,Y') }}</td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            <hr>
          </div>
          <h4 style="margin-top: 15px;">Blood Pressure - {{ $days }}</h4>
        @endisset
        <table style="width: 100%; font-size: 13px; border-collapse: collapse; margin-top: 10px;">
            <tr>
                <td width="33%" style="padding: 6px 5px 0">Avg BP <strong>120 / 85 mmHg</strong></td>
                <td width="30%">BP Normal <strong>120 / 80 mmHg</strong></td>
                <td width="37%" style="text-align: right">BP Elevated <strong>121-139/81-89 mmHg</strong></td>
            </tr>
            <tr>
                <td>Avg State <strong>Normal BP</strong></td>
                <td>BP Low <strong>90 / 60</strong></td>
                <td style="text-align: right">BP Hypertensive <strong>140/90 mmHg</strong></td>
            </tr>
        </table>
        <hr>
        <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
            <thead>
            <tr>
              <th style="border: 1px solid #000; padding: 6px 5px; text-align: center; font-size: 13px;">Date</th>
              <th style="border: 1px solid #000; padding: 6px 5px; text-align: center; font-size: 13px;">Time</th>
              <th style="border: 1px solid #000; padding: 6px 5px; text-align: center; font-size: 13px;">Amount</th>
              <th style="border: 1px solid #000; padding: 6px 5px; text-align: center; font-size: 13px;">Done</th>
              <th style="border: 1px solid #000; padding: 6px 5px; text-align: center; font-size: 13px;">Status</th>
            </tr>
            </thead>
            <tbody>
            @foreach($waterIntakes as $date => $group)
                @foreach($group['entries'] as $j => $entry)
                    <tr>
                        @if ($j === 0)
                            <td rowspan="{{ count($group['entries']) }}" style="border: 1px solid #000; padding: 6px 5px; text-align: center;">{{ \Carbon\Carbon::create($date)->format('d-M,Y') }}</td>
                        @endif
                        <td style="border: 1px solid #000; padding: 6px 5px; text-align: center; font-size: 13px;">{{ $entry['time'] }}</td>
                        <td style="border: 1px solid #000; padding: 6px 5px; text-align: center; font-size: 13px;">{{ $entry['amount'] }}</td>
                        <td style="border: 1px solid #000; padding: 6px 5px; text-align: center; font-size: 13px;">{{ $entry['done'] }}</td>
                        <td style="border: 1px solid #000; padding: 6px 5px; text-align: center; font-size: 13px;">{{ $entry['status'] }}</td>
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
      @endif
</div>
</body>
</html>

<!-- resources/views/emails/kyc_status_notification.blade.php -->

<!DOCTYPE html>
<html>

<head>
    <title>KYC Status Update</title>
</head>

<body>
    <p>Dear {{ $customer->name }},</p>

    <p>Your KYC application has been {{ $kyc['status'] }}.</p>

    @if($kyc['status'] === 'approved')
    <p>Thank you for submitting your KYC details. Your account is now verified.</p>
    @else
    <p>Unfortunately, your KYC application has been rejected. Please contact support for more information.</p>
    @endif

    <p>Regards,<br>Your Company Name</p>
</body>

</html>
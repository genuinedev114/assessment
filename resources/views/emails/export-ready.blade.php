<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Ready</title>
</head>
<body style="font-family: Arial, sans-serif; color: #1f2937; line-height: 1.5;">
    <p>Hello {{ $user->name }},</p>

    <p>Your export for store <strong>#{{ $store->number }}</strong> is ready.</p>

    <p>
        File: <strong>{{ $filename }}</strong><br>
        You can access your exports from the dashboard Downloads page.
    </p>

    <p>
        <a href="{{ route('export.downloads') }}" style="display:inline-block;padding:10px 14px;background:#2d1b69;color:#ffffff;text-decoration:none;border-radius:6px;">
            Open Downloads
        </a>
    </p>

    <p>Thank you.</p>
</body>
</html>

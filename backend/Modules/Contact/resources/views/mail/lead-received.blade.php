<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новая заявка</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
        .wrapper { max-width: 560px; margin: 32px auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.08); }
        .header { background: #1a1a2e; padding: 24px 32px; }
        .header h1 { color: #fff; margin: 0; font-size: 20px; }
        .body { padding: 28px 32px; }
        .label { font-size: 11px; text-transform: uppercase; letter-spacing: .05em; color: #888; margin-bottom: 2px; }
        .value { font-size: 15px; color: #111; margin-bottom: 20px; word-break: break-all; }
        .footer { background: #f9f9f9; border-top: 1px solid #eee; padding: 16px 32px; font-size: 12px; color: #aaa; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <h1>🔔 Новая заявка с сайта</h1>
    </div>
    <div class="body">

        @if($lead->service)
            <div class="label">Услуга</div>
            <div class="value">{{ $lead->service->title }}</div>
        @endif

        <div class="label">Email</div>
        <div class="value">{{ $lead->email }}</div>

        @if($lead->phone)
            <div class="label">Телефон</div>
            <div class="value">{{ trim(($lead->phone_country_code ?? '') . ' ' . $lead->phone) }}</div>
        @endif

        <div class="label">Язык</div>
        <div class="value">{{ strtoupper($lead->locale) }}</div>

        <div class="label">Источник</div>
        <div class="value">{{ $lead->source }}</div>

        <div class="label">Дата</div>
        <div class="value">{{ $lead->created_at->format('d.m.Y H:i') }}</div>

    </div>
    <div class="footer">
        {{ config('app.name') }} &mdash; автоматическое уведомление
    </div>
</div>
</body>
</html>

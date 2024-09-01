<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Post Item</title>
    <style>
        @page {
            size: 3.15in;
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0.2in;
            width: auto;
            line-height: 1.2;
            font-size: 7pt;
            font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
        }

        table {
            width: 100%;
            table-layout: fixed;
        }

        th, td {
            padding: 2px 0;
            text-align: left
        }

        .title {
            font-size: 10pt;
            font-weight: bold;
            text-align: center;
            margin-bottom: -5px;
        }

        .subtitle {
            text-align: center;
            color: #71717a;
        }
    </style>
</head>
<body>
<div>
<h1 class="title">{{ config('app.name') }}</h1>
    <p class="subtitle">{{ now()->format('d F Y H:i') }}</p>
    <table>
        <thead>
        <tr>
            <th style="width: 60%">Category</th>
            <th style="width: 60%">Nama</th>
            <th style="text-align: right;width: 40%">Views</th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td style="width: 60%">{{ $post->category->name }}</td>
                <td style="width: 40%; letter-spacing: -1.5px; text-align: left;font-family: 'monospace'">{{ $post->name }}</td>
                <td style="text-align: right;font-family: 'monospace'">{{ $post->views }}</td>
            </tr>
        </tbody>
    </table>
</div>
</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contrat de Mission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .contract-box {
            width: 100%;
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            background-color: #fff;
        }

        .contract-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .contract-header img {
            max-width: 100px;
        }

        .contract-header h1 {
            margin: 10px 0;
            font-size: 24px;
            color: #007bff;
        }

        .contract-details {
            margin-bottom: 20px;
        }

        .contract-details p {
            margin: 5px 0;
        }

        .contract-details strong {
            font-size: 18px;
            color: #000;
        }

        .contract-items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .contract-items th, .contract-items td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .contract-items th {
            background-color: #007bff;
            color: #fff;
        }

        .contract-footer {
            text-align: center;
            color: #777;
            margin-top: 30px;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="contract-box">
    <div class="contract-header">
{{--        <img src="https://yourwebsite.com/logo.png" alt="Company Logo">--}}
        <h1>Contrat de Mission</h1>
    </div>

    <div class="contract-details">
        <p><strong>Nom du Consultant:</strong> {{ $consultant->user->name }}</p>
        <p><strong>Email du Consultant:</strong> {{ $consultant->user->email }}</p>
        <p><strong>Mission Attribuée:</strong> {{ $mission->titre }}</p>
        <p><strong>Date de Début:</strong> {{ $mission->date_debut }}</p>
        <p><strong>Date de Fin:</strong> {{ $mission->date_fin }}</p>
        <p><strong>Client:</strong> {{ $mission->client_id}}</p>
        <p><strong>Détails de la Mission:</strong> {{ $mission->description }}</p>
    </div>

{{--    <table class="contract-items">--}}
{{--        <thead>--}}
{{--        <tr>--}}
{{--            <th>Tâche</th>--}}
{{--            <th>Responsabilité</th>--}}
{{--        </tr>--}}
{{--        </thead>--}}
{{--        <tbody>--}}
{{--        @foreach ($mission->tasks as $task)--}}
{{--            <tr>--}}
{{--                <td>{{ $task->titre }}</td>--}}
{{--                <td>{{ $task->responsibility }}</td>--}}
{{--            </tr>--}}
{{--        @endforeach--}}
{{--        </tbody>--}}
{{--    </table>--}}

    <div class="contract-footer">
        <p>Merci de votre engagement avec notre organisation!</p>
        <p>Ce contrat est valide à partir de {{ $mission->date_debut }} jusqu'à {{ $mission->date_fin }}.</p>
    </div>
</div>
</body>
</html>

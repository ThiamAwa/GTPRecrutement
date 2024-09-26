<!DOCTYPE html>
<html>
<head>
    <title>Attribution de Mission</title>
    <style>
        .button {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 16px;
            color: white;
            border-radius: 5px;
            margin: 5px;
        }
        .accept-button {
            background-color: green;
        }
        .reject-button {
            background-color: red;
        }
    </style>
</head>
<body>
<h1>Bonjour {{ $mission->consultant->user->name }},</h1>
<p>Vous avez été attribué à la mission suivante :</p>
<p><strong>Titre :</strong> {{ $mission->titre }}</p>
<p><strong>Description :</strong> {{ $mission->description }}</p>
{{--<p><strong>Client :</strong> {{ $mission->client->user->name }}</p> <!-- Ajout du nom du client -->--}}
<p><strong>Date de début :</strong> {{ $mission->date_debut }}</p>
<p><strong>Date de fin :</strong> {{ $mission->date_fin }}</p>


<a href="{{ route('mission.accept', ['mission_id' => $mission->id, 'consultant_id' => $mission->consultant->id]) }}" class="button accept-button">Accepter</a>
<a href="{{ route('mission.reject', ['mission_id' => $mission->id, 'consultant_id' => $mission->consultant->id]) }}" class="button reject-button">Refuser</a>
<p>Veuillez consulter le contrat joint pour plus de détails.</p>
<p>Cordialement,</p>
<p>L'équipe de GTP</p>
</body>
</html>


    <div class="container">
        <h1>Tableau de bord</h1>

        <h3>Notifications</h3>
        <ul>
            @foreach($notifications as $notification)
                <li>
                    <strong>Nouvelle mission soumise :</strong> {{ $notification->data['titre'] }}
                    <br>
                    <strong>Description :</strong> {{ $notification->data['description'] }}
                    <br>
                    <strong>Date de début :</strong> {{ $notification->data['date_debut'] }}
                    <br>
                    <strong>Date de fin :</strong> {{ $notification->data['date_fin'] ?? 'Non spécifiée' }}
                    <br>
                    <small>Reçue {{ $notification->created_at->diffForHumans() }}</small>
                </li>
            @endforeach
        </ul>
    </div>


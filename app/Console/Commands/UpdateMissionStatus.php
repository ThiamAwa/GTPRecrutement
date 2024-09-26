<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Mission;
use Carbon\Carbon;

class UpdateMissionStatus extends Command
{
    protected $signature = 'missions:update-status';
    protected $description = 'Met à jour le statut des missions selon la date de fin';

    public function handle()
    {
        $today = Carbon::today();

        // Récupérer toutes les missions dont la date de fin est aujourd'hui
        $missions = Mission::where('date_fin', $today)->get();

        foreach ($missions as $mission) {
            // Mettre à jour le statut à 'terminee'
            $mission->status = 'terminee';
            $mission->save();
        }

        $this->info('Statuts des missions mis à jour avec succès.');
    }
}

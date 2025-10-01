<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        // Mock data for now - will be replaced with real data later
        $stats = [
            'total_occurrences' => 1247,
            'resolved_occurrences' => 892,
            'active_users' => 156
        ];

        $recentOccurrences = [
            [
                'id' => 1,
                'title' => 'Furto de veículo',
                'description' => 'Veículo furtado na QNM 36',
                'type' => 'Furto',
                'location' => 'QNM 36, Ceilândia Norte',
                'created_at' => now()->subHours(2)
            ],
            [
                'id' => 2,
                'title' => 'Assalto a pedestre',
                'description' => 'Assalto próximo ao terminal rodoviário',
                'type' => 'Assalto',
                'location' => 'Terminal Rodoviário, Ceilândia',
                'created_at' => now()->subHours(4)
            ],
            [
                'id' => 3,
                'title' => 'Vandalismo',
                'description' => 'Pichação em prédio público',
                'type' => 'Vandalismo',
                'location' => 'QNM 28, Ceilândia Norte',
                'created_at' => now()->subHours(6)
            ]
        ];

        return Inertia::render('Home', [
            'stats' => $stats,
            'recentOccurrences' => $recentOccurrences
        ]);
    }

    /**
     * Display the about page.
     */
    public function about()
    {
        return Inertia::render('About');
    }

    /**
     * Display the contact page.
     */
    public function contact()
    {
        return Inertia::render('Contact');
    }

    /**
     * Display the statistics page.
     */
    public function statistics()
    {
        return Inertia::render('Statistics');
    }

    /**
     * Display the dashboard page.
     */
    public function dashboard()
    {
        return Inertia::render('Dashboard');
    }
}

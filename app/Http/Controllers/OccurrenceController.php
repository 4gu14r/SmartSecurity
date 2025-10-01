<?php

namespace App\Http\Controllers;

use App\Models\Occurrence;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OccurrenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Occurrence::with(['user', 'user.profile'])
            ->orderBy('created_at', 'desc');

        // Apply filters
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $occurrences = $query->paginate(20)->withQueryString();

        return Inertia::render('Occurrences/Index', [
            'occurrences' => $occurrences,
            'filters' => $request->only(['type', 'status', 'location', 'search']),
            'types' => Occurrence::getTypes(),
            'statuses' => Occurrence::getStatuses(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Occurrences/Create', [
            'types' => Occurrence::getTypes(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:100',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'occurred_at' => 'required|date',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['user_id'] = Auth::id();

        // Handle image uploads
        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('occurrences', 'public');
                $imagePaths[] = $path;
            }
            $validated['images'] = $imagePaths;
        }

        $occurrence = Occurrence::create($validated);

        return redirect()->route('occurrences.show', $occurrence)
            ->with('success', 'Ocorrência criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Occurrence $occurrence)
    {
        $occurrence->load(['user', 'user.profile', 'comments.user']);
        $occurrence->incrementViews();

        return Inertia::render('Occurrences/Show', [
            'occurrence' => $occurrence,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Occurrence $occurrence)
    {
        // Check if user can edit this occurrence
        if ($occurrence->user_id !== Auth::id() && !Auth::user()->profile->name === 'Administrador') {
            abort(403, 'Você não tem permissão para editar esta ocorrência.');
        }

        return Inertia::render('Occurrences/Edit', [
            'occurrence' => $occurrence,
            'types' => Occurrence::getTypes(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Occurrence $occurrence)
    {
        // Check if user can update this occurrence
        if ($occurrence->user_id !== Auth::id() && !Auth::user()->profile->name === 'Administrador') {
            abort(403, 'Você não tem permissão para atualizar esta ocorrência.');
        }

        $validated = $request->validate([
            'type' => 'required|string|max:100',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'occurred_at' => 'required|date',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'status' => 'sometimes|in:pending,verified,rejected',
        ]);

        $occurrence->update($validated);

        return redirect()->route('occurrences.show', $occurrence)
            ->with('success', 'Ocorrência atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Occurrence $occurrence)
    {
        // Check if user can delete this occurrence
        if ($occurrence->user_id !== Auth::id() && !Auth::user()->profile->name === 'Administrador') {
            abort(403, 'Você não tem permissão para excluir esta ocorrência.');
        }

        // Delete associated images
        if ($occurrence->images) {
            foreach ($occurrence->images as $imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        $occurrence->delete();

        return redirect()->route('occurrences.index')
            ->with('success', 'Ocorrência excluída com sucesso!');
    }

    /**
     * Get statistics for the dashboard.
     */
    public function statistics()
    {
        $stats = [
            'total_occurrences' => Occurrence::count(),
            'pending_occurrences' => Occurrence::where('status', 'pending')->count(),
            'verified_occurrences' => Occurrence::where('status', 'verified')->count(),
            'rejected_occurrences' => Occurrence::where('status', 'rejected')->count(),
            'today_occurrences' => Occurrence::whereDate('created_at', today())->count(),
            'week_occurrences' => Occurrence::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'month_occurrences' => Occurrence::whereMonth('created_at', now()->month)->count(),
        ];

        $typeStats = Occurrence::selectRaw('type, COUNT(*) as count')
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();

        $locationStats = Occurrence::selectRaw('location, COUNT(*) as count')
            ->groupBy('location')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->pluck('count', 'location')
            ->toArray();

        return Inertia::render('Statistics', [
            'stats' => $stats,
            'typeStats' => $typeStats,
            'locationStats' => $locationStats,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\TourPackage;
use Illuminate\Http\Request;

class PemanduWisataController extends Controller
{
    public function index()
    {
        $agents = Agent::whereIn('agent_type', ['TOUR', 'BOTH'])
                       ->where('is_verified', true)
                       ->orderBy('created_at', 'desc')
                       ->get();

        return view('wisatawan.pemanduWisata.index', compact('agents'));
    }

    public function show(Agent $agent)
    {
        if (!in_array($agent->agent_type, ['TOUR', 'BOTH'])) {
             return redirect()->route('pemandu-wisata.index')->with('error', 'Agen tidak ditemukan atau bukan agen tour.');
        }

        // PERBAIKAN: Ubah 'packages' menjadi 'tourPackages' sesuai nama fungsi di Model Agent
        $tourPackages = $agent->tourPackages; 

        return view('wisatawan.pemanduWisata.detailAgen', compact('agent', 'tourPackages'));
    }

    public function packages(Agent $agent)
    {
        if (!in_array($agent->agent_type, ['TOUR', 'BOTH'])) {
             return redirect()->route('pemandu-wisata.index');
        }

        // PERBAIKAN: Ubah 'packages' menjadi 'tourPackages'
        $tourPackages = $agent->tourPackages;
        
        return view('wisatawan.pemanduWisata.packages', compact('agent', 'tourPackages'));
    }

    public function packageDetail(Agent $agent, TourPackage $tourPackage)
    {
        if (!in_array($agent->agent_type, ['TOUR', 'BOTH'])) {
             return redirect()->route('pemandu-wisata.index');
        }
        return view('wisatawan.pemanduWisata.package-detail', compact('agent', 'tourPackage'));
    }
}
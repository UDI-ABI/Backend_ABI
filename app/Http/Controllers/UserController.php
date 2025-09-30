<?php

namespace App\Http\Controllers;

use App\Models\ResearchStaff\ResearchStaffCityProgram;
use App\Models\ResearchStaff\ResearchStaffProfessor;
use App\Models\ResearchStaff\ResearchStaffResearchStaff;
use App\Models\ResearchStaff\ResearchStaffStudent;
use App\Models\ResearchStaff\ResearchStaffUser;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        // Obtener parámetros de filtrado y búsqueda
        $search = $request->get('search');
        $role = $request->get('role');
        $state = $request->get('state');
        $cityProgramId = $request->get('city_program_id');
        $perPageOptions = [10, 20, 30];
        $perPage = (int) $request->get('per_page', $perPageOptions[0]);

        if (!in_array($perPage, $perPageOptions, true)) {
            $perPage = $perPageOptions[0];
        }

        // Query base
        $query = ResearchStaffUser::query();

        // Aplicar filtros
        if ($role) {
            $query->where('role', $role);
        }

        if ($state) {
            $query->where('state', $state);
        }

        if ($cityProgramId) {
            $studentIds = ResearchStaffStudent::where('city_program_id', $cityProgramId)->pluck('user_id');
            $professorIds = ResearchStaffProfessor::where('city_program_id', $cityProgramId)->pluck('user_id');
            
            $query->where(function ($q) use ($studentIds, $professorIds) {
                $q->whereIn('id', $studentIds)
                    ->orWhereIn('id', $professorIds);
            });
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('email', 'like', '%' . $search . '%');
                
                if (is_numeric($search)) {
                    $q->orWhere('id', $search);
                }
                
                $searchTerm = '%' . $search . '%';
                
                $studentIds = ResearchStaffStudent::where('name', 'like', $searchTerm)
                    ->orWhere('last_name', 'like', $searchTerm)
                    ->orWhere('card_id', 'like', $searchTerm)
                    ->pluck('user_id');
                    
                $professorIds = ResearchStaffProfessor::where('name', 'like', $searchTerm)
                    ->orWhere('last_name', 'like', $searchTerm)
                    ->orWhere('card_id', 'like', $searchTerm)
                    ->pluck('user_id');
                    
                $researchStaffIds = ResearchStaffResearchStaff::where('name', 'like', $searchTerm)
                    ->orWhere('last_name', 'like', $searchTerm)
                    ->orWhere('card_id', 'like', $searchTerm)
                    ->pluck('user_id');
                    
                $q->orWhereIn('id', $studentIds)
                    ->orWhereIn('id', $professorIds)
                    ->orWhereIn('id', $researchStaffIds);
            });
        }

        // ⚠️ CORRECCIÓN AQUÍ: Eliminar el orderBy('name')
        // Solo ordenar por created_at en la consulta SQL
        $query->orderBy('created_at', 'desc');

        // Obtener los usuarios paginados
        $users = $query->paginate($perPage);
        $users->appends($request->query());

        // ✅ ORDENAR POR NOMBRE EN PHP (después de obtener los resultados)
        $usersCollection = $users->getCollection()->sortBy(function ($user) {
            switch ($user->role) {
                case 'student':
                    return $user->details->name ?? '';
                case 'professor':
                case 'committee_leader':
                    return $user->details->name ?? '';
                case 'research_staff':
                    return $user->details->name ?? '';
                default:
                    return '';
            }
        });

        // Reemplazar la colección paginada con la colección ordenada
        $users->setCollection($usersCollection);

        // Cargar detalles de usuarios
        $userIds = collect($users->items())->pluck('id')->toArray();
        $studentIds = [];
        $professorIds = [];
        $researchStaffIds = [];

        foreach ($users as $user) {
            switch ($user->role) {
                case 'student':
                    $studentIds[] = $user->id;
                    break;
                case 'professor':
                case 'committee_leader':
                    $professorIds[] = $user->id;
                    break;
                case 'research_staff':
                    $researchStaffIds[] = $user->id;
                    break;
            }
        }

        $students = ResearchStaffStudent::whereIn('user_id', $studentIds)->get()->keyBy('user_id');
        $professors = ResearchStaffProfessor::whereIn('user_id', $professorIds)->get()->keyBy('user_id');
        $researchStaffs = ResearchStaffResearchStaff::whereIn('user_id', $researchStaffIds)->get()->keyBy('user_id');

        foreach ($users as $user) {
            switch ($user->role) {
                case 'student':
                    $user->details = $students[$user->id] ?? null;
                    break;
                case 'professor':
                case 'committee_leader':
                    $user->details = $professors[$user->id] ?? null;
                    break;
                case 'research_staff':
                    $user->details = $researchStaffs[$user->id] ?? null;
                    break;
            }
        }

        // Cargar programas
        $cityPrograms = ResearchStaffCityProgram::all();
        foreach ($cityPrograms as $program) {
            $program->full_name = $program->program->name . ' - ' . $program->city->name;
        }

        return view('user.index', [
            'users' => $users,
            'search' => $search,
            'role' => $role,
            'state' => $state,
            'cityProgramId' => $cityProgramId,
            'cityPrograms' => $cityPrograms,
            'perPage' => $perPage,
            'perPageOptions' => $perPageOptions,
            'i' => ($users->currentPage() - 1) * $users->perPage(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\CityProgram;
use App\Models\Content;
use App\Models\ContentFramework;
use App\Models\ContentFrameworkProject;
use App\Models\InvestigationLine;
use App\Models\Professor;
use App\Models\Program;
use App\Models\ProjectStatus;
use App\Models\ResearchGroup;
use App\Models\ResearchStaff;
use App\Models\Student;
use App\Models\ThematicArea;
use App\Models\User;
use App\Models\Version;
use Google\Service\AIPlatformNotebooks\Resource\Projects;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            ResearchStaffTableSeeder::class,
            DepartmentsTableSeeder::class,
            CitiesTableSeeder::class,
            ResearchGroupsTableSeeder::class,
            ProgramsTableSeeder::class,
            CityProgramTableSeeder::class,
            ProfessorsTableSeeder::class,
            StudentsTableSeeder::class,
            InvestigationLinesTableSeeder::class,
            ThematicAreasTableSeeder::class,
            ProjectStatusesTableSeeder::class,
            ProjectsTableSeeder::class,
            ProfessorProjectTableSeeder::class,
            StudentProjectTableSeeder::class,
            FrameworksTableSeeder::class,
            ContentFrameworksTableSeeder::class,
            ContentFrameworkProjectTableSeeder::class,
            VersionsTableSeeder::class,
            ContentsTableSeeder::class,
            ContentVersionTableSeeder::class,
        ]);
    }
}

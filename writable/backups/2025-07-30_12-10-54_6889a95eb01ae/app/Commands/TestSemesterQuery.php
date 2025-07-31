<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Services\SemesterService;

class TestSemesterQuery extends BaseCommand
{
    protected $group       = 'Testing';
    protected $name        = 'test_semester_query';
    protected $description = 'Test semester query';

    public function run(array $params)
    {
        try {
            $semesterService = new SemesterService();
            $result = $semesterService->getAvailableSemesters();
            
            CLI::write('Query executed successfully!', 'green');
            CLI::write('Number of results: ' . count($result));
            
            if (count($result) > 0) {
                CLI::write('First result sample:');
                print_r($result[0]);
            } else {
                CLI::write('No results found.', 'yellow');
            }
        } catch (\Exception $e) {
            CLI::error('Error: ' . $e->getMessage());
            CLI::write('Stack trace:');
            CLI::write($e->getTraceAsString());
        }
    }
}
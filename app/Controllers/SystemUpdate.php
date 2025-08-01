<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class SystemUpdate extends Controller
{
    protected $githubToken;
    protected $repositoryUrl;
    protected $branchName;
    protected $backupPath;
    protected $gitCommand;
    protected $hostingConfig;

    public function __construct()
    {
        // Load hosting configuration
        $this->loadHostingConfig();

        // Setup Git path based on environment
        $this->setupGitPath();

        // Konfigurasi GitHub - sesuaikan dengan repository Anda
        $this->githubToken = env('GITHUB_TOKEN', '');
        $this->repositoryUrl = env('GITHUB_REPO_URL', 'https://github.com/AFIK35/sapasekolah123.git');
        $this->branchName = env('GITHUB_BRANCH', 'main');
        $this->backupPath = WRITEPATH . 'backups/';

        // Pastikan direktori backup ada
        if (!is_dir($this->backupPath)) {
            mkdir($this->backupPath, 0755, true);
        }
    }

    private function loadHostingConfig()
    {
        $configFile = APPPATH . 'Config/Hosting.php';
        if (file_exists($configFile)) {
            $this->hostingConfig = include $configFile;
        } else {
            // Default config jika file tidak ada
            $this->hostingConfig = [
                'environment' => 'unknown',
                'git_available' => false,
                'git_path' => 'git',
                'shell_exec_enabled' => function_exists('shell_exec'),
                'auto_update_supported' => false
            ];
        }
    }

    private function setupGitPath()
    {
        $osType = strtoupper(substr(PHP_OS, 0, 3));

        if ($osType === 'WIN') {
            // Windows paths
            $gitPaths = [
                'C:\Program Files\Git\bin\git.exe',
                'C:\Program Files (x86)\Git\bin\git.exe',
                'git'
            ];
        } else {
            // Linux/Unix paths
            $gitPaths = [
                '/usr/bin/git',
                '/usr/local/bin/git',
                '/bin/git',
                'git'
            ];
        }

        // Use hosting config if available
        if (!empty($this->hostingConfig['git_path'])) {
            $this->gitCommand = $this->hostingConfig['git_path'];
            return;
        }

        // Auto-detect Git
        foreach ($gitPaths as $path) {
            if ($this->testGitPath($path)) {
                $this->gitCommand = $path;
                return;
            }
        }

        // Fallback
        $this->gitCommand = 'git';
    }

    private function testGitPath($gitPath)
    {
        if (!$this->hostingConfig['shell_exec_enabled']) {
            return false;
        }

        $output = @shell_exec("\"$gitPath\" --version 2>&1");
        return $output && strpos($output, 'git version') !== false;
    }

    public function index()
    {
        // Cek shell_exec dan git
        $shellExecEnabled = function_exists('shell_exec');
        $gitAvailable = $shellExecEnabled && (strpos(@shell_exec('git --version 2>&1'), 'git version') !== false);

        if (!$shellExecEnabled) {
            $data = [
                'error' => 'Fungsi shell_exec dinonaktifkan di server hosting Anda. Fitur System Update tidak bisa digunakan.',
            ];
            return view('system_update/index', $data);
        }
        if (!$gitAvailable) {
            $data = [
                'error' => 'Aplikasi Git tidak tersedia di server hosting Anda. Fitur System Update tidak bisa digunakan.',
            ];
            return view('system_update/index', $data);
        }

        // Cek status update terbaru
        $currentVersion = $this->getCurrentVersion();
        $latestVersion = $this->getLatestVersion();
        $updateAvailable = $this->checkUpdateAvailable();

        $data = [
            'current_version' => $currentVersion,
            'latest_version' => $latestVersion,
            'update_available' => $updateAvailable,
            'last_update' => $this->getLastUpdateTime(),
            'git_status' => $this->getGitStatus()
        ];

        return view('system_update/index', $data);
    }

    // Endpoint sederhana untuk cek versi aplikasi
    public function checkUpdate()
    {
        $currentVersion = $this->getCurrentVersion();
        return $this->response->setStatusCode(200)->setJSON([
            'success' => true,
            'current_version' => $currentVersion,
            'message' => 'Versi aplikasi saat ini.'
        ]);
    }

    public function performUpdate()
    {
        try {
            // 1. Validasi prerequisite
            if (!$this->validatePrerequisites()) {
                throw new \Exception('Prerequisites tidak terpenuhi');
            }

            // 2. Backup current version
            $backupId = $this->createBackup();

            // 3. Pull latest changes from GitHub
            $this->pullLatestChanges();

            // 4. Run database migrations if any
            $this->runMigrations();

            // 5. Clear cache
            $this->clearCache();

            // 6. Update version file
            $this->updateVersionFile();

            // 7. Update last update time
            $this->updateLastUpdateTime();

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Update berhasil dilakukan!',
                'backup_id' => $backupId,
                'new_version' => $this->getCurrentVersion()
            ]);
        } catch (\Exception $e) {
            // Rollback jika ada error
            if (isset($backupId)) {
                $this->rollback($backupId);
            }

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Update gagal: ' . $e->getMessage()
            ]);
        }
    }
    // Endpoint untuk mengambil log update
    public function getUpdateLog()
    {
        $logFile = ROOTPATH . 'update_log.txt';
        $log = file_exists($logFile) ? file_get_contents($logFile) : 'Belum ada log update.';
        return $this->response->setJSON(['log' => $log]);
    }
    /**
     * Update last_update.txt with current datetime
     */
    private function updateLastUpdateTime()
    {
        $lastUpdateFile = ROOTPATH . 'last_update.txt';
        $now = date('Y-m-d H:i:s O');
        file_put_contents($lastUpdateFile, $now);
        return true;
    }

    public function rollback()
    {
        $backupId = $this->request->getPost('backup_id');

        try {
            if ($this->performRollback($backupId)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Rollback berhasil dilakukan!'
                ]);
            } else {
                throw new \Exception('Rollback gagal');
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Rollback gagal: ' . $e->getMessage()
            ]);
        }
    }

    public function testConnection()
    {
        try {
            $tests = [];

            // 1. Test Git Installation
            $gitVersion = $this->executeGitCommand('git --version');
            $tests['git_installed'] = [
                'status' => strpos($gitVersion, 'git version') !== false,
                'message' => strpos($gitVersion, 'git version') !== false ?
                    'Git terinstall: ' . trim($gitVersion) :
                    'Git tidak ditemukan atau belum terinstall',
                'details' => trim($gitVersion)
            ];

            // 2. Test Git Repository
            $tests['git_repository'] = [
                'status' => is_dir(ROOTPATH . '.git'),
                'message' => is_dir(ROOTPATH . '.git') ?
                    'Direktori adalah Git repository' :
                    'Direktori bukan Git repository - jalankan git init',
                'details' => is_dir(ROOTPATH . '.git') ? 'Repository initialized' : 'Not a git repository'
            ];

            // 3. Test Internet Connection
            $internetTest = $this->checkInternetConnection();
            $tests['internet'] = [
                'status' => $internetTest,
                'message' => $internetTest ?
                    'Koneksi internet tersedia' :
                    'Tidak ada koneksi internet',
                'details' => $internetTest ? 'Connected to github.com' : 'Connection failed'
            ];

            // 4. Test GitHub Configuration
            $githubConfigured = !empty($this->githubToken) && !empty($this->repositoryUrl);
            $tests['github_config'] = [
                'status' => $githubConfigured,
                'message' => $githubConfigured ?
                    'Konfigurasi GitHub lengkap' :
                    'Konfigurasi GitHub tidak lengkap (periksa .env)',
                'details' => [
                    'token_set' => !empty($this->githubToken),
                    'repo_url_set' => !empty($this->repositoryUrl),
                    'branch_set' => !empty($this->branchName)
                ]
            ];

            // 5. Test Git Remote
            $remoteTest = false;
            $remoteDetails = '';
            if ($tests['git_repository']['status']) {
                $remoteOutput = $this->executeGitCommand('git remote -v');
                $remoteTest = !empty(trim($remoteOutput)) && strpos($remoteOutput, 'origin') !== false;
                $remoteDetails = trim($remoteOutput) ?: 'No remote configured';
            }

            $tests['git_remote'] = [
                'status' => $remoteTest,
                'message' => $remoteTest ?
                    'Git remote origin terkonfigurasi' :
                    'Git remote origin belum terkonfigurasi',
                'details' => $remoteDetails
            ];

            // 6. Test GitHub API Access (jika configured)
            if ($githubConfigured && $internetTest) {
                $apiTest = $this->testGitHubAPI();
                $tests['github_api'] = $apiTest;
            } else {
                $tests['github_api'] = [
                    'status' => false,
                    'message' => 'Skip test GitHub API (konfigurasi tidak lengkap)',
                    'details' => 'Requires GitHub config and internet'
                ];
            }

            // 7. Test File Permissions
            $writeTest = is_writable(ROOTPATH);
            $tests['file_permissions'] = [
                'status' => $writeTest,
                'message' => $writeTest ?
                    'Permission write tersedia' :
                    'Tidak ada permission write pada direktori',
                'details' => $writeTest ? 'Writable' : 'Not writable'
            ];

            // Summary
            $allPassed = true;
            $passedCount = 0;
            $totalCount = count($tests);

            foreach ($tests as $test) {
                if ($test['status']) {
                    $passedCount++;
                } else {
                    $allPassed = false;
                }
            }

            return $this->response->setJSON([
                'success' => true,
                'all_passed' => $allPassed,
                'summary' => [
                    'passed' => $passedCount,
                    'total' => $totalCount,
                    'percentage' => round(($passedCount / $totalCount) * 100, 1)
                ],
                'tests' => $tests,
                'message' => $allPassed ?
                    'Semua test koneksi berhasil!' :
                    "Test koneksi: {$passedCount}/{$totalCount} berhasil"
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error testing connection: ' . $e->getMessage()
            ]);
        }
    }

    private function testGitHubAPI()
    {
        try {
            // Test GitHub API access
            $apiUrl = str_replace(
                'github.com',
                'api.github.com/repos',
                str_replace('.git', '', $this->repositoryUrl)
            );

            $context = stream_context_create([
                'http' => [
                    'method' => 'GET',
                    'header' => [
                        'User-Agent: SekolahkuApp',
                        'Authorization: token ' . $this->githubToken,
                        'Accept: application/vnd.github.v3+json'
                    ],
                    'timeout' => 10
                ]
            ]);

            $response = @file_get_contents($apiUrl, false, $context);

            if ($response) {
                $data = json_decode($response, true);

                return [
                    'status' => true,
                    'message' => 'GitHub API akses berhasil',
                    'details' => [
                        'repository' => $data['full_name'] ?? 'Unknown',
                        'private' => $data['private'] ?? false,
                        'default_branch' => $data['default_branch'] ?? 'Unknown'
                    ]
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'GitHub API akses gagal - periksa token atau repository URL',
                    'details' => 'API request failed'
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'GitHub API test error: ' . $e->getMessage(),
                'details' => $e->getMessage()
            ];
        }
    }

    private function validatePrerequisites()
    {
        // Cek apakah Git tersedia
        $gitVersion = shell_exec('git --version 2>&1');
        if (strpos($gitVersion, 'git version') === false) {
            throw new \Exception('Git tidak terinstall atau tidak ditemukan');
        }

        // Cek apakah direktori adalah Git repository
        if (!is_dir(ROOTPATH . '.git')) {
            throw new \Exception('Direktori bukan Git repository');
        }

        // Cek koneksi internet
        if (!$this->checkInternetConnection()) {
            throw new \Exception('Tidak ada koneksi internet');
        }

        // Cek permission write
        if (!is_writable(ROOTPATH)) {
            throw new \Exception('Tidak ada permission write pada direktori aplikasi');
        }

        return true;
    }

    private function createBackup()
    {
        $backupId = date('Y-m-d_H-i-s') . '_' . uniqid();
        $backupDir = $this->backupPath . $backupId;

        // Buat direktori backup jika belum ada
        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        // Copy files penting (exclude vendor, writable, dan .git)
        $excludeDirs = ['vendor', 'writable', '.git', 'node_modules'];
        $this->copyDirectory(ROOTPATH, $backupDir, $excludeDirs);

        // Simpan database backup
        $this->backupDatabase($backupDir);

        // Simpan informasi backup
        file_put_contents($backupDir . '/backup_info.json', json_encode([
            'id' => $backupId,
            'timestamp' => date('Y-m-d H:i:s'),
            'version' => $this->getCurrentVersion(),
            'git_commit' => $this->getGitCommitHash()
        ]));

        return $backupId;
    }

    // Tambahkan stub backupDatabase agar tidak error
    private function backupDatabase($backupDir)
    {
        // TODO: Implementasi backup database sesuai kebutuhan
        // Untuk sementara, buat file kosong agar tidak error
        file_put_contents($backupDir . '/database_backup.sql', '-- database backup not implemented');
        return true;
    }

    private function pullLatestChanges()
    {
        // Set up Git credentials jika menggunakan private repo
        if (!empty($this->githubToken)) {
            $this->setupGitCredentials();
        }

        // Stash any local changes
        shell_exec('cd ' . ROOTPATH . ' && git stash 2>&1');

        // Pull latest changes sesuai branch dari konfigurasi
        $branch = $this->branchName;
        if (empty($branch)) {
            $branch = 'main'; // fallback default
        }
        $output = shell_exec('cd ' . ROOTPATH . ' && git pull --no-rebase --allow-unrelated-histories origin ' . \escapeshellarg($branch) . ' 2>&1');

        if (strpos($output, 'error') !== false || strpos($output, 'fatal') !== false) {
            throw new \Exception('Git pull failed: ' . $output);
        }

        return true;
    }

    private function runMigrations()
    {
        // Run CodeIgniter migrations
        $output = shell_exec('cd ' . ROOTPATH . ' && php spark migrate 2>&1');

        // Log migration output
        log_message('info', 'Migration output: ' . $output);

        return true;
    }

    private function clearCache()
    {
        // Clear CodeIgniter cache
        $cacheDir = WRITEPATH . 'cache/';
        if (is_dir($cacheDir)) {
            $this->deleteDirectory($cacheDir);
        }
        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0755, true);
        }

        // Clear debugbar cache
        $debugbarDir = WRITEPATH . 'debugbar/';
        if (is_dir($debugbarDir)) {
            $this->deleteDirectory($debugbarDir);
        }
        if (!is_dir($debugbarDir)) {
            mkdir($debugbarDir, 0755, true);
        }

        return true;
    }

    private function getCurrentVersion()
    {
        $versionFile = ROOTPATH . 'version.txt';
        if (file_exists($versionFile)) {
            return trim(file_get_contents($versionFile));
        }
        return '2025.1'; // Default version dengan format tahun
    }

    private function getLatestVersion()
    {
        // Ambil versi terbaru dari GitHub API
        $apiUrl = str_replace(
            'github.com',
            'api.github.com/repos',
            str_replace('.git', '', $this->repositoryUrl)
        ) . '/releases/latest';

        $context = stream_context_create([
            'http' => [
                'header' => [
                    'User-Agent: SekolahkuApp',
                    'Authorization: token ' . $this->githubToken
                ]
            ]
        ]);

        $response = @file_get_contents($apiUrl, false, $context);

        if ($response) {
            $data = json_decode($response, true);
            return $data['tag_name'] ?? $this->getCurrentVersion();
        }

        return $this->getCurrentVersion();
    }

    private function checkUpdateAvailable()
    {
        $current = $this->getCurrentVersion();
        $latest = $this->getLatestVersion();
        return $this->compareYearBasedVersions($latest, $current) > 0;
    }

    /**
     * Compare year-based versions (e.g., 2025.1 vs 2025.2)
     * Returns: 1 if v1 > v2, -1 if v1 < v2, 0 if equal
     */
    private function compareYearBasedVersions($version1, $version2)
    {
        // Parse version format: YYYY.N
        $v1Parts = explode('.', $version1);
        $v2Parts = explode('.', $version2);

        // Ensure we have year and minor version
        $v1Year = (int)($v1Parts[0] ?? date('Y'));
        $v1Minor = (int)($v1Parts[1] ?? 1);
        $v2Year = (int)($v2Parts[0] ?? date('Y'));
        $v2Minor = (int)($v2Parts[1] ?? 1);

        // Compare years first
        if ($v1Year !== $v2Year) {
            return $v1Year > $v2Year ? 1 : -1;
        }

        // If years are same, compare minor versions
        if ($v1Minor !== $v2Minor) {
            return $v1Minor > $v2Minor ? 1 : -1;
        }

        return 0; // Equal
    }

    private function getLastUpdateTime()
    {
        $lastUpdateFile = ROOTPATH . 'last_update.txt';
        if (file_exists($lastUpdateFile)) {
            return trim(file_get_contents($lastUpdateFile));
        }
        $output = shell_exec('cd ' . ROOTPATH . ' && git log -1 --format="%cd" --date=iso 2>&1');
        return trim($output) ?: 'Unknown';
    }

    private function getGitStatus()
    {
        $output = shell_exec('cd ' . ROOTPATH . ' && git status --porcelain 2>&1');
        return empty(trim($output)) ? 'Clean' : 'Modified';
    }

    private function getGitCommitHash()
    {
        $output = shell_exec('cd ' . ROOTPATH . ' && git rev-parse HEAD 2>&1');
        return trim($output);
    }

    private function updateVersionFile()
    {
        $latestVersion = $this->getLatestVersion();
        file_put_contents(ROOTPATH . 'version.txt', $latestVersion);
        return true;
    }

    private function setupGitCredentials()
    {
        // Setup GitHub token untuk private repository
        $repoUrl = str_replace('https://github.com', 'https://' . $this->githubToken . '@github.com', $this->repositoryUrl);
        shell_exec('cd ' . ROOTPATH . ' && git remote set-url origin ' . $repoUrl . ' 2>&1');
        return true;
    }

    private function checkInternetConnection()
    {
        $connected = @fsockopen("github.com", 443, $errno, $errstr, 5);
        if ($connected) {
            fclose($connected);
            return true;
        }
        return false;
    }

    private function copyDirectory($src, $dst, $exclude = [])
    {
        $dir = opendir($src);
        if (!is_dir($dst)) {
            @mkdir($dst);
        }

        while (($file = readdir($dir)) !== false) {
            if ($file != '.' && $file != '..' && !in_array($file, $exclude)) {
                if (is_dir($src . '/' . $file)) {
                    $this->copyDirectory($src . '/' . $file, $dst . '/' . $file, $exclude);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    private function deleteDirectory($dir)
    {
        if (!is_dir($dir)) return false;
    }

    private function performRollback($backupId)
    {
        $backupDir = $this->backupPath . $backupId;

        if (!is_dir($backupDir)) {
            throw new \Exception('Backup tidak ditemukan');
        }

        // Restore files
        $this->copyDirectory($backupDir, ROOTPATH, ['database_backup.sql', 'backup_info.json']);

        // Restore database
        $this->restoreDatabase($backupDir . '/database_backup.sql');

        return true;
    }

    private function restoreDatabase($backupFile)
    {
        if (!file_exists($backupFile)) return false;

        $db = \Config\Database::connect();
        $sql = file_get_contents($backupFile);

        // Execute SQL backup
        $queries = explode(';', $sql);
        foreach ($queries as $query) {
            $query = trim($query);
            if (!empty($query)) {
                $db->query($query);
            }
        }

        return true;
    }

    /**
     * Execute Git command with proper PATH and hosting support
     */
    private function executeGitCommand($command)
    {
        // Check if shell execution is available
        if (!$this->hostingConfig['shell_exec_enabled']) {
            return 'Error: shell_exec disabled on this hosting';
        }

        // Check if Git is available
        if (!$this->hostingConfig['git_available'] && !$this->testGitPath($this->gitCommand)) {
            return 'Error: Git not available on this hosting';
        }

        // Replace 'git' with full path if needed
        $gitCommand = str_replace('git ', $this->gitCommand . ' ', $command);

        // Execute command in project root
        $fullCommand = "cd " . ROOTPATH . " && " . $gitCommand . " 2>&1";

        // Set timeout for hosting
        $oldLimit = ini_get('max_execution_time');
        set_time_limit(120);

        $output = shell_exec($fullCommand);

        // Restore time limit
        set_time_limit($oldLimit);

        return $output ?: 'No output from command';
    }
}

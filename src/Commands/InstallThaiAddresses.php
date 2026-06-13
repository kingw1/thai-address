<?php

namespace Wichai\ThaiAddress\Commands;

use Illuminate\Console\Command;

class InstallThaiAddresses extends Command
{
    protected $signature = 'thai-addresses:install
                            {--dry-run : แสดงตัวอย่างข้อมูล 5 แถวแรก ไม่ insert จริง}';

    protected $description = 'Import ข้อมูลที่อยู่ไทยจาก JSON ที่มีอยู่ใน package เข้า DB (ไม่ต้องต่อ internet)';

    public function handle(): int
    {
        $this->info('🇹🇭 Thai Addresses Install');
        $this->newLine();

        /** @var SyncThaiAddresses $sync */
        $sync = $this->laravel->make(SyncThaiAddresses::class);

        // ส่ง output ไปให้ sync ใช้ด้วย เพื่อให้ progress bar และ messages แสดงผลถูกต้อง
        $sync->setOutput($this->output);

        return $sync->runImport(
            dryRun: $this->option('dry-run')
        );
    }
}

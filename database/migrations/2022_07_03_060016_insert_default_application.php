<?php

use App\Models\Application;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{

    private const DEFAULT_APPLICATION_UUID = '77777777-7777-7777-7777-777777777777';
    private const DEFAULT_PLAIN_TOKEN = 'THIstoKenMusTbeUsEDoNlYdeveLOPmentNotPrd';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $application = Application::create([
            'id' => self::DEFAULT_APPLICATION_UUID,
            'name' => 'アプリケーション',
        ]);

        $application->tokens()->create([
            'name' => 'default application token must be overwrite in prd',
            'token' => hash('sha256', self::DEFAULT_PLAIN_TOKEN),
            'abilities' => ['*'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $application = Application::find(self::DEFAULT_APPLICATION_UUID);
        $application->tokens()->delete();
        $application->delete();
    }
};

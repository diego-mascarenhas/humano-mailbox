<?php

namespace Idoneo\HumanoMailbox\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class HumanoMailboxSeeder extends Seeder
{
	public function run(): void
	{
		try {
			if (Schema::hasTable('modules') && class_exists(\App\Models\Module::class)) {
				\App\Models\Module::updateOrCreate(
					['key' => 'mailbox'],
					[
						'name' => 'Mailbox',
						'icon' => 'ti ti-mail',
						'description' => 'Team mailbox with contact linking, threading and assignments',
						'is_core' => false,
						'status' => 1,
					]
				);
			}
		} catch (\Throwable $e) {
			Log::debug('HumanoMailboxSeeder: module registration skipped: ' . $e->getMessage());
		}
	}
}



<?php

namespace HumanoMailbox\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class MailboxPermissionsSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		// Mailbox permissions
		Permission::firstOrCreate(['name' => 'mailbox.index']);
		Permission::firstOrCreate(['name' => 'mailbox.list']);
		Permission::firstOrCreate(['name' => 'mailbox.create']);
		Permission::firstOrCreate(['name' => 'mailbox.show']);
		Permission::firstOrCreate(['name' => 'mailbox.edit']);
		Permission::firstOrCreate(['name' => 'mailbox.store']);
		Permission::firstOrCreate(['name' => 'mailbox.update']);
		Permission::firstOrCreate(['name' => 'mailbox.destroy']);
	}
}


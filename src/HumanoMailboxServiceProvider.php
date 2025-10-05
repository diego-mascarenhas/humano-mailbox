<?php

namespace Idoneo\HumanoMailbox;

use Idoneo\HumanoMailbox\Models\SystemModule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class HumanoMailboxServiceProvider extends PackageServiceProvider
{
	public function configurePackage(Package $package): void
	{
		$package
			->name('humano-mailbox')
			->hasViews()
			->hasRoute('web');
	}

	public function bootingPackage(): void
	{
		parent::bootingPackage();

		$this->registerMailboxModule();

		// Ensure permissions exist for menus and access
		try {
			if (Schema::hasTable('permissions') && class_exists(Permission::class)) {
				// Run the permissions seeder
				if (class_exists(\HumanoMailbox\Database\Seeders\MailboxPermissionsSeeder::class)) {
					(new \HumanoMailbox\Database\Seeders\MailboxPermissionsSeeder())->run();
				}

				// Grant all mailbox permissions to admin role
				$adminRole = class_exists(Role::class) ? Role::where('name', 'admin')->first() : null;
				if ($adminRole) {
					$mailboxPermissions = Permission::where('name', 'LIKE', 'mailbox.%')->pluck('name')->toArray();
					if (!empty($mailboxPermissions)) {
						$adminRole->givePermissionTo($mailboxPermissions);
					}
				}
			}
		} catch (\Throwable $e) {
			Log::debug('HumanoMailbox: permissions setup skipped: ' . $e->getMessage());
		}
	}

	/**
	 * Register Mailbox module in Support group
	 */
	private function registerMailboxModule(): void
	{
		try {
			if (Schema::hasTable('modules')) {
				if (class_exists(\App\Models\Module::class)) {
					\App\Models\Module::updateOrCreate(
						['key' => 'mailbox'],
						[
							'name' => 'Mailbox',
							'icon' => 'ti ti-mail',
							'description' => 'Team mailbox management',
							'is_core' => false,
							'group' => 'support',
							'order' => 4,
							'status' => 1,
						]
					);
				} else {
					SystemModule::query()->updateOrCreate(
						['key' => 'mailbox'],
						[
							'name' => 'Mailbox',
							'icon' => 'ti ti-mail',
							'description' => 'Team mailbox management',
							'is_core' => false,
							'status' => 1,
						]
					);
				}
			}
		} catch (\Throwable $e) {
			Log::debug('HumanoMailbox: module registration skipped: ' . $e->getMessage());
		}
	}

	/**
	 * Also ensure module is correctly configured after boot (after seeders run)
	 */
	public function boot()
	{
		parent::boot();

		// Re-run registration to ensure group is correctly set after seeders
		$this->registerMailboxModule();
	}
}



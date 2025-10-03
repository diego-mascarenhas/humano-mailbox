<?php

namespace Idoneo\HumanoMailbox;

use Idoneo\HumanoMailbox\Models\SystemModule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
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

		try {
			if (Schema::hasTable('modules')) {
				if (class_exists(\App\Models\Module::class)) {
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
				} else {
					SystemModule::query()->updateOrCreate(
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
			}
		} catch (\Throwable $e) {
			Log::debug('HumanoMailbox: module registration skipped: ' . $e->getMessage());
		}
	}
}



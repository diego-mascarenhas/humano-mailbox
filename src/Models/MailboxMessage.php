<?php

namespace Idoneo\HumanoMailbox\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class MailboxMessage extends Model
{
	use HasFactory;

	protected $guarded = [];

	protected static function booted(): void
	{
		static::addGlobalScope('team', function (Builder $builder) {
			if (Auth::check() && Schema::hasColumn($builder->getModel()->getTable(), 'team_id')) {
				$builder->where('team_id', Auth::user()->currentTeam->id);
			}
		});
	}
}



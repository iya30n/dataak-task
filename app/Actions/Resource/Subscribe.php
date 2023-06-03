<?php

namespace App\Actions\Resource;

use App\Models\Resource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Subscribe
{
	private User $user;
	private Resource $resource;

	const SubscriptionLimit = 10;

	public function __construct(Resource $resource)
	{
		$this->user = $this->loginFakeUser();
		$this->resource = $resource;
	}

	public function handle()
	{
		if ($this->checkSubscribed())
			return ["you've already subscribed.", 200];

		if ($this->checkSubscriptionLimit())
			return ["Sorry, you can't subscribe on more than 10 resources.", 403];

		$this->resource->subscribers()->attach($this->user->id);

		return [sprintf("you have been subscribed to the %s resource.", $this->resource->name), 200];
	}

	private function loginFakeUser(): User
	{
		$user = User::find(1);
		if (!$user) {
			throw new Exception("run db:seed command first");
		}

		if (!Auth::check())
			Auth::login($user);

		return $user;
	}

	private function checkSubscribed(): bool
	{
		return $this->resource->subscribers()->whereId($this->user->id)->exists();
	}

	private function checkSubscriptionLimit(): bool
	{
		return $this->user->resources->count() >= static::SubscriptionLimit;
	}
}

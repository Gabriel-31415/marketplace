<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

trait Slug
{
    public function setNameAttribute($value)
	{
		$slug = Str::slug($value);
		$matchs = $this->uniqueSlug($slug);
		$this->attributes['name'] = $value;
		$this->attributes['slug'] = $matchs ? $slug . '-' .$matchs : $slug;
	}

	public function uniqueSlug($slug)
	{   
		$matchs = DB::table($this->table)
								->where('slug', 'like', $slug . '%')
								->count();
		return $matchs;
	}
}

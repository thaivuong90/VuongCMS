<?php

namespace VuongCMS\System\Providers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AccountUserProvider extends EloquentUserProvider
{

  /**
   * Retrieve a user by the given credentials.
   *
   * @param  array  $credentials
   * @return \Illuminate\Contracts\Auth\Authenticatable|null
   */
  public function retrieveByCredentials(array $credentials)
  {
    if (
      empty($credentials) ||
      (count($credentials) === 1 &&
        Str::contains($this->firstCredentialKey($credentials), 'password'))
    ) {
      return;
    }

    // First we will add each credential element to the query as a where clause.
    // Then we can execute the query and, if we found a user, return it in a
    // Eloquent User "model" that will be utilized by the Guard instances.
    $query = $this->newModelQuery()->where('system_id', $credentials['system_id']);

    foreach ($credentials as $key => $value) {
      if (Str::contains($key, 'password')) {
        continue;
      }

      if (is_array($value) || $value instanceof Arrayable) {
        $query->whereIn($key, $value);
      } elseif ($value instanceof Closure) {
        $value($query);
      } else {
        $query->where($key, $value);
      }
    }

    return $query->first();
  }

  /**
   * validateCredentials
   */
  public function validateCredentials(Authenticatable $user, array $credentials)
  {
    $plain = $credentials['password'];
    return Hash::check($plain, $user->getAuthPassword());
  }

  /**
   * Get a new query builder for the model instance.
   *
   * @param  \Illuminate\Database\Eloquent\Model|null  $model
   * @return \Illuminate\Database\Eloquent\Builder
   */
  protected function newModelQuery($model = null)
  {
    return is_null($model)
      ? $this->createModel()->newQuery()
      : $model->newQuery();
  }
}

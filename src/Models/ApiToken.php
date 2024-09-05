<?php

namespace Massterski\DmMarkirovka\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 *
 * @property int $id
 * @property string $access_token
 * @property string $refresh_token
 * @property \Illuminate\Support\Carbon|null $expires_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @mixin \Eloquent
 * @method static updateToken()
 */
class ApiToken extends Model
{
  protected $fillable = ['access_token', 'refresh_token', 'expires_at', 'service'];

  public function isExpired()
  {
    if ($this->expires_at < now()) {
      return true;
    }
    return false;
  }

  public function updateToken($accessToken, $refreshToken, $expiresIn)
  {
    $this->update([
      'access_token' => $accessToken,
      'refresh_token' => $refreshToken,
      'expires_at' => Carbon::now()->addSeconds($expiresIn),
    ]);
  }
}

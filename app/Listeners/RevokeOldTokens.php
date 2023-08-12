<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Passport\Events\AccessTokenCreated;
use Laravel\Passport\Token;
use Laravel\Passport\TokenRepository;

class RevokeOldTokens implements ShouldQueue
{
  protected $tokenRepository;

  public function __construct(TokenRepository $tokenRepository)
  {
    $this->tokenRepository = $tokenRepository;
  }

  public function handle(AccessTokenCreated $event)
  {
    // Revoke old tokens for the same user
    Token::where('user_id', $event->userId)
      ->where('client_id', $event->clientId)
      ->where('id', '!=', $event->tokenId)
      ->update(['revoked' => true]);
  }
}
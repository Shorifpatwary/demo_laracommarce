<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Passport\Events\RefreshTokenCreated;
use Laravel\Passport\TokenRepository;

class PruneOldTokens implements ShouldQueue
{
  protected $tokenRepository;

  public function __construct(TokenRepository $tokenRepository)
  {
    $this->tokenRepository = $tokenRepository;
  }

  public function handle(RefreshTokenCreated $event)
  {
    // Prune (remove) expired refresh tokens
    $this->tokenRepository->pruneRevokedTokens();
  }
}
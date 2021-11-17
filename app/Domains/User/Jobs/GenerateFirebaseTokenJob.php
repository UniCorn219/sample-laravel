<?php

namespace App\Domains\User\Jobs;

use Kreait\Firebase\ServiceAccount;
use Lucid\Units\Job;
use Firebase\JWT\JWT;

class GenerateFirebaseTokenJob extends Job
{
    private string $userId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     *
     * @return string
     */
    public function handle()
    {
        $credentialsPath = config('firebase.projects.app.credentials.file');
        $serviceAccount = ServiceAccount::fromValue(base_path($credentialsPath));

        $privateKey = $serviceAccount->getPrivateKey();
        $clientEmail = $serviceAccount->getClientEmail();

        $nowSeconds = time();

        $payload = array(
            "iss" => $clientEmail,
            "sub" => $clientEmail,
            "aud" => "https://identitytoolkit.googleapis.com/google.identity.identitytoolkit.v1.IdentityToolkit",
            "iat" => $nowSeconds,
            "exp" => time() + 3600, // one hour from now
            "uid" => $this->userId,
        );

        return JWT::encode($payload, $privateKey, "RS256");
    }
}

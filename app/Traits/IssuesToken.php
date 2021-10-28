<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait IssuesToken
{
    public function issueToken(Request $request, string $grantType = 'password', string $scope = '')
    {
        $params = [
            'grant_type'    => $grantType,
            'client_id'     => env('CLIENT_ID'),
            'client_secret' => env('CLIENT_SECRET'),
            'scope'         => $scope
        ];

        $request->request->add($params);
        $proxy = Request::create('oauth/token', 'POST', $request->request->all());
        $pipeline = app()->dispatch($proxy);

        if (! $pipeline->isSuccessful()) {
            $pipeline->throwResponse();
        }

        return $pipeline;
    }
}
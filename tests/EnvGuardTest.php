<?php

it('fails when required key is missing', function () {
    config(['env-guard.rules' => ['APP_KEY' => 'required']]);
    putenv('APP_KEY=');

    expect(fn () => (new \LaramicStudio\EnvGuard\EnvGuard)->validate())
        ->toThrow(\RuntimeException::class, 'APP_KEY');
});

it('passes when required key is provided', function () {
    config(['env-guard.rules' => ['APP_KEY' => 'required']]);
    putenv('APP_KEY=test');
    (new \LaramicStudio\EnvGuard\EnvGuard)->validate();
})->throwsNoExceptions();

it('fails when the right type is not provided for the attribute', function () {
    config(['env-guard.rules' => ['APP_NAME' => ['required', 'integer']]]);

    putenv('APP_NAME=test');

    (new \LaramicStudio\EnvGuard\EnvGuard)->validate();

})->throws(\RuntimeException::class, 'integer');

it('fails when right value is not provided in the env file provided', function () {
    config(['env-guard.rules' => ['APP_NAME' => ['required', 'in:1,2,3,4,5'], 'APP_KEY' => 'required|starts_with:laravel']]);

    putenv('APP_NAME=3');
    putenv('APP_KEY=money');

    (new \LaramicStudio\EnvGuard\EnvGuard)->validate();
})->throws(\RuntimeException::class, 'must');

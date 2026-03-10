<?php

namespace LaramicStudio\EnvGuard;

use Illuminate\Support\Env;
use Illuminate\Support\Facades\Log;

class EnvGuard
{
    public function validate(): void
    {
        $rules = config('env-guard.rules', []);
        $errors = [];

        foreach ($rules as $key => $rule) {
            $key = strtoupper($key);
            $value = Env::get($key);

            $ruleList = is_string($rule)
                ? explode('|', $rule)
                : $rule;

            $isNullable = in_array('nullable', $ruleList);
            $isEmpty = $value === null || $value === '';

            if ($isNullable && $isEmpty) {
                continue;
            }

            foreach ($ruleList as $rawRule) {
                if ($rawRule === 'nullable') {
                    continue;
                }

                ['rule' => $ruleName, 'param' => $param] = $this->parseRule($rawRule);
                $error = $this->checkRule($ruleName, $param, $value);

                if ($error !== null) {
                    $errors[] = "[EnvGuard] validation failed {$key}: {$error}";
                }
            }
        }

        if (! empty($errors)) {
            throw new \RuntimeException(implode(PHP_EOL, $errors) . ' 🤢🤮');
        }
    }

    private function parseRule(string $rule): array
    {
        if (str_contains($rule, ':')) {
            [$name, $param] = explode(':', $rule, 2);

            return ['rule' => $name, 'param' => $param];
        }

        return ['rule' => $rule, 'param' => null];
    }

    private function checkRule(string $rule, ?string $param, mixed $value): ?string
    {
        $acceptedAttributes = ['required', 'string', 'integer', 'min', 'in', 'starts_with', 'nullable'];

        if (! in_array($rule, $acceptedAttributes)) {
            $this->logRejection("invalid rule: {$rule}", $rule);

            return "invalid rule: {$rule}";
        }

        switch ($rule) {
            case 'required':
                if ($value === null || $value === '') {
                    return 'is required but is missing or empty';
                }
                break;

            case 'string':
                if ($value !== null && ! is_string($value)) {
                    return 'must be a string';
                }
                break;

            case 'integer':
                if ($value !== null && ! ctype_digit((string) $value)) {
                    return 'must be an integer';
                }
                break;

            case 'min':
                if (ctype_digit((string) $value) && (int) $value < (int) $param) {
                    return "must be at least {$param}";
                }
                if (! ctype_digit((string) $value) && strlen($value) < (int) $param) {
                    return "must be at least {$param} characters";
                }
                break;

            case 'in':
                $allowed = explode(',', $param);
                if ($value !== null && ! in_array($value, $allowed, true)) {
                    return 'must be one of: '.$param;
                }
                break;

            case 'starts_with':
                if ($value !== null && ! str_starts_with($value, $param)) {
                    return "must start with '{$param}'";
                }
                break;

            case 'nullable':
                break;
        }

        return null;
    }

    private function logRejection(string $message, string $key): void
    {
        if (! config('env-guard.log_rejections', true)) {
            return;
        }

        $channel = config('env-guard.log_channel', 'stack');

        Log::channel($channel)->warning('[EnvGuard] validation failed for key: '.$key.' - '.$message);
    }
}

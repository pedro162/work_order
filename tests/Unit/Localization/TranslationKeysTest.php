<?php

declare(strict_types=1);

namespace Tests\Unit\Localization;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

final class TranslationKeysTest extends TestCase
{
    public static function translationKeys(): array
    {
        return [
            'command required' => ['application.command.required'],
            'invalid identifier' => ['application.command.invalid_id'],
            'disallowed field' => ['application.command.field_not_allowed'],
            'resource created' => ['api.created'],
            'resource updated' => ['api.updated'],
        ];
    }

    #[DataProvider('translationKeys')]
    public function testResolvesTranslationKeys(string $key): void
    {
        $value = __($key, ['field' => 'id', 'resource' => 'person']);

        $this->assertNotSame($key, $value, "Missing translation: {$key}");
    }
}

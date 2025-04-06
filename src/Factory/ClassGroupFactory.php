<?php

namespace App\Factory;

use App\Entity\ClassGroup;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<ClassGroup>
 */
final class ClassGroupFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return ClassGroup::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'name' => self::faker()->randomElement([
                'Mathematics',
                'Physics',
                'History',
                'Biology',
                'Computer Science',
                'Chemistry',
                'Literature',
                'Geography',
                'Economics',
                'Art',
            ]),
            'year' => self::faker()->numberBetween(1, 3),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(ClassGroup $classGroup): void {})
        ;
    }
}

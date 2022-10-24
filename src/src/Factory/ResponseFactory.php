<?php

namespace App\Factory;

use App\Entity\Response;
use App\Repository\ResponseRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Response>
 *
 * @method static Response|Proxy createOne(array $attributes = [])
 * @method static Response[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Response[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Response|Proxy find(object|array|mixed $criteria)
 * @method static Response|Proxy findOrCreate(array $attributes)
 * @method static Response|Proxy first(string $sortedField = 'id')
 * @method static Response|Proxy last(string $sortedField = 'id')
 * @method static Response|Proxy random(array $attributes = [])
 * @method static Response|Proxy randomOrCreate(array $attributes = [])
 * @method static Response[]|Proxy[] all()
 * @method static Response[]|Proxy[] findBy(array $attributes)
 * @method static Response[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Response[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static ResponseRepository|RepositoryProxy repository()
 * @method Response|Proxy create(array|callable $attributes = [])
 */
final class ResponseFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'responseText' => self::faker()->text(),
            'date' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Response $response): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Response::class;
    }
}

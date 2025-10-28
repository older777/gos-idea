<?php

namespace Older777\GosIdea\Tests\Unit;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Routing\Route;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;
use Older777\GosIdea\Requests\HuntingBookingRequest;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class HuntingBookingRequestTest extends TestCase
{
    /**
     * Data provider
     */
    public static function dataProvider(): array
    {
        $request = new HuntingBookingRequest;
        $request = $request->createFromBase(
            \Symfony\Component\HttpFoundation\Request::create(
                '/api/guides',
                'GET',
                [],
                [],
                [],
                ['CONTENT_TYPE' => 'application/json'],
                null
            )
        );
        $request1 = clone $request;
        $request2 = clone $request1;
        $request3 = clone $request1;
        $request1->query->add(['min_experience' => 1]);
        $request2->query->add(['min_experience' => 35]);
        $request3->query->add(['min_experience' => 110]);
        $data = [
            [$request, false],
            [$request1, false],
            [$request2, false],
            [$request3, true],
        ];

        return $data;
    }

    /**
     * Тест валидатора
     */
    #[DataProvider('dataProvider')]
    public function test_rules(HuntingBookingRequest $request, bool $exceptionExpected): void
    {
        $request->setContainer(app());
        $validationFactory = new Factory(new Translator(new FileLoader(new Filesystem, 'lang'), 'en'));
        $validationFactory->setContainer(app());
        $route = new Route(['get'], $request->getUri(), $request->getMethod());
        $rules = [
            'min_experience' => 'integer|max:100',
        ];
        $validator = $validationFactory->make(
            $request->validationData(),
            $rules,
            $request->messages(),
            $request->attributes(),
        );
        $request->setValidator($validator);

        if (! $exceptionExpected) {
            $this->expectNotToPerformAssertions();
        } else {
            $this->expectException('Exception');
        }

        $request->validateResolved();
    }
}

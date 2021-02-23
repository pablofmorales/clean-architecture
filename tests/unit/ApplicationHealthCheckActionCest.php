<?php
declare(strict_types=1);

use App\Actions\ApplicationHealthCheckAction;

class ApplicationHealthCheckActionCest
{
    /**
     * @param UnitTester $I
     * @test
     *
     */
    public function given_a_valid_application_we_should_return_true(UnitTester $I)
    {
        $validApplications  = [
            'valid-app-name',
            'other-valid',
            'another-valid'
        ];

        $applicationHealthCheck = new ApplicationHealthCheckAction($validApplications);

        $I->assertTrue($applicationHealthCheck->confirm('valid-app-name'));
    }

    /**
     * @param UnitTester $I
     * @test
     *
     */
    public function given_an_invalid_application_we_should_return_false(UnitTester $I)
    {
        $validApplications  = [
            'valid-app-name',
            'other-valid',
            'another-valid'
        ];

        $applicationHealthCheck = new ApplicationHealthCheckAction($validApplications);

        $I->assertFalse($applicationHealthCheck->confirm('no-valid-app-name'));
    }
}

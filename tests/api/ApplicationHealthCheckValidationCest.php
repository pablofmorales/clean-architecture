<?php declare(strict_types=1);

use Codeception\Util\HttpCode;

class ApplicationHealthCheckValidationCest
{

    /**
     * @param ApiTester $I
     * @test
     */
    public function given_a_valid_application_i_should_return_202(ApiTester $I)
    {
        $I->sendGet('/applications/app-dummy/health-check');
        $I->seeResponseCodeIs(HttpCode::ACCEPTED);
    }


    /**
     * @param ApiTester $I
     * @test
     */
    public function given_an_invalid_application_i_should_return_404(ApiTester $I)
    {
        $I->sendGet('/applications/no-dummy/health-check');
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
    }
}

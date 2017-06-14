<?php
use yii\helpers\Url as Url;
use app\tests\fixtures\WeatherFixture as WeatherFixture;
class WeatherCest
{
    public function _before(\FunctionalTester $I)
    {
        $I->amOnRoute('/weather');
    }

    public function WeatherPageWithoutParams(\FunctionalTester $I)
    {
        $current_month = date('F', time());
        $current_year = date('Y', time());
        $I->amOnPage(Url::toRoute('/weather'));
        $I->see('My Company');
        $I->see('Weather', 'h1');
        $I->see("$current_month $current_year", 'h2');
    }

    public function WeatherPageWithParams(\FunctionalTester $I)
    {
        $month = 1;
        $month_name = date('F', mktime(0, 0, 0, $month, 10));
        $year = 2017;
        $days_in_month = cal_days_in_month(CAL_GREGORIAN,$month,$year);
        $start_date = date('Y-m-d', mktime(0, 0, 0, $month, 1, $year));
        $end_date = date('Y-m-d', mktime(0, 0, 0, $month, $days_in_month, $year));
        $I->amOnPage(Url::toRoute(['/weather', 'start_date' => $start_date, 'end_date' => $end_date]));
        $I->see("$month_name $year", 'h2');
    }

    public function WeatherPageWithNoData(\FunctionalTester $I)
    {
        $month = 1;
        $month_name = date('F', mktime(0, 0, 0, $month, 10));
        $year = 2018;
        $days_in_month = cal_days_in_month(CAL_GREGORIAN,$month,$year);
        $start_date = date('Y-m-d', mktime(0, 0, 0, $month, 1, $year));
        $end_date = date('Y-m-d', mktime(0, 0, 0, $month, $days_in_month, $year));
        $I->amOnPage(Url::toRoute(['/weather', 'start_date' => $start_date, 'end_date' => $end_date]));
        $I->see('The data you have requested is not complete, you should probably update it.','div.alert');
    }
}

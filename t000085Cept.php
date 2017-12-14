<?php
    $url='/search';

    // Обработка гетаргетинга
    $I = new AcceptanceTester($scenario);
 
    for ($j = 1; $j < count($GLOBALS['region']); $j++) {
        DoTest85($I, $url, $GLOBALS['region'][$j]);  
    } 
    

    function DoTest85($I, $url, $region) {  
        echo "\n\n---> ".$region." <----\n";
    
        $I->resetCookie('userRegion');
  
        GeoTargeting($I, $url, $region);
        $I->wantToTest('Search on site');
        $I->amOnPage($url);
        $I->waitForElementVisible("//h1[text()='Поиск ']", 30);
        
        //Проверка поиска слова 'телефон'
        $I->fillField(['name' => 'q'], 'телефон');
        $I->scrollTo("//button[@class='search_submit']", 1, 1);
        $I->click("//button[@class='search_submit']");
        $I->waitForElementVisible("//div[@class='search-results-list']/font[@class='text']", 30);
        $I->seeElement('//h3/a');
        $I->see('Результаты поиска', 'font');
        $I->seeElement("//a[contains(text(), 'Сортировать по ')]");
        //Проверка поиска несуществующего текста
        $I->fillField(['name' => 'q'], 'иже паки-телефон: вельми поне же');
        $I->scrollTo("//button[@class='search_submit']", 1, 1);
        $I->click("//button[@class='search_submit']");
        $I->waitForElementVisible("//div[@class='search-results-list']/p/font[@class='notetext']", 30);
        $I->see('К сожалению, на ваш поисковый запрос ничего не найдено.');
        //Проверка поиска текста из спец.символов
        $I->fillField(['name' => 'q'], '@#$%¤√·∙°☻♥');
        $I->scrollTo("//button[@class='search_submit']", 1, 1);
        $I->click("//button[@class='search_submit']");
        $I->waitForElementVisible("//font[@class='errortext'][text()='Пустой поисковый запрос, либо запрос содержит менее 3 символов.']", 30);
        $I->see('В поисковой фразе обнаружена ошибка:');
        $I->see('Исправьте поисковую фразу и повторите поиск.');
        //Проверка пустого поиска
        for ($p = 0; $p < 2; $p++) {
            $I->fillField(['name' => 'q'], getRandomString($p));
            $I->scrollTo("//button[@class='search_submit']", 1, 1);
            $I->click("//button[@class='search_submit']");
            $I->waitForElementVisible("//font[@class='errortext'][text()='Пустой поисковый запрос, либо запрос содержит менее 3 символов.']", 30);
            $I->see('В поисковой фразе обнаружена ошибка:');
            $I->see('Исправьте поисковую фразу и повторите поиск.');
        }
    }
 
    
?>
<?php
    $url=$GLOBALS['help_url'];

    $I = new AcceptanceTester($scenario);

    $I->wantToTest('Search on HELP site');
    $I->amOnUrl($url);
    $I->seeElement('input', ['value' => 'Найти']);
    
    //Проверка поиска слова 'телефон'
    $I->fillField("//input[@class='ya-site-form__input-text']", 'телефон');
    $I->scrollTo("//input[@class='ya-site-form__submit']", 1, 1);
    $I->click('Найти');
    $I->switchToNextTab();
    $I->waitForElementVisible("//img[@alt='Яндекс']", 30);
    $I->seeElement("//yass-div[@class='b-head__found'][contains(text(),'нашёл ')]");
    $I->seeElement("//yass-h3[@class='b-serp-item__title']");
    $I->seeElement("//yass-div[@class='b-serp-item__text']");
    $I->seeElement("//yass-div[@class='b-serp-item__links']");
    $I->seeElement("//yass-div[@class='b-pager__pages']");
    $I->seeElement("//yass-div[@class='b-pager__sorted']");
    $I->seeElement("//b[text()='Страницы']");
    $I->closeTab();
    //Проверка поиска несуществующего текста
    $I->fillField("//input[@class='ya-site-form__input-text']", getRandomString(40));
    $I->scrollTo("//input[@class='ya-site-form__submit']", 1, 1);
    $I->click('Найти');
    checkEmptyResults($I, 'Искомая комбинация слов нигде не встречается');
    $I->closeTab();
    //Проверка поиска текста из спец.символов
    $I->fillField("//input[@class='ya-site-form__input-text']", '@#$%¤√·∙°☻♥');
    $I->scrollTo("//input[@class='ya-site-form__submit']", 1, 1);
    $I->click('Найти');
    checkEmptyResults($I, 'Искомая комбинация слов нигде не встречается');
    $I->closeTab();
    //Проверка пустого поиска
    $I->fillField("//input[@class='ya-site-form__input-text']", '');
    $I->scrollTo("//input[@class='ya-site-form__submit']", 1, 1);
    $I->click('Найти');
    checkEmptyResults($I, 'Задан пустой поисковый запрос');
    //End
 

    function checkEmptyResults($I, $message) {
        $I->switchToNextTab();
        $I->waitForElementVisible("//img[@alt='Яндекс']", 30);   
        $I->waitForElementVisible("//yass-div[@class='b-head__found'][text()='найдёт всё. Со временем']",30);
        $I->waitForElementVisible("//b[text()='".$message."']",30);
    }


?>
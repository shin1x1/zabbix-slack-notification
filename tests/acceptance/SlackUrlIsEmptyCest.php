<?php

class SlackUrlIsEmptyCest
{
    public function _before()
    {
        putenv('SLACK_URL_IS_EMPTY=1');
    }

    // tests
    public function tryToTest(TestGuy $I)
    {
        try {
            $I->runShellCommand('./slack.php "#zabbix" OK "HOST: Zabbix server
    TRIGGER_NAME: www.example.com is down
    TRIGGER_STATUS: OK
    TRIGGER_SEVERITY: Average
    DATETIME: 2016.02.17 22:02:37
    ITEM_ID: 24544
    ITEM_NAME: Failed step of scenario "www.example.com".
    ITEM_KEY: web.test.fail[www.example.com]
    ITEM_VALUE: 0
    EVENT_ID: 14582
    TRIGGER_URL:"', false);
        } catch (\Exception $e) {
            // nop
        }

        $I->seeInShellOutput('SLACK_URL is empty.');
    }
}
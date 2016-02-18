#!/usr/bin/env php
<?php
$SLACK_URL = ''; // your incoming webhook url
$ZABBIX_URL = 'https://example.com/zabbix/'; // your zabbix web front url
$SLACK_USER = 'Zabbix';
$SLACK_EMOJI = ':ghost:';

/**
 * @return bool
 */
function isTest()
{
    return (bool)getenv('TEST_MODE');
}

/**
 * @param $message
 */
function dieWithLf($message)
{
    echo $message . PHP_EOL;
    die(1);
}

/**
 * @param array $array
 * @param string $key
 * @return mixed|null
 */
function array_get($array, $key) {
    return array_key_exists($key, $array) ? $array[$key] : null;
}

// bootstrap
if (isTest()) {
    $SLACK_URL = getenv('SLACK_URL_IS_EMPTY') ? '' : 'DUMMY_URL';
}
if (empty($SLACK_URL)) {
    dieWithLf('SLACK_URL is empty.');
}
if (count($argv) < 4) {
    dieWithLf('Usage: ' . $argv[0] . ' channel status params');
}

// parse arguments
$channel = $argv[1];
$subject = $argv[2];

$params = call_user_func(function ($message) {
    $params = array();

    foreach (explode("\n", $message) as $line) {
        $line = trim($line);
        if (preg_match('/^([^:]+):(.+)$/', $line, $matches) < 1) {
            continue;
        }

        $params[$matches[1]] = trim($matches[2]);
    }

    return $params;
}, $argv[3]);

// set post data
$color = call_user_func(function () use ($subject) {
    $color = '';

    if ($subject === 'RECOVERY' OR $subject === 'OK') {
        $color = 'good';
    } else if ($subject === 'PROBLEM') {
        $color = 'danger';
    }

    return $color;
});

$plainText = sprintf("%s: %s %s",
    $subject,
    array_get($params, 'TRIGGER_NAME'),
    array_get($params, 'ITEM_VALUE')
);

$attachments = call_user_func(function () use ($ZABBIX_URL, $subject, $params, $color, $plainText) {
    return array(
        array(
            'color'    => $color,
            'pretext'  => $plainText,
            'fallback' => $plainText,
            'text'     => $ZABBIX_URL,
            'fields'   => array(
                array(
                    'title' => 'Host',
                    'value' => array_get($params, 'HOST'),
                    'short' => true,
                ),
                array(
                    'title' => 'DateTime',
                    'value' => array_get($params, 'DATETIME'),
                    'short' => true,
                ),
                array(
                    'title' => 'Item',
                    'value' => sprintf("%s\n%s = %s",
                        array_get($params, 'ITEM_NAME'),
                        array_get($params, 'ITEM_KEY'),
                        array_get($params, 'ITEM_VALUE')
                    ),
                    'short' => false,
                ),
            )
        )
    );
});

$payload = json_encode(array(
    'channel'     => $channel,
    'username'    => $SLACK_USER,
    'attachments' => $attachments,
    'icon_emoji'  => $SLACK_EMOJI,
));

$context = stream_context_create(array(
        'http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query(array(
                    'payload' => $payload
                ))
            )
    )
);

// post to Slack
if (isTest()) {
    print_r($payload);
} else {
    if (file_get_contents($SLACK_URL, false, $context) === false) {
        dieWithLf('failed post to slack.');
    }
}


<?php
//instagram phone parser
    include './vendor/NumberParser.php';

    $usernames = [
        'USERNAME1', 'USERNAME2', 'USERNAME3',
    ];

    $parser = new NumberParser();
    foreach ($usernames as $username) {
        $parser->setIGUser($username);
        print_r([
            'username' => $username,
            'data' => $parser->get(),
        ]);
    }



<?php
//hangman game

// Start the game

// Output the word mask and the basic hangman Stage 1
// Request to enter a letter
// Check this letter in the array of letters that make up the word
// If there is no letter, change the picture and decrease the number of attempts.

// If there is a letter, change the word mask.

// Check if there are any unsolved letters left.
// If there are none, then the word is solved. If there are any, start this cycle again.

//define('ATTEMPTS', '6'); 
const ATTEMPTS = 6;
startGame();

function startGame()
{
    while (true){
        $word = getWord();
        if (playGame($word) === false) {
            break; // Break the loop if playGame returned false
        }

    };
}
function getWord()
{
    $fileContent = file_get_contents(__DIR__.'/words.txt');
    // Split the content into an array of words using spaces, line breaks, and punctuation
    $words = preg_split('/[\s,.;!?]+/', $fileContent, -1, PREG_SPLIT_NO_EMPTY);
    // Get a random word
    $randomWord = mb_strtolower($words[array_rand($words)]);
    return $randomWord;
}
function playGame($word)
{
    $mask = createMask($word);
    $updatedMask = '';
    echo $mask . PHP_EOL;
    $fails = 0;
    $attempts = ATTEMPTS;
    while (true){
        $letter = mb_strtolower(readline("Enter letter: "));
        $updatedMask = updateMask($word, $mask, $letter);
        if ($updatedMask == $mask) {
            $fails++;
            $attempts--;
        }
        $mask = $updatedMask;
        printImage($fails);
        echo $updatedMask . PHP_EOL;
        echo "Attempts remaining: " . $attempts . PHP_EOL;
        if ($updatedMask === $word) {
            echo 'YEAAH! You won' . PHP_EOL;
            break;
        }

        if ($attempts < 1) {
            echo 'You lost. Attempts are over' . PHP_EOL;
            echo 'The word: '.$word . PHP_EOL;
            break;
        }
    };
    $exit = mb_strtolower(readline("Try again? (y / n): "));
    if ($exit == 'y') {
        return true;
    } else {
        return false;
    }
}
function createMask($word)
{
    return str_repeat('*', mb_strlen($word));
}
function updateMask($word, $mask, $letter)
{
    $updatedMask = '';
    for ($i = 0; $i < mb_strlen($word); $i++) {
        if (mb_substr($word, $i, 1) === $letter) {
            $updatedMask .= $letter;
        } else {
            $updatedMask .= mb_substr($mask, $i, 1);
        }
    }
    return $updatedMask;
}
function printImage($currentAttempt)
{
    switch ($currentAttempt) {
        case 0:
            echo "" . PHP_EOL;
            break;
        case 1:
            echo "
                  -----|
                  |    |
                       |
                       |
                       |
                       - " . PHP_EOL;
            break;
        case 2:
            echo "
                  -----|
                  |    |
                  o    |
                       |
                       - " . PHP_EOL;
            break;
        case 3:
            echo "
                  -----|
                  |    |
                  o    |
                  |    |
                       - " . PHP_EOL;
            break;
        case 4:
            echo "
                  ------|
                   |    |
                   o    |
                  /|\   |
                        - " . PHP_EOL;
            break;
        case 5:
            echo "
                      ------|
                       |    |
                       o    |
                      /|\   |
                      /      - " . PHP_EOL;
            break;
        case 6:
            echo "
                       -----|
                       |    |
                       o    |
                      /|\   |
                      / \     - " . PHP_EOL;
            break;
    }
}

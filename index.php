<?php
//игра виселица

// Начать игру

// Выводим маску слова и базовую виселицу 1 этап
// Запрос на ввод буквы
// Проверяем эту букву в массиве букв из которого состоит слово
// Если нет буквы, меняем картинку и убавляем количество попыток.

// Если есть буква, меняем маску слова. 

// Проверяем остались ли нераскрытые буквы.
// Если не осталось, то слово раскрыто. Если осталось, запускаем этот цикл заново.

//define('ATTEMPT', '6'); 
startGame();

function startGame()
{
    do {
        $word = getWord();
        echo $word;
        if (playGame($word) === false) {
            break; // Прерываем цикл, если playGame вернула false
        }
    } while (true);
}
function getWord()
{
    $fileContent = file_get_contents('/Applications/MAMP/htdocs/hangman/words.txt');
    // Разбиваем содержимое на массив слов, используя пробелы, переносы строк и знаки пунктуации
    $words = preg_split('/[\s,.;!?]+/', $fileContent, -1, PREG_SPLIT_NO_EMPTY);
    // Получаем случайное слово
    $randomWord = mb_strtolower($words[array_rand($words)]);
    return $randomWord;
}
function playGame($word)
{
    $wordLength = mb_strlen($word);
    $mask = createMask($word);
    echo $mask . PHP_EOL;
    $fails = 0;
    $attempts = 6;
    //for ($i = 0; $i <= $attempts; $i++) {
    do{
        $letter = mb_strtolower(readline("Введите букву: "));
        $mask = updateMask($word, $mask, $letter, $fails, $attempts);

        echo $mask . PHP_EOL;
        echo "Попыток осталось: " . $attempts . PHP_EOL;
        if ($mask === $word) {
            echo 'Ура выиграли' . PHP_EOL;
            break;
        }

        if ($attempts < 1) {
            echo 'Проиграли, попытки закончились' . PHP_EOL;
            break;
        }
    }
    while(true);
        //printImage($currentAttempt);
    //}

    $exit = mb_strtolower(readline("Попробовать еще (y / n): "));
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
function updateMask($word, $mask, $letter, &$fails, &$attempts)
{
    $updatedMask = '';
    for ($i = 0; $i < mb_strlen($word); $i++) {
        if (mb_substr($word, $i, 1) === $letter) {
            $updatedMask .= $letter;
        } else {
            $updatedMask .= mb_substr($mask, $i, 1);
        }
    }
    if ($updatedMask == $mask) {
        $fails++;
        $attempts--;
    }
    printImage($fails);
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

<?php

function myLogger($db, $sql, $caller)
{
    // Находим контекст вызова этого запроса.
    $tip = "at ".@$caller['file'].' line '.@$caller['line'];
    // Печатаем запрос (конечно, Debug_HackerConsole лучше).
    echo "<xmp title=\"$tip\">";
    print_r($sql);
    echo "</xmp>";
}

?>

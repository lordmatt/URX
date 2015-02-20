<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <h1>Demo of system in progress.</h1>
        
        <pre>Before we start we get things booted up

        <?php
        
                
        require_once("./UER/a/aLogger.php");
        require_once("./UER/EntityProcessor.php");
        $EP = new EntityProcessor();
        
        
        ?>

Now we take a URL [http://lordmatt.co.uk] and process it:

        <?php

        
        $lm = $EP->getObject('http://lordmatt.co.uk');
        
        echo "\n";
        if($lm){
            echo "result time: ", $lm->render_class();
        }else{
            echo "lm:";
            var_dump($lm);
            echo "<br />error log";
            var_dump($EP->get_error_log());
            echo "<br />";
            echo "<br />EP";
            var_dump($EP);
        }        
        ?>
<br />
So that was pretty limp but it shows that the object system is working.

Now we try a URN - URN:ASIN:1844137902<br />
        <?php
        
        $book = $EP->getObject('URN:ASIN:1844137902');
        
        echo "\n";
        if($book){
            echo "result time: ", $book->render_class();
        }else{
            echo "book:";
            var_dump($book);
            echo "<br />error log";
            var_dump($EP->get_error_log());
            echo "<br />";
            echo "<br />EP";
            var_dump($EP);
        }        
        ?>
        </pre>
    </body>
</html>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <h1>Demo of system in progress.</h1>
        
        <pre>If you left the debug information on this is going to be verbose.

Before we start we get things booted up

        <?php
        
                
        require_once("./UER/URX.php");
        $EP = new EntityProcessor('youtube');
        // uncomment the next line if you dislike debuh data
        // $EP->debugmode=FALSE; // for production edit the aLogger.php file
        
        
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
            var_dump($EP->flush_error_log());
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
            var_dump($EP->flush_error_log());
            echo "<br />";
            echo "<br />EP";
            var_dump($EP);
        }        
        ?>

Next step is a module to do something nice with youtube links. 

At this stage of development I have assumed that youtube is a loaded module.

For this test we will use a long HTTPS link

[https://www.youtube.com/watch?v=lWTl5-wYX9o&feature=youtu.be]

        <?php
        
        $tube = $EP->getObject('https://www.youtube.com/watch?v=lWTl5-wYX9o&feature=youtu.be');
        
        echo "\n";
        if($tube){
            echo "result time:\n\n ", $tube->render_class();
        }else{
            echo "youtube:";
            var_dump($tube);
            echo "<br />error log";
            var_dump($EP->flush_error_log());
        }
        echo "\n\nThe SRN for this (faster to process) is <b>",$tube->get_SRN() , "</b>\n\n";
        
        echo "\n\nAs a link <b>",$tube->render_class('link') , "</b>\n\n";
        ?>

Now short form URL [http://youtu.be/lWTl5-wYX9o]


        <?php
        
        $tube = $EP->getObject('http://youtu.be/lWTl5-wYX9o');
        
        echo "\n";
        if($tube){
            echo "result time:\n\n ", $tube->render_class();
        }else{
            echo "youtube:";
            var_dump($tube);
            echo "<br />error log";
            var_dump($EP->flush_error_log());
        }
        echo "\n\nThe SRN for this (faster to process) is <b>",$tube->get_SRN() , '</b>\n\n';
        
        echo "\n\nAs a link <b>",$tube->render_class('link') , "</b>\n\n";
        
        ?>

(yes, the SRN is the same both times because both URLs point to the same video)

Now as an SRN [SRN:youtube:lWTl5-wYX9o]


        <?php
        
        $tube = $EP->getObject('SRN:youtube:lWTl5-wYX9o');
        
        echo "\n";
        if($tube){
            echo "result time:\n\n ", $tube->render_class();
        }else{
            echo "youtube:";
            var_dump($tube);
            echo "<br />error log";
            var_dump($EP->flush_error_log());
        }
        
        ?>


        </pre>
    </body>
</html>

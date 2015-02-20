<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <h1>Demo of system in progress.</h1>
        
        <pre>
        <?php
        
        require_once("./UER/a/aLogger.php");
        require_once("./UER/EntityProcessor.php");
        $EP = new EntityProcessor();
        
        $lm = $EP->getObject('http://lordmatt.co.uk');
        
        var_dump($lm);
        if($lm){
            echo $lm->render_class();
        }else{
            var_dump($EP->get_error_log());
        }        
        ?>
        </pre>
    </body>
</html>

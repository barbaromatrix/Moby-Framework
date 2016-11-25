<!DOCTYPE html>
<html>
<head>
    <title>Moby Error</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" 
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" 
        integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        
    <style>
        .primary-error{
            padding: 2px 15px;
            border-color: rgb(165, 29, 29);
        }
        .primary-error div{
            font-size: 17px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="jumbotron">
            <h1>Moby Error</h1>
            
            <div class="panel panel-danger primary-error">
                <div class="panel-body">
                    <b>Message:</b> <?= $args->getMessage() ?> <b>File: </b> <?= $args->getFile() ?> <b>Line:</b> <?= $args->getLine() ?> <b>Code: </b> <?= $args->getCode() ?> 
                </div>
            </div>
            
            <br>
            
            <h3>All errors: </h3>
            <ul class="list-group">
                <?php foreach ($args->getTrace() as $trace): ?>
                    <?php if (isset($trace['file']) || isset($trace['line'])): ?>
                        <li class="list-group-item">
                            <?= isset($trace['file']) ? '<b>Error in file: </b>' . $trace['file'] : ''; ?>
                            <?= isset($trace['line']) ? '<b>in line: </b>'. $trace['line'] : ''; ?>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            
        </div>
        
        <div class="jumbotron">
            <h2>Need you Help?</h2>
            <p>Access the Moby documentation or Moby Forum.</p>
            <p>
              <a class="btn btn-lg btn-primary" href="http://doc.mobyframework.com/Errors/Code/<?= $args->getCode() ?>" role="button">Documentation »</a>
              <a class="btn btn-lg btn-info" href="http://forum.mobyframework.com/Errors/Code/<?= $args->getCode() ?>" role="button">Forum »</a>
            </p>
        </div>
    </div>
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" 
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>
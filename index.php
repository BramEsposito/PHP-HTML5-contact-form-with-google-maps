<?php
// http://tutorialzine.com/2014/12/quick-tip-easy-form-validation-with-html5/
// http://getbootstrap.com/css/#forms
// http://www.w3schools.com/php/php_form_validation.asp
// https://www.shutterstock.com/search/similar/75225007
// http://jsfiddle.net/jx6e857y/

$gacode = "UA-XXXXX-X";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $mailto = "website@example.com";
  $mailsubject = 'new submission from example.com';

  $errors = array();

  $messagetext = $name  = $email = $subject = $message = "";

  $name = test_input($_POST["name"]);
  $email = test_input($_POST["email"]);
  $subject = test_input($_POST["subject"]);
  $message = test_input($_POST["message"]);

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = "Please correct your email address"; 
  }

  is_required('name');
  is_required('email');
  is_required('subject');
  is_required('message');

  if (count($errors) > 0) {
    $messagetext = '<div class="alert alert-danger">'.join($errors,"<br>").'</div>';  
  } else {
    // send email
    $mailheaders = 'From: '$mailto . "\r\n" .
    'Reply-To: ' . $mailto . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    $mailmessage =  'From: '.$email.'\n'.
                'Email: '.$email.'\n'.
                'Subject: '.$subject.'\n'.
                'Message: '.$message.'\n';
    mail($mailto, $mailsubject, $mailmessage, $mailheaders);
    // TODO: add logging
    $messagetext = '<div class="alert alert-success">Thank you for your message, we will get in touch shortly.</div>';  
    $name  = $email = $subject = $message = "";
  }
}

function is_required($fieldname) {
  global $errors;
  global $$fieldname;
  $field = $$fieldname;
  if (isset($field) && $field == "") {
    $errors[$fieldname] = "Please enter a value for field \"$fieldname\"";
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function has_error($fieldname) {
  global $errors;
  if(isset($errors[$fieldname])) return " has-error"; 
  return "";
}

?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
    body {
      padding-top: 50px;
      padding-bottom: 20px;
    }
    </style>
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/main.css">
    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
  </head>

  <body>
    <!--[if lt IE 8]>
                <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
            <![endif]-->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <img class="logo" src="img/logo.png" alt="company logo" width="300">
        </div>
      </div>
    </nav>
    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron maps">
      <iframe style="pointer-events:none" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2499.7370815388135!2d4.421942951819587!3d51.2054961404522!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c3f719789619c9%3A0xbec461e04d2b5a48!2sComposito+VOF!5e0!3m2!1sen!2sus!4v1476953070115" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
    </div>
    <div class="container">
      <?php print $messagetext; ?>
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-6">
          <h2>Contact us</h2>
          <p>Aliquam lectus orci, adipiscing et, sodales ac, feugiat non, lacus. Ut dictum velit nec est. Quisque posuere, purus sit amet malesuada blandit, sapien sapien auctor arcu, sed pulvinar felis mi sollicitudin tortor. Maecenas volutpat, nisl et dignissim pharetra, urna lectus ultrices est, vel pretium pede turpis id velit.</p>
          <form action="/" method="post" accept-charset="utf-8">
            <div class="form-group<?php print has_error(" name "); ?>">
              <label for="name">Name:</label>
              <input type="input" id="name" required class="form-control" name="name" value="<?php print $name; ?>">
            </div>
            <div class="form-group<?php print has_error(" email "); ?>">
              <label>Email:</label>
              <input type="email" required name="email" placeholder="Enter a valid email address" title="Please enter a valid email address" class="form-control" value="<?php print $email; ?>">
            </div>
            <div class="form-group<?php print has_error(" subject "); ?>">
              <label for="subject">Subject</label>
              <input type="input" name="subject" required id="subject" class="form-control" value="<?php print $subject; ?>">
            </div>
            <div class="form-group<?php print has_error(" message "); ?>">
              <label for="message">Message:</label>
              <textarea name="message" class="form-control" required id="message" rows="8"><?php print $message; ?></textarea>
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
          </form>
        </div>
        <div class="col-md-6">
          <h2>Heading</h2>
          <p>Aliquam lectus orci, adipiscing et, sodales ac, feugiat non, lacus. Ut dictum velit nec est. Quisque posuere, purus sit amet malesuada blandit, sapien sapien auctor arcu, sed pulvinar felis mi sollicitudin tortor. Maecenas volutpat, nisl et dignissim pharetra, urna lectus ultrices est, vel pretium pede turpis id velit.</p>
        </div>
      </div>
      <hr>
      <footer>
        <p>&copy; Company <?php print date("Y"); ?></p>
      </footer>
    </div>
    <!-- /container -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/main.js"></script>

    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
    <script>
        (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
        function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
        e=o.createElement(i);r=o.getElementsByTagName(i)[0];
        e.src='//www.google-analytics.com/analytics.js';
        r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
        ga('create','UA-XXXXX-X','auto');ga('send','pageview');
    </script>
  </body>
</html>

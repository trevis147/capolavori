<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="icon" type="image/png" href="images/favicon.png">

  <title>Capolavori</title>
  <base href="your_base_url" />
  <meta name="description" content="" />
  <meta name="keywords" content="" />

  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <script src="js/jquery.3.2.1.js"></script>
  <script src="js/owl2carousel.js"></script>
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/owl2carousel.css">
  <link rel="stylesheet" href="css/animate.css">
  <link rel="stylesheet" href="css/sweetalert.css">
  <link rel="stylesheet" href="css/venobox.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/datatables.min.css">
  <script src="https://www.google.com/recaptcha/api.js?onload=captchaCallback&render=explicit"></script>

  <!-- recaptcha -->
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>

  <header class="header-sticky">
    <div class="container">
      <nav class="navbar navbar-expand-xl">
        <a href="#" class="navbar-brand">
          <img src="images/logo.JPG" alt="Logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fa fa-bars text-dark"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <div class="container">
            <ul class="navbar-nav pl-md-5 justify-content-end">
              <!-- Add your navigation items here -->
            </ul>
            <div class="text-center">
              <h1>CONHEÇA NOSSA HISTÓRIA</h1>
            </div>
          </div>
        </div>
      </nav>
    </div>
  </header>

  <!-- Mock data for empresa -->
  <?php
  $d = [
    'Nome' => 'Nome da Empresa',
    'Descricao' => 'Descrição da Empresa'
    // Add other fields as needed
  ];
  ?>

  <!-- Display empresa data -->
  <div id="empresa-data">
    <h2><?php echo $d['Nome']; ?></h2>
    <p><?php echo $d['Descricao']; ?></p>
    <!-- Add other fields as needed -->
  </div>

  <!-- Load Facebook SDK for JavaScript -->
  <div id="fb-root"></div>
  <script>
    function loadFacebookSDK() {
      var js, fjs = document.getElementsByTagName('script')[0];
      if (document.getElementById('facebook-jssdk')) return;
      js = document.createElement('script');
      js.id = 'facebook-jssdk';
      js.src = "https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v3.0";
      fjs.parentNode.insertBefore(js, fjs);
    }
    loadFacebookSDK();
  </script>

  <!-- Your other HTML content goes here -->

</body>

</html>

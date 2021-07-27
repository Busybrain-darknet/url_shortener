<?php
include 'top.php';
?>
<body>
  <!-- ======= Header ======= -->
  <header id="header" class="d-flex align-items-center">
    <div class="container d-flex flex-column align-items-center">
      <h1>URL Shortner</h1>
      <h2>We're working hard to improve our website and we'll ready to launch after</h2>
      <div class="countdown d-flex justify-content-center" data-count="2022/12/30">
        <div>
          <h3>%D</h3>
          <h4>Days</h4>
        </div>
        <div>
          <h3>%H</h3>
          <h4>Hours</h4>
        </div>
        <div>
          <h3>%M</h3>
          <h4>Minutes</h4>
        </div>
        <div>
          <h3>%S</h3>
          <h4>Seconds</h4>
        </div>
      </div>
      <div class="subscribe">
        <h4>Enter a valid long url to shorten or make your link private!</h4>
        <h5><?php
            if (!empty($response)) {
                ?>
            <div id="response" class="<?php echo $response['type']; ?>">
              <?php echo $response["message"]; ?>
              <br><br>
              Copy Your Short Link: <?php echo $response["short_url"]; ?> 
              </div>
            <?php
            }
            ?>
        </h5>
        <form action="" method="post" role="form" class="php-email-form">
          <div class="subscribe-form">
            <input type="url" name="url" required>
            <input type="submit" name="submit" value="Shorten Link">
          </div>
        </form>
      </div>
      <div class="social-links text-center">
        <a href="https://twitter.com/" class="twitter"><i class="icofont-twitter"></i></a>
        <a href="https://facebook.com/" class="facebook"><i class="icofont-facebook"></i></a>
        <a href="https://instagram.com/" class="instagram"><i class="icofont-instagram"></i></a>
        <a href="https://linkedin.com/" class="linkedin"><i class="icofont-linkedin"></i></a>
      </div>
    </div>
  </header><!-- End #header -->
<?php
include 'foot.php';
?>
<?php
require "includes/layouts/header.php";
?>

<div class="container">

  <div class="column">
    <div class="cards">
      <div class="content-card-one">

        <?php
        if (isset($_SESSION['user-uid'])) {
            echo '<h4>
              Welcome back <i class="bi bi-person-fill"></i> '. $_SESSION['user-uid'] .'.
            </h4>';
        }
        else {
            echo '<h4>
              Welcome to plantperfect.
            </h4>';
        }
        ?>

        <p>
          Find plants that are best suited <br />for you.
        </p>

          <br /><br />
          <img class="content-image" src="assets\image\plant3.png" alt="Yucca.">

          <a class="btn" href="#catalog">
            Start shopping.
          </a>

      </div>
    </div>
  </div>

  <div class="column">
    <div class="cards">
      <div class="content-card-two">

        <h4>
          Our mission.
        </h4>

        <p>
          we at plantperfect want to make living rooms and offices literally green with the most beautiful plants.
        </p>

        <br /><br />

        <a class="btn" href="#catalog">
          Check our catalog.
        </a>

      </div>
    </div>
  </div>
</div>

<header>
  <span class="logo">
    <a href="#catalog">
      Check out our plants!
    </a>
  </span>
</header>

<?php
require "includes/layouts/catalog.php";
require "includes/layouts/footer.php";
?>

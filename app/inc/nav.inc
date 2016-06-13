
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="navbar-header"> 
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span> 
    </button>
    <a class="navbar-brand" href="http://gynkar.pl">
    <img src="css/img/logo.gif" alt="logo">  
    </a>
  </div>
  <div class="collapse navbar-collapse" id="myNavbar">
    <ul class="nav navbar-nav">
      <li><a href="dodaj-projekt">Dodaj projekt</a></li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Projekty
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="projekty-otwarte">Otwarte</a></li>
          <li><a href="projekty-zrealizowane">Zrealizowane</a></li>
          <?php if ($user['role_id'] != 4) : ?>
            <li><a href="projekty-zamkniete">Zamknięte</a></li> 
          <?php endif; ?>
        </ul>
      </li>
      <?php if ($user['role_id'] != 4) : ?>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Administracja
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="uzytkownicy">Użytkownicy</a></li>
            <li><a href="kategorie">Kategorie</a></li>
            <li><a href="stacje">Stacje TV</a></li> 
          </ul>
        </li>
      <?php endif; ?>
    </ul>
    <?php if ($user['role_id'] == 1) : ?>
      <ul class="nav navbar-nav">
        <li><a href="faktury">Faktury</a></li>
      </ul>
    <?php endif; ?>
    <ul class="nav navbar-nav navbar-right">
      <li>
        <?php echo '<a href="logout.php" data-toggle="tooltip" data-placement="auto" title="Wyloguj">
        <span class="glyphicon glyphicon-log-out"></span> '  . $user['full_name'] . '</a>'; ?>
      </li>
    </ul>
  </div>
</nav>

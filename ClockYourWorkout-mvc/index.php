
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Projeto Software</title>
  <link rel="stylesheet" href="css/inicio.css">
  <script defer src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
  <script defer src="script.js"></script>
</head>
<body>
<!-- NAV BAR -->
  <nav class="navbar">
    <div class="max-width">
      <ul class="menu">
       <li><a>ClockYourWorkout</a></li>
      </ul>
    </div>
  </nav>
  
  <!-- HOME SECTION -->
  <section class="home" id="home">
    <div class="max-width">
      <div class="home-content">
        <div class="text-1">Olá, bem vindo ao</div>
        <div class="text-2"><span>ClockYour</span><span>Workout</span>!</div>
        <div class="text-3"><span class="typing"></span></div>
        <a href="Views\cadastro.php">Sign Up</a>
        <a href="Views\login.php">Sign In</a>
      </div>
    </div>
  </section>

  <!-- PROJECT SECTION -->
  <section class="projetos" id="projetos">

</section>  

<section class="contact" id="contact">
    <div class="max-width">
        <div class="contact-content">
            <div class="coluna left">
                <div class="coluna">
                    <div class="info">
                        <div class="head">Name</div>
                        <div class="sub-title">ClockYourWorkout</div>
                    </div>
                </div>
                <div class="coluna">
                    <div class="info">
                        <div class="head">Phone</div>
                        <div class="sub-title">------</div>
                    </div>
                </div>
                <div class="coluna">
                    <div class="info">
                        <div class="head">Email</div>
                        <div class="sub-title">nickmanraujo@gmail.com</div>
                    </div>
                </div>
            </div>
            <div class="coluna right">
                <div class="text">Nos contate:</div>
                <form action="process_form.php" method="post">
                    <div class="campos">
                        <div class="campo name">
                            <input type="text" name="name" placeholder="Name" required />
                        </div>
                        <div class="campo email">
                            <input type="email" name="email" placeholder="Email" required />
                        </div>
                    </div>
                    <div class="campo">
                        <input type="text" name="subject" placeholder="Subject" required />
                    </div>
                    <div class="campo textarea">
                        <textarea name="message" cols="30" rows="10" placeholder="Message.." required></textarea>
                    </div>
                    <div class="button-area">
                        <button type="submit">Send message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

  <!-- FOOTER SECTION -->
  <footer>
  <span>Criado por 
          <a>@Gabriel Alexandre</a>
          <a>@Nicolas Mantovani</a>
          <a>@Raphael Dantas</a>
          <a>@Victor Nunes</a>
        </span>
  </footer>
</body>
</html>
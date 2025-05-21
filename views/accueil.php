<?php

if (isset($_SESSION['user_id'])) {
    header('Location: /views/home.php');
    exit;
}
?>

<?php include __DIR__ . '/partials/header.php'; ?>

<!-- Hero -->
<section class="hero">
    <div class="hero-text">
        <h1 class="hover-gradient">Bienvenue sur la plateforme Esportify</h1>
        <p>Rejoins la scène e-sport comme jamais auparavant. <br>
            Découvre, organise et participe aux tournois les plus palpitants. <br>
            Que tu sois joueur, fan ou organisateur, Esportify est ton terrain de jeu.</p>
    </div>
    <div class="hero-logo">
        <img src="/img/logo-vide.png" alt="logo esportify" />
    </div>
</section>

<!-- Section banner -->
<section class="section-banner">
    <div class="banner-content"></div>
</section>

<!-- Section Esport -->
<section class="section-esport">
    <div class="slideshow-container">
        <img class="mySlides active" src="/img/gamer.jpg" alt="PC gamer" style="width:100%">
        <img class="mySlides" src="/img/gamer2.jpg" alt="PC gamer" style="width:100%">
        <img class="mySlides" src="/img/gamer3.jpg" alt="PC gamer" style="width:100%">
    </div>

    <div class="esport-content">
        <h2><span class="gradient-text">Entre dans l'esport</span></h2>
        <p>Depuis sa création en mars 2021, Esportify s’impose comme un moteur
            de l’innovation dans l’univers de l’esport. En orchestrant des compétitions intenses et accessibles, nous réunissons des joueurs passionnés venus de tous horizons. Notre mission : faire vibrer la scène esport en offrant des expériences uniques, tournées vers l’excellence et l’avenir.</p>
        <ul class="features">
            <li>
                <img src="/img/i1.png" alt="icone gaming">
                <p>Rejoins le game</p>
            </li>
            <li>
                <img src="/img/i2.png" alt="icone communauté">
                <p>Discute avec les joueurs</p>
            </li>
            <li>
                <img src="/img/i3.png" alt="icone compétition">
                <p>Participe aux compétitions</p>
            </li>
            <li>
                <img src="/img/i4.png" alt="icone trophée">
                <p>Remporte des prix</p>
            </li>
        </ul>
        <a href="/index.php?page=register" class="btn btn-accent">Je m'inscris</a>
    </div>
</section>

<!-- Lives en cours -->
<section class="section-lives">
    <h2><span class="gradient-text">Lives en cours</span></h2>
    <div class="lives-grid" id="lives-en-cours"></div>
</section>

<!-- Lives à venir -->
<section class="section-lives">
    <h2><span class="gradient-text">Lives à venir</span></h2>
    <div class="lives-grid" id="lives-a-venir"></div>
</section>

<!-- Newsletter -->
<section class="newsletter" id="newsletter">
    <?php
    if (isset($_SESSION['newsletter_feedback'])) {
        $msg = $_SESSION['newsletter_feedback'];
        echo '<p style="color:' . (isset($msg['error']) ? 'red' : 'green') . ';">' . htmlspecialchars($msg['error'] ?? $msg['success']) . '</p>';
        unset($_SESSION['newsletter_feedback']);
    }
    ?>
    <h2>Rejoins nous</h2>
    <p>Prends part à l'aventure</p>
    <form action="/index.php?controller=subscribe_newsletter" method="POST">
        <input type="email" name="email" placeholder="E-mail" required />
        <button type="submit" class="btn">S'inscrire</button>
    </form>
</section>


<?php include __DIR__ . '/partials/footer.php'; ?>
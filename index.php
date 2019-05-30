<?php include 'includes/header.php' ?>

<body>

<div class="hero">
    <img class="hero-image" src="images/hero-image.jpg">
    <h1 class="hero-title">Lieke van Vegchel</h1>
</div>

<nav id="navigation">
    <ul class="nav-items">
        <li class="kopje SCO current" id="SCO">Strategie & Concept</li>
        <li class="kopje UXU" id="UXU">User Experience</li>
        <li class="kopje DED" id="DED">Development</li>
        <li class="kopje PTM" id="PTM">Proftaak</li>
    </ul>
</nav>

<div class="assignments">

<!--// ---------- de verschillende vakken worden opgehaald uit de database---------- //-->
    <?php
        require 'database/connection.php';

        $vakken = $db->query("
                        SELECT *
                        FROM vakken
                    ")->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <?php if (empty($vakken)): ?>
        <p>Sorry, no vakken at the moment</p>
    <?php else: ?>
        <?php foreach ($vakken as $vak): ?>
            <?php

            //Dit is een variabele waar de naam van het 'gekozen' vak wordt ingeladen.
            $thisVak = $vak['vakNaam'];

            //Deze query selecteert de resultaten waar het vak gelijk is aan
            //bovenstaande variabele waar dus het gekozen vak wordt ingeladen.
            //De leerdoelen die bij het vak horen worden weergegeven
            $leerdoelen = $db->query("
					SELECT *
					FROM leerdoel
					WHERE vak = '$thisVak';
				")->fetchAll(PDO::FETCH_ASSOC);
            ?>

<!--            Per vak worden de bijbehorende leerdoelen weergegeven en wordt de pagina aangemaakt-->
            <ul class="vak <?php echo $thisVak; ?>">
                <?php foreach ($leerdoelen as $leerdoel): ?>
                    <li class="leerdoel">
                        <a href="<?= BASE_URL; ?>/leerdoel.php?id=<?= $leerdoel['id']; ?>">
                            <p class="leerdoel-text"><?= $leerdoel['title'] ?></p>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endforeach; ?>
    <?php endif; ?>
</div>


<script type="text/javascript">

    $(document).ready(function() {

        //Als de pagina opstart zijn alleen de leerdoelen van SCO zichtbaar
        $(".vak").hide();
        $(".SCO").show();

        //Als je op een vak (heet het kopje) klikt wordt de variable 'selectedProject' gelijk aan het id die daarbij hoort.
        $(".kopje").click(function() {
            $(".vak").hide();
            var selectedProject = $(this).attr('id');

            //Het verkregen id komt overeen met een class. Die bijbehorende class wordt dan zichtbaar.
            $("." + selectedProject).show();

            $(".kopje").removeClass('current');
            $(this).addClass('current');

            //Wanneer er op een vak geklikt wordt scrollt te pagina automatisch naar beneden.
            $('html, body').animate({
                scrollTop: $('#navigation').position().top+'px'
            }, 800)
        })

    })
</script>

<?php include 'includes/footer.php' ?>
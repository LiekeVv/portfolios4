<?php include 'includes/header.php'; ?>

<a class="terug" onclick="goBack()">Terug</a>

<script>
    function goBack() {
        window.history.go(-1);
    }
</script>

<div class="wrapper">
    <?php
        require 'database/connection.php';

        $leerdoelId = $_GET['id'];

// ---------- de informatie van de leerdoelen wordt opgehaald met een query---------- //

        $query = $db->prepare("SELECT * FROM leerdoel WHERE id = '$leerdoelId'");
        $query->execute();
        $leerdoelInformatie = $query->fetchAll(); ?>

<!--// ---------- de informatie wordt weergegeven ---------- //-->
        <?php foreach ($leerdoelInformatie as $leerdoelInfo) : ?>

            <h1 class="titel-leerdoel" id="<?= $leerdoelInfo['id'] ?>">
                <?= $leerdoelInfo['title']; ?>
            </h1>

            <div class="uitleg-leerdoel" " id="<?= $leerdoelInfo['id'] ?>">
                <?= $leerdoelInfo['criterium']; ?>
            </div>

        <?php endforeach; ?>

        <?php
        //Controleert of er een pagina aanwezig is.
        if (!$_GET['id']) {
            header('Location: index.php');
        }

// ---------- informatie van opdrachten wordt opgehaald ---------- //
        $stmt = $db->prepare("SELECT * FROM opdracht WHERE leerdoelId = '$leerdoelId' OR leerdoelId2 = '$leerdoelId' OR leerdoelId3 = '$leerdoelId' OR leerdoelId4 = '$leerdoelId' OR leerdoelId5 = '$leerdoelId'");
        $stmt->execute();
        $opdrachten = $stmt->fetchAll();

// ---------- van elke opdracht wordt de benodigde informatie weergegeven ---------- //
        if ($opdrachten) : ?>
            <?php foreach ($opdrachten as $opdracht) : ?>

                <?php $id = $opdracht['leerdoelId']; ?>

                <div class="title">
                    <h1 class="opdracht-title" id="<?= $opdracht['id'] ?>">
                        <?= $opdracht['name']; ?>
                    </h1>

                    <i class="fas fa-chevron-down"></i>
                </div>

<!--// ---------- de informatie van de opdrachten ---------- //-->
                <div class="opdracht-tekst" id="<?= $opdracht['id'] ?>">
                    <?= $opdracht['description']; ?>

                    <div class="tussenkopje aanleiding" id="aanleiding<?= $opdracht['id'] ?>">Aanleiding</div>
                    <?= $opdracht['aanleiding']; ?>

                    <div class="tussenkopje methode" id="methode<?= $opdracht['id'] ?>">Methode</div>
                    <?= $opdracht['methode']; ?>

                    <div class="tussenkopje conclusie" id="conclusie<?= $opdracht['id'] ?>">Conclusie</div>
                    <?= $opdracht['conclusie']; ?>

                    <div class="tussenkopje link" id="link<?= $opdracht['id'] ?>"></div>


                    <?php
                        $link = explode(",", $opdracht['link']);
                        $length = count($link);

                        for($x = 0; $x < $length; $x++) {
                            ?><a href="<?php echo $link[$x]; ?>" target="_blank">Klik hier voor het document</a><?php
                            echo "<br>";
                    }?>
                </div>
<!--// ---------- hier wordt gekeken of de tussenkopjes nodig zijn of niet---------- //-->
                <?php

                    if (empty($opdracht['aanleiding'])) { ?>
                        <script>
                            $("#aanleiding<?= $opdracht['id'] ?>").hide();
                        </script>
                    <?php }

                    if (empty($opdracht['methode'])) { ?>
                        <script>
                            $("#methode<?= $opdracht['id'] ?>").hide();
                        </script>
                    <?php }

                    if (empty($opdracht['conclusie'])) { ?>
                        <script>
                            $("#conclusie<?= $opdracht['id'] ?>").hide();
                        </script>
                    <?php }

                    if (empty($opdracht['link'])) { ?>
                        <script>
                            $("#link<?= $opdracht['id'] ?>").hide();
                        </script>
                    <?php } ?>
                <?php endforeach; ?>
        <?php else : ?>
            <p>Er zijn helaas geen opdrachten bij dit leerdoel</p>
    <?php endif; ?>

</div>

<!--// ---------- dit script zorgt ervoor dat de informatie verdwijnt en kan verschijnen ---------- //-->
<script type="text/javascript">
    $(document).ready(function(){

        $(".opdracht-tekst").hide();

        $('.title').click(function() {
            $(this).next('.opdracht-tekst').toggle();
        })
    });
</script>

<?php include 'includes/footer.php'; ?>
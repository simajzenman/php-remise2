<!DOCTYPE html>
<html class="no-js" lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="My project" content="formulaire destiné aux étudiants de l'ESIAJ">
    <meta name="Simon Ajzenman" content="Formulaire de contact crée par Simon Ajzenman">
    <?php
            include 'opengraph.php';
    ?>
    <title>Formulaire | Cercle des étudiants de l ESIAJ</title>
    <link href="https://bootswatch.com/paper/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
 
<body>

<main>

    <div class="container">
 
        <div class="page-header">
            <h1 class="h3">Tu es presque avec nous</h1>
            <p>On a juste besoin que tu remplisses ce formulaire. Attention, les labels suivis d'un "*" sont obligatoires</p>
           

        </div>



            <?php

            //Variable servant à vérifier que tout les champs sont valides et prêt à l'envoi.
            //on utilise le $GLOBALS pour rendre cette variable utilisable dans d'autres fonctions
            //source: http://www.commentcamarche.net/forum/affich-64288-rendre-un-variable-globale-en-php
            $GLOBALS[$allright]=true; 

            function allIsGooD(){
                //fonction qui va permettre de vérifier si la variable est toujours true
                //si elle l'est on prend les valeur des input que l'on va mettre dans le mail
                if ( isset($_POST) && !empty($_POST) ) {
                    $prenom=$_POST["prenom"];
                    $nom=$_POST["nom"];
                    $email=$_POST["email"];
                    $date=$_POST["date"];
                    $adresse=$_POST["adresse"];
                    $commune=$_POST["commune"];
                    $ville=$_POST["ville"];
                    if ($GLOBALS[$allright] == true) {
                        //on envoit aussi un feedback positifi à l'
                        echo "<p class='green'> Merci d'avoir rempli ce formulaire, vos réponses ont bien été enregistrées</p>";
                        mail("simajzenman@gmail.com","Nouvelle inscription de".$prenom." ".$nom,"Cette personne est née le ".$date.
                            " et habite à ".$adresse." ".$commune." ".$ville);
                    }

                  
                }
            }

            //fonction servant à vérifier si les champs sont valides
            function fieldIsValid($field){
                $field=trim(strip_tags($field));
                return $field;
            }

            //fonction servant à vérifier si l'adresse email est valide
            function emailIsValid($lemail){
                $lemail=trim(strip_tags($lemail));
                return filter_var($lemail, FILTER_VALIDATE_EMAIL);
            }

            //fonction permettant de récupérer les valeurs des champs
            //pour les replacer dans l'input si l'utilisateur se trompe
            function getLastAnswer($catched_answer){
                $toto = $_POST[$catched_answer];
                if ( isset($_POST) && !empty($_POST) ) {
                    echo ('value="'.$toto.'"');
                }
            }

            //fonction similaire, mais appliquée directement
            //dans la balise textarea, vu que le textarea n'a pas de value
            function getAdresse($catched_answer){
                $toto = $_POST[$catched_answer];
                if ( isset($_POST) && !empty($_POST) ) {
                    echo ($toto);
                }
            }

        
            //fonction servant à préremplir l'input de type "radio"
            function getRadio($bapteme){
                if ($_POST["bapteme"]===$bapteme) {
                    echo ('checked');
                }
            }


            //Application du honey-put
            if (!empty($_POST["nom1"])) {
                    die("nice try, but you loose");
            }

            if ( isset($_POST) && !empty($_POST) ) {
                //on initie un tablie contenant les attribut "name" de tout les input
                $answer = array('prenom','nom','date','adresse','commune','ville' );
                foreach ($answer as $input) {
                    //pour chaque clé dans le tableau on va utilisé le nom de la clé
                    // pour récupérer ce que l'utilisateur a écrit, le stocker dans la
                    //variable toto pour ensuite la "purifier" par la fonction fieldIsValid
                    //de plus si il y a erreur la variable $allright passe à false pour éviter le feedback positif
                    $toto=$_POST[$input];
                    if (fieldIsValid($toto)=="") {
                        echo "<p class='red'>Désolé,mais malheureusement il y'a une erreur au niveau de votre ".$input."</p>";
                        $GLOBALS[$allright] = false;
                    }
                }

                $email = $_POST["email"];
                //fonction du validation de l'email, on  doit faire le mail
                //dans une fonction différente car en cas d'erreur la fonction
                //ne retourne pas un "", mais un false
                if (emailIsValid($email)===false) {
                    echo "<p class='red'>Désolé,mais malheureusement il y'a une erreur au niveau de votre adresse e-mail</p>";
                    $GLOBALS[$allright] = false;
                }

            }

            //on appelle la fonction allIsGooD(); pour le feeback positif et l'envoi du mail

            allIsGooD();   
       
    ?>
 
        <form action="#" method="post">
            <ul class="list list-unstyled row">

                <li class="form-group col-xs-4 nom_spec">
                    <label for="nom1">Nom *</label>
                    <input class="form-control" name="nom1" id="nom1">
                </li>


                <li class="form-group col-xs-6">
                    <label for="prenom">Prénom *</label>
                    <input type="text" class="form-control" name="prenom" id="prenom" placeholder="Albert" <?php getLastAnswer("prenom"); ?> required>
                </li>


                <li class="form-group col-xs-6">
                    <label for="nom">Nom * </label>
                    <input type="text" class="form-control" name="nom" id="nom"  placeholder="Jacquard" <?php getLastAnswer("nom"); ?> required>
                </li>

 
                <li class="form-group col-xs-6">
                    <label for="email">Email *</label>
                    <input class="form-control" name="email" id="email" type="email" placeholder="albert.jacquard@gmail.com" <?php getLastAnswer("email"); ?> required>
                </li>

                <li class="form-group col-xs-6">
                    <label for="date">Date de naissance (Jour/Mois/Année) *</label>
                    <input class="form-control" name="date" id="date" placeholder="23/12/1925" <?php getLastAnswer("date"); ?> required>
                </li>

                <li class="form-group col-xs-6">
                    <label for="adresse">Adresse</label>
                    <textarea class="form-control" name="adresse" id="adresse" placeholder="Avenue Conte de Smet De Neyer 20"><?php getAdresse("adresse"); ?></textarea>
                </li>


                <li class="form-group col-xs-2">
                    <label for="commune">Commune</label>
                    <input class="form-control" name="commune" id="commune" <?php getLastAnswer("commune"); ?> placeholder="5000">
                </li>

                 <li class="form-group col-xs-4">
                    <label for="ville">Ville </label>
                    <input class="form-control" name="ville" id="ville" <?php getLastAnswer("ville"); ?> placeholder="Namur">
                </li>


                <li class="form-group col-xs-12 form-group-question">
                    <legend class="bodyStyle">Qu'attends-tu le plus de ton baptême *</legend>
                    <ul class="noLeft">
                        <li class="bodyStyle left">
                            <input required  id="meet" type="radio" name="bapteme" <?php getRadio("meet"); ?> value="meet">
                            <label for="meet">Rencontrer de nouvelles personnes</label>
                            
                        </li>

                        <li class="bodyStyle left">
                            <input required  id="fun" type="radio" name="bapteme" <?php getRadio("fun"); ?> value="fun">
                            <label for="fun">Gindailler</label>
                            
                        </li>


                        <li class="bodyStyle left">
                            <input required  id="experience" type="radio" name="bapteme" <?php getRadio("xp"); ?> value="xp">
                            <label for="experience">Vivre de nouvelles expériences</label>
                            
                        </li>

                    </ul>
                        
                       

                 </li>
 
                <li class="form-group col-xs-12 submit">
                    <input type="submit" name="submit" class="btn btn-primary" value="envoyer">
                </li>
            </ul>

        </form>

        <a href="#">Code source disponible sur Github</a>
    </div>
</main>

</body>
</html>

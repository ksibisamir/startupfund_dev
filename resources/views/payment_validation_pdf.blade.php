<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .header{
            margin:30px 0px 50px 0px;
        }
        .col-md-6{
            padding:0px;
        }
        h2{
            margin-bottom:50px;
            font-weight: normal;
        }
        body{
            font-size:18px;
            text-align:justify;
        }
        section.signature{
            margin-top: 15px;
            float: right;
        <!--
        margin-bottom:30px;
        -->
        }
        .content{
            padding: 20px;
        }
        footer{
            margin-top: 400px;
            font-size:14px;
        }
        .amount-letters{
            text-transform: capitalize;
        }
    </style>
</head>

<body>
<div class="content">
    <div class="header row">
        <div class="text-left" style="width: 50%">
            <img width="200px" src="{{ asset('assets/images/startup-fund.png') }}">

        </div>
        <div class="text-right" style="width: 50%">
            <img src="http://www.startup-fund.tn/assets/images/ajyal_capita.png">
        </div>
    </div>

    <h2 class="text-center">BULLETIN DE SOUSCRIPTION</h2>
    <p>
        Nous soussignés AJYAL CAPITAL société de gestion de portefeuilles de valeurs mobilières pour le compte de tiers.
    </p>
    <p>
        Déclarons avoir reçu le : {{ date('d/m/Y') }}
    </p>
    <p>
        <span style="margin-right: 30px">De Mr/Mme: {{$user->name}} {{$user->first_name}}</span> Identifiant : {{$user->tledger_wallet_id}}
    </p>
    <p>
        Titulaire de la CIN/Passeport n° {{$user->cin}}
    </p>
    <p>
        Le montant en chiffres: {{$amount}} Dinars.
    </p>
    <p>
        Le montant en lettres: <span class='amount-letters'>{{$amount_letters}}</span> Dinars.
    </p>
    <p>
        Pour {{$amount / 10}} parts du fonds.
    </p>
    <p>
        Au titre de parts de fonds FCPR sous la dénomination « Startup Fund » visa d’émission du
        CMF sous le numéro 19-0348 en date du 14 Février 2019 régi par le code des organismes
        de placement collectif promulgué par la loi n°2001-83 du 24 juillet 2001.
    </p>
    <p>
        La somme sus indiquée sur la présente attestation donne droit aux déductions prévues par
        l’article 39 du code de l’impôt sur les revenus des personnes physiques et de l’impôt sur les
        sociétés tel que modifié et complété par les textes subséquents et l’article 77 du code de
        l’impôt sur les revenus des personnes physiques et de l’impôt sur les sociétés ajouté par la
        loi n°2017-8 du 14 février 2017 portant refonte du dispositif des avantages fiscaux.
    </p>
    <section class="signature">
        <div style=margin-left:30px;>AJYAL CAPITAL</div>
        <img  src="{{ asset('assets/images/pdf_signature.jpg') }}">
    </section>
    <footer>
        <div class="row">
            <div class="text-left" style="width: 45%">
                <img src="http://www.startup-fund.tn/assets/images/ajyal_capita.png">
            </div>
            <div class="text-left" style="width: 55%">
                Société de Gestion de Portefeuilles de Valeurs Mobilières
                pour le Compte de Tiers, AGR du CMF du 16 Février 2017
                Adresse : 55 Jardins du Lac, Berges du Lac II, 1053 Tunis.
                Tél : +216 70 81 70 44 Fax : +216 70 81 70 45
                E-mail : contact@ajyalcapital.tn
            </div>
        </div>
    </footer>
</div>
</body>
</html>


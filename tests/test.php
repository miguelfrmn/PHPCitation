<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PHPCitation\Citation;

$data = [
    'authors' => [
        [
            'first_name' => 'Silvia',
            'last_name' => 'Marcos García'
        ],
        [
            'first_name' => 'Laura',
            'last_name' => 'Alonso Muñoz'
        ],
        [
            'first_name' => 'Andreu',
            'last_name' => 'Casero Ripollés'
        ]
    ],
    'title'             => 'Usos ciudadanos de Twitter en eventos políticos relevantes.La #SesiónDeInvestidura de Pedro Sánchez.',
    'publication_title' => 'Comunicación y Hombre',
    'publication_volume' => null,
    'publication_issue' => 13,
    'publication_issn'  => '1885-365X',
    'date'              => '2017-04-15',
    'url'               => 'http://portalderevistas.ufv.es:8080/comunicacionyhombre/article/view/214',
    'access_date'       => date('Y-m-d') 
];

$cite = new Citation($data);

?>

<h1>APA</h1>
<pre><?= $cite->apa() ?></pre>

<h1>ABNT</h1>
<pre><?= $cite->abnt() ?></pre>


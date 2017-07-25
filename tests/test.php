<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PHPCitation\Citation;

$data = [
    'type' => 'article', // Used for BibTex,
    'label' => 'CyH214',  // Used for BibTex,
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
    'abstract'         => 'Twitter está introduciendo importantes novedades en la comunicación política y se ha tornado un espacio en el que los ciudadanos debaten sobre cuestiones de interés público. Esta investigación analiza el empleo que la ciudadanía hace de Twitter durante un acontecimiento político relevante: la investidura del candidato socialista a la presidencia, Pedro Sánchez. Se aplica un análisis de contenido a través de la etiqueta #SesiónDeInvestidura. Los resultados señalan que los ciudadanos utilizan esta red social para criticar y mostrar su  descontento con la política y su atención se centra en los aspectos personales de los diputados y no en sus propuestas.',
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

<h1>BibTex</h1>
<pre><?= $cite->bibtex() ?></pre>

<h1>APA</h1>
<pre><?= $cite->apa() ?></pre>

<h1>ABNT</h1>
<pre><?= $cite->abnt() ?></pre>


<?php

require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

// $uri = 'mongodb+srv://Yunevo:Yunevo20231125@cluster0.vaxqlc9.mongodb.net/?retryWrites=true&w=majority';

// // Créez une instance client MongoDB pour vous connecter à la base de données
// $client = new Client($uri);

// try {
//     // Envoyez une commande ping pour confirmer la connexion réussie
//     $client->selectDatabase('admin')->command(['ping' => 1]);
//     echo "Connexion réussie à MongoDB！\n";
// } catch (Exception $e) {
//     echo "erreur de connexion：", $e->getMessage(), "\n";
// }


// Créer une instance client S3
$s3Client = new S3Client([
    'version' => 'latest',
    'region'  => 'ca-central-1',
    'credentials' => [
        'key'    => 'AKIAVOVQX37LAXQTKUGL',
        'secret' => '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',
    ],
]);

// Essayez de répertorier les buckets
try {
    $result = $s3Client->listBuckets();
    foreach ($result['Buckets'] as $bucket) {
        echo $bucket['Name'] . "\n";
    }
} catch (AwsException $e) {
    // Message d'erreur de sortie
    echo $e->getMessage();
    echo "\n";
}

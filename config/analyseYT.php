<?php
// Empêche accès direct à ce fichier
/*if (basename($_SERVER['SCRIPT_FILENAME']) === basename(__FILE__)) {
    http_response_code(403);
    echo json_encode(['error' => 'Accès interdit.']);
    exit;
}
*/

set_time_limit(500);

$config = require(__DIR__ . '/keys.php');
$YTKey = $config['YOUTUBE_KEY'];
$GROQKey = $config['GROQ_KEY'];
$videoId = "";

function getYoutubeComments($vidID, $maxTotal = 500) {
    global $YTKey;
    $comments = [];
    $pageToken = null;

    while (count($comments) < $maxTotal) {
        $url = 'https://www.googleapis.com/youtube/v3/commentThreads?' . http_build_query([
            'part' => 'snippet',
            'videoId' => $vidID,
            'maxResults' => 100,
            'order' => 'relevance',
            'key' => $YTKey,
            'pageToken' => $pageToken
        ]);

        $json = @file_get_contents($url);
        $data = json_decode($json, true);

        if (empty($data['items'])) break;

        foreach ($data['items'] as $item) {
            $comments[] = $item['snippet']['topLevelComment']['snippet']['textDisplay'];
            if (count($comments) >= $maxTotal) break;
        }

        $pageToken = $data['nextPageToken'] ?? null;
        if (!$pageToken) break;
    }

    return $comments;
}

//IA GROQ
function calculBatch($n){
    $minBatchSize = 10;
    $maxBatchSize = 20;
    $minConcurrency = 5;
    $maxConcurrency = 20;
    $batchSize = max($minBatchSize, min($maxBatchSize, intval($n * 0.05)));
    $totalBatches = ceil($n / $batchSize);
    $concurrency = max($minConcurrency, min($maxConcurrency, intval($totalBatches * 0.2)));
    return [$batchSize,$concurrency];
};

function multiPrompts($prompts){
    global $GROQKey;
    $multiHandle = curl_multi_init();
    $curlHandles = [];
    foreach ($prompts as $i => $prompt){
        $data = [
            'model' => 'llama-3.3-70b-versatile',
            'messages' => [
                ['role' => 'system', 'content' => '
                    Tu es un analyste de sentiment qui utilise les commentaires vidéo pour analyser une vidéo. Les commentaires peuvent être ironiques, familiers, avec emojis ou références pop culture.
                    Analyse chaque commentaire et retourne un seul objet JSON par commentaire avec :
                    {
                      "comment": (texte analysé,corrigé et lisible),
                      "positivity": (float, 0–1),
                      "neutrality": (float, 0–1),
                      "negativity": (float, 0–1),
                      "toxicity": (float, 0–1),
                      "badbuzz": {
                        "score": (float, 0–1),
                        "reason": (string, cause du bad buzz ou vide)
                      },
                      "bonus": (string, synthese courte du positif ou vide),
                      "malus": (string, synthese courte du negatif ou vide)
                    }
                    Règles :
                    - Si le commentaire contient une donnée personnelle (nom, email, numéro, etc.) → renvoyer `{}`.
                    - Si aucun avis ou opinion n’est exprimé → renvoyer `{}`.
                    Ne renvoie **que** les JSON. Voici les textes à analyser :
                '],
                ['role' => 'user', 'content' => $prompt]
            ],
            'temperature' => 0.3
        ];

        $ch = curl_init('https://api.groq.com/openai/v1/chat/completions');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//a enlever
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);//a enlever
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $GROQKey,
            'Content-Type: application/json',
        ]);

        curl_multi_add_handle($multiHandle, $ch);
        $curlHandles[$i] = $ch;
    }
    $mainJSON = [];
    $running = null;
    do {
        curl_multi_exec($multiHandle, $running);
        curl_multi_select($multiHandle);
    } while ($running > 0);

    // Récupérer les réponses
    foreach ($curlHandles as $i => $ch) {
        if (!curl_errno($ch)) {
            $response = curl_multi_getcontent($ch);
            $decoded = json_decode($response, true);
            if (json_last_error() === JSON_ERROR_NONE
                && is_array($decoded)
                && isset($decoded['choices'][0]['message']['content'])) {

                $subJson = json_decode($decoded['choices'][0]['message']['content'], true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($subJson)) {
                    $mainJSON = array_merge($mainJSON, $subJson);
                }
            }
        }
        curl_multi_remove_handle($multiHandle, $ch);
        curl_close($ch);  
    }
    curl_multi_close($multiHandle);
    return $mainJSON;
};

function getAnalyseYT($data){
    $globalJSON = [];
    if(count($data) >= 1){
        echo "lng init : " . count($data) . "\n";
         echo "<br>";
        //traitement
        $cleaned = [];
        foreach ($data as $str) {
            $str = mb_convert_encoding($str, 'UTF-8', 'UTF-8');
            $str = trim($str);
            if (mb_strlen($str) <= 700) {
                $cleaned[] = $str;
            }
        }
        echo "lng clean : " . count($cleaned) . "\n";
         echo "<br>";
        //préparation de requêtes
        //$fact = calculBatch(count($cleaned));
        // $batchsize = $fact[0];
        // $rqstfactor = $fact[1];
        $batchsize = 13;
        $rqstfactor = 5; 
        $comsChunk = array_chunk($cleaned, $batchsize);
        $batchs = array_map(function($sousListe) {
            $tableauAssoc = array_map(function($item) {
                return ["comment" => $item];
            }, $sousListe);
            return json_encode($tableauAssoc);
        }, $comsChunk);
        $requestChunks = array_chunk($batchs, $rqstfactor);
        //paquets de requêtes
        echo "Com par paquet : " . $batchsize . "\n";
         echo "<br>";
        echo "Rqst simultanée : " . $rqstfactor . "\n";
         echo "<br>";
        foreach ($requestChunks as $prompts) {
            echo "lancement". "\n";
            $interJson = multiPrompts($prompts);
            $globalJSON = array_merge($globalJSON,$interJson);
            sleep(61);
        }
        file_put_contents("resultats.json", json_encode($globalJSON, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }else{
        file_put_contents("resultats.json", json_encode($globalJSON, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }
};


$commentaires = getYoutubeComments("LvPzscrOVdc",500);
getAnalyseYT($commentaires);

$data = json_decode(file_get_contents("resultats.json"), true);
echo count($data);

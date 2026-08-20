<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Commentaires YouTube</title>
</head>
<body>
  <h1>Voir les commentaires d'une vidéo</h1>
  <input type="text" id="videoId" placeholder="ID de la vidéo YouTube">
  <button onclick="loadComments()">Charger</button>

  <ul id="comments"></ul>

  <script>

    function loadComments() {
      const videoId = document.getElementById('videoId').value;
      fetch(`api-proxy.php?videoId=${encodeURIComponent(videoId)}&maxResults=10`)
        .then(response => response.json())
        .then(data => {
          const list = document.getElementById('comments');
          list.innerHTML = '';

          if (!data.items) {
            list.innerHTML = '<li>Aucun commentaire trouvé ou erreur.</li>';
            return;
          }

          data.items.forEach(item => {
            const text = item.snippet.topLevelComment.snippet.textDisplay;
            const li = document.createElement('li');
            li.innerHTML = text;
            list.appendChild(li);
          });
        });
    }
    
  </script>
</body>
</html>

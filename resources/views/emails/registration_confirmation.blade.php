<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Confirmation d'inscription</title>
</head>
<body>
  <div style="font-family: Arial, sans-serif; color:#111;">
    <h2>Bienvenue sur Sonora, {{ $user->name }} !</h2>
    <p>Merci pour votre inscription. Voici un récapitulatif de vos informations :</p>
    <ul>
      <li><strong>Nom :</strong> {{ $user->name }}</li>
      <li><strong>Email :</strong> {{ $user->email }}</li>
      <li><strong>Pays :</strong> {{ $user->getCountryNameAttribute() ?? '-' }}</li>
    </ul>
    <p>Tu peux te connecter et commencer à utiliser Sonora.</p>
    <p>Bonne écoute,<br/>L'équipe Sonora</p>
  </div>
</body>
</html>

# Projet Gestion d'une bibliothèque en ligne

    1- Introduction  :
Notre projet Gestion de bibliothèque consiste à faire une librairie en ligne pour la vente et  l’empreint des livres.

    2- Conception et architecture du projet :
a) Diagramme de cas d'utilisation :
    <br>
![image](https://user-images.githubusercontent.com/80357350/151242756-e9d4b998-4015-42b0-a845-9e4546e67fa3.png)
<br><br>
b) Diagramme de classe :
<br>
![image](https://user-images.githubusercontent.com/80357350/151242981-561e5037-311a-4849-b71f-09a934670ca3.png)

    3- Description des Fonctionnalitées Réalisées:
a) Gestion User :
Le visiteur peut * S’inscrire en saisissant son email et son mot de passe (Le mot de passe sera crypté pour la sécurité).
                 * S’authentifier en utilisant son email.(on a utilisé SwiftMailer pour l'envoie de l'email).
                 * Se déconnecter.
L’administrateur peut consulter la liste des utilisateurs inscrit dans notre application.

![image](https://user-images.githubusercontent.com/80357350/151244717-e8d2ec40-150a-4c44-9b60-cfdc65646be4.png)

b) Gestion Produit :

SELECT film.titre as 'Titre', film.resum as 'Resume', film.annee_prod FROM film INNER JOIN genre ON film.id_genre = genre.id_genre WHERE genre.nom = 'erotic' ORDER BY film.annee_prod DESC;

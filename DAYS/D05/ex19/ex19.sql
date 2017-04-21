SELECT datediff(max(date), min(date)) AS 'uptime' FROM historique_membre GROUP BY id_film;

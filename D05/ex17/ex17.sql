SELECT count(id_abo) AS 'nb_abo', floor(avg(prix)) AS 'moy_abo', mod(sum(duree_abo), 42) as 'ft' FROM abonnement;

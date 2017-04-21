SELECT count(*) as 'films' FROM historique_membre WHERE (date >= '2006-10-30' AND date <= '2007-07-27') OR (month(date) = 12 AND day(date) = 24);

CREATE USER 'project-2nd'@'127.0.0.1' IDENTIFIED BY 'oaTx8H034ChsAj6k';
GRANT SELECT, INSERT, UPDATE, DELETE, FILE, CREATE TEMPORARY TABLES, LOCK TABLES, CREATE VIEW, EVENT, TRIGGER, SHOW VIEW, CREATE ROUTINE, ALTER ROUTINE, EXECUTE ON *.* TO 'project-2nd'@'127.0.0.1' IDENTIFIED BY 'oaTx8H034ChsAj6k' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;
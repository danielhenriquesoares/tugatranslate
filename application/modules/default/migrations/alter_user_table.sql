ALTER TABLE users ADD is_active TINYINT NOT NULL DEFAULT 0;
ALTER TABLE users ADD password_attempt_count TINYINT NOT NULL DEFAULT 0;
ALTER TABLE users ADD last_access DATETIME NOT NULL;
ALTER TABLE users ADD last_password_attempt DATETIME NOT NULL;
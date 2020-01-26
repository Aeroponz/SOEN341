CREATE DATABASE bludata;
USE bludata;

CREATE TABLE users (
	u_id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(30) NOT NULL UNIQUE,
	pass VARCHAR(30) NOT NULL,
	email VARCHAR(255),
	rating INT NOT NULL DEFAULT 0,
	PRIMARY KEY (u_id)
);
CREATE TABLE user_profile (
	u_id INT NOT NULL AUTO_INCREMENT,
	hidden BIT NOT NULL DEFAULT 0,
	dark BIT NOT NULL DEFAULT 0,
	pic VARBINARY(65535),
	FOREIGN KEY (u_id) REFERENCES users(u_id)
);
CREATE TABLE follow_tbl (
	u_id INT NOT NULL,
	follows INT NOT NULL,
	FOREIGN KEY (u_id) REFERENCES users(u_id),
	FOREIGN KEY (follows) REFERENCES users(u_id)
);

ALTER TABLE follow_tbl ADD UNIQUE (u_id, follows);

INSERT INTO users (u_id, name, pass, email, rating) VALUES (NULL, 'TestUser0', 'test12345!', 'dummy@email.com', '0');
INSERT INTO user_profile(u_id, hidden, dark, pic) VALUES (NULL, 0, 0, NULL);

INSERT INTO users (u_id, name, pass, email, rating) VALUES (NULL, 'TestUser1', 'test12345!', NULL, '50');
INSERT INTO user_profile(u_id, hidden, dark, pic) VALUES (NULL, 0, 1, NULL);

INSERT INTO users (u_id, name, pass, email, rating) VALUES (NULL, 'TestUser2', 'test12345!', 'dummy2@email.com', '54');
INSERT INTO user_profile(u_id, hidden, dark, pic) VALUES (NULL, 1, 0, NULL);

INSERT INTO users (u_id, name, pass, email, rating) VALUES (NULL, 'TestUser3', 'test12345!', NULL, '-65');
INSERT INTO user_profile(u_id, hidden, dark, pic) VALUES (NULL, 1, 1, NULL);

INSERT INTO users (u_id, name, pass, email, rating) VALUES (NULL, 'TestUser4', 'test12345!', NULL, '100');
INSERT INTO user_profile(u_id, hidden, dark, pic) VALUES (NULL, 0, 1, NULL);

INSERT INTO follow_tbl (u_id, follows) VALUES (1,2);
INSERT INTO follow_tbl (u_id, follows) VALUES (1,3);
INSERT INTO follow_tbl (u_id, follows) VALUES (3,1);
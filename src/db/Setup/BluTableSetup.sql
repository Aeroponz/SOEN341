
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
	FOREIGN KEY (follows) REFERENCES users(u_id),
	PRIMARY KEY (u_id, follows)
);

CREATE TABLE posts(
	p_id INT NOT NULL AUTO_INCREMENT,
	u_id INT NOT NULL,
	img_path VARCHAR(31) UNIQUE,
	txt_content TEXT,
	upvote INT DEFAUlT 0 CHECK (upvote > -1),
	downvote INT DEFAULT 0 CHECK (downvote > -1),
	discoverable CHAR(1) NOT NULL DEFAULT 'n',
	posted_on DATETIME DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (p_id),
	FOREIGN KEY (u_id) REFERENCES users(u_id)
);
ALTER TABLE posts ADD CONSTRAINT CK_content
CHECK ( 
	NOT (img_path IS NULL AND txt_content IS NULL)
);
CREATE TABLE comments(
	c_id INT NOT NULL AUTO_INCREMENT,
	p_id INT NOT NULL,
	u_id INT NOT NULL,
	thread_id INT,
	txt_content TEXT NOT NULL,
	posted_on DATETIME DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (c_id),
	FOREIGN KEY (p_id) REFERENCES posts(p_id),
	FOREIGN KEY (u_id) REFERENCES users(u_id)
);
ALTER TABLE comments 
ADD FOREIGN KEY (thread_id) REFERENCES comments(c_id);
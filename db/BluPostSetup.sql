USE bludata;

CREATE TABLE posts(
	p_id INT NOT NULL AUTO_INCREMENT,
	u_id INT NOT NULL,
	img_path VARCHAR(255),
	txt_content TEXT,
	upvote INT DEFAUlT 0 CHECK (upvote > -1),
	downvote INT DEFAULT 0 CHECK (downvote > -1),
	discorverable CHAR(1) NOT NULL DEFAULT 'n',
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

INSERT INTO posts (u_id, img_path, txt_content) VALUES (1, NULL, "The first post.");
INSERT INTO posts (u_id, img_path, txt_content) VALUES (4, NULL, "The second post.");
INSERT INTO posts (u_id, img_path, txt_content) VALUES (2, NULL, "The 3rd post.");
INSERT INTO posts (u_id, img_path, txt_content) VALUES (1, NULL, "Blu is cool.");

INSERT INTO comments(p_id, u_id, txt_content) VALUES (1, 3, "The first comment.");
INSERT INTO comments(p_id, u_id, txt_content) VALUES (1, 2, "The second comment.");
INSERT INTO comments(p_id, u_id, txt_content) VALUES (4, 4, "Yeah it is!");
INSERT INTO comments(p_id, u_id, thread_id, txt_content) VALUES (4, 3, 3, "too late to call 'first'. darn.");

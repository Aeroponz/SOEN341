USE bludata;

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

INSERT INTO posts (u_id, img_path, txt_content) VALUES (1, NULL, "The first post.");
INSERT INTO posts (u_id, img_path, txt_content) VALUES (4, "images/meme_test_pic.png", "The second post.");
INSERT INTO posts (u_id, img_path, txt_content) VALUES (2, NULL, "The 3rd post.");
INSERT INTO posts (u_id, img_path, txt_content) VALUES (1, "images/spynapple.gif", "Blu is cool.");

INSERT INTO comments(p_id, u_id, txt_content) VALUES (1, 3, "The first comment.");
INSERT INTO comments(p_id, u_id, txt_content) VALUES (1, 2, "The second comment.");
INSERT INTO comments(p_id, u_id, txt_content) VALUES (4, 4, "Yeah it is!");
INSERT INTO comments(p_id, u_id, thread_id, txt_content) VALUES (4, 3, 3, "too late to call 'first'. darn.");
